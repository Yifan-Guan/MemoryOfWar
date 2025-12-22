<?php
use yii\helpers\Json;
use frontend\models\WordCloud;

// 从 Controller 获取数据，如果没有则从 Model 获取
if (empty($words)) {
    $words = WordCloud::getWords();
}
if (empty($pageTitle)) {
    $pageTitle = WordCloud::getPageTitle();
}
if (empty($pageDescription)) {
    $pageDescription = WordCloud::getPageDescription();
}

$this->title = $pageTitle;


$jsonWords = Json::htmlEncode($words);
?>

<style>
body { font-family: "Microsoft YaHei", Arial, sans-serif; }
.wordcloud-wrap { max-width: 1000px; margin: 24px auto; text-align: center; }
.wordcloud { display: inline-block; width: 100%; padding: 40px 20px; border-radius: 8px; background: linear-gradient(180deg,#fff,#f7f7f7); box-shadow: 0 2px 8px rgba(0,0,0,0.06); position: relative; }
.word-item { cursor: pointer; transition: transform .12s ease, color .12s; user-select: none; position: absolute; }
.word-item:hover { transform: scale(1.06); color: #c0392b; }
.wc-title { margin: 0 0 12px 0; font-size: 20px; color: #333; }
.wc-modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.45); display: none; align-items: center; justify-content: center; z-index: 9999; }
.wc-modal { background: white; padding: 20px; border-radius: 6px; max-width: 720px; width: 90%; box-shadow: 0 10px 30px rgba(0,0,0,.2); position: relative; }
.wc-modal h2 { margin: 0 0 8px 0; font-size: 22px; }
.wc-modal p { margin: 0; color: #444; line-height: 1.6; white-space: pre-line; }
.wc-modal .close { position: absolute; right: 18px; top: 12px; cursor: pointer; font-size: 20px; }
</style>

<div class="wordcloud-wrap">
  <h1 class="wc-title"><?= $pageDescription ?></h1>
  <div id="wordcloud" class="wordcloud" aria-label="词云图"></div>
</div>

<!-- 信息弹窗 -->
<div id="wc-backdrop" class="wc-modal-backdrop">
  <div class="wc-modal" role="dialog" aria-modal="true">
    <div class="close" id="wc-close" title="关闭">✕</div>
    <h2 id="wc-title"></h2>
    <p id="wc-desc"></p>
  </div>
</div>

<script>
const WORDS = <?= $jsonWords ?>;

function placeWordsOn80(containerId, words) {
  const container = document.getElementById(containerId);
  container.innerHTML = '';
  container.style.position = 'relative';

  const rect = container.getBoundingClientRect();
  const W = Math.max(600, Math.round(rect.width || 800));
  const H = Math.round(W * 0.6);

  // 绘制遮罩
  const maskCanvas = document.createElement('canvas');
  maskCanvas.width = W; maskCanvas.height = H;
  const mctx = maskCanvas.getContext('2d');
  mctx.fillStyle = 'black';
  mctx.fillRect(0,0,W,H);
  const fontSize = Math.floor(H * 0.9);
  mctx.fillStyle = 'white';
  mctx.textAlign = 'center';
  mctx.textBaseline = 'middle';
  mctx.font = '700 ' + fontSize + 'px "Microsoft YaHei",Arial';
  mctx.fillText('8', W/2 - W*0.2, H/2 + H*0.02);
  mctx.fillText('0', W/2 + W*0.2, H/2 + H*0.02);

  const maskData = mctx.getImageData(0,0,W,H).data;
  function isMask(px, py) {
    if (px < 0 || py < 0 || px >= W || py >= H) return false;
    const idx = (Math.floor(py) * W + Math.floor(px)) * 4;
    // 检查像素是否为白色（"80"的颜色）
    const r = maskData[idx], g = maskData[idx+1], b = maskData[idx+2];
    return r > 200 && g > 200 && b > 200;
  }

  // 粗网格用于占位判断，提高填充效率
  const cell = Math.max(8, Math.floor(W / 100));
  const cols = Math.ceil(W / cell), rows = Math.ceil(H / cell);
  const occ = new Uint8Array(cols * rows);
  function markOccupied(x, y, w, h) {
    const x0 = Math.max(0, Math.floor(x / cell));
    const y0 = Math.max(0, Math.floor(y / cell));
    const x1 = Math.min(cols-1, Math.floor((x + w) / cell));
    const y1 = Math.min(rows-1, Math.floor((y + h) / cell));
    for(let ry=y0; ry<=y1; ry++) for(let rx=x0; rx<=x1; rx++) occ[ry*cols + rx] = 1;
  }
  function areaFree(x,y,w,h,allowPercent=0) {
    const x0 = Math.max(0, Math.floor(x / cell));
    const y0 = Math.max(0, Math.floor(y / cell));
    const x1 = Math.min(cols-1, Math.floor((x + w) / cell));
    const y1 = Math.min(rows-1, Math.floor((y + h) / cell));
    let total = 0, used = 0;
    for(let ry=y0; ry<=y1; ry++) for(let rx=x0; rx<=x1; rx++) { total++; if (occ[ry*cols + rx]) used++; }
    return (used / Math.max(1,total)) <= allowPercent;
  }

  const measureCanvas = document.createElement('canvas');
  const measureCtx = measureCanvas.getContext('2d');
  const weights = words.map(w=>w.weight||1);
  const minW = Math.min(...weights), maxW = Math.max(...weights);
  const minSize = Math.max(10, Math.round(W/90)), maxSize = Math.round(W/14);
  function sizeFor(weight){ if (maxW===minW) return Math.round((minSize+maxSize)/2); return Math.round(minSize + (weight-minW)/(maxW-minW)*(maxSize-minSize)); }

  const palette = ['#ff0000ff','#c0392b','#d0d70aff','#f60a0aff','#e3eb0eff','#e6c626ff','#ea3c2cff'];

  // 首轮放置：为每个词按权重生成副本，先放大词再放小词
  const byWeight = words.slice().sort((a,b)=> (b.weight||0)-(a.weight||0));
  const placedRects = [];

  function tryPlaceText(text, fs, color, attemptsLimit=800, allowOverlap=0) {
    measureCtx.font = fs + 'px "Microsoft YaHei",Arial';
    const metrics = measureCtx.measureText(text);
    const tw = Math.ceil(metrics.width) + 6;
    const th = Math.ceil(fs * 1.05) + 4;

    for(let attempt=0; attempt<attemptsLimit; attempt++) {
      let sx = Math.floor(Math.random()*W), sy = Math.floor(Math.random()*H);
      let triesSeed = 0;
      while(!isMask(sx,sy) && triesSeed < 200) { sx = Math.floor(Math.random()*W); sy = Math.floor(Math.random()*H); triesSeed++; }
      if (!isMask(sx,sy)) continue;
      const maxR = Math.max(W,H);
      const step = Math.max(6, Math.floor(fs/4));
      for(let r=0; r<maxR; r+=step) {
        const angle = (Math.random()*Math.PI*2);
        const cx = Math.round(sx + Math.cos(angle)*r);
        const cy = Math.round(sy + Math.sin(angle)*r);
        const x = cx - Math.floor(tw/2), y = cy - Math.floor(th/2);
        if (x < 0 || y < 0 || x+tw >= W || y+th >= H) continue;
        const centerX = x + tw/2, centerY = y + th/2;
        if (!isMask(centerX, centerY)) continue;
        if (!areaFree(x,y,tw,th, allowOverlap)) continue;
        const span = document.createElement('span');
        span.className = 'word-item';
        span.textContent = text;
        span.style.left = (x / W * 100) + '%';
        span.style.top = (y / H * 100) + '%';
        span.style.fontSize = fs + 'px';
        span.style.lineHeight = th + 'px';
        span.style.color = color;
        span.style.transform = 'rotate(' + ((Math.random()-0.5)*12) + 'deg)';
        span.style.whiteSpace = 'nowrap';
        span.addEventListener('click', ()=>{ const w = words.find(ww=>ww.text===text); showWordInfo(w || {text, desc: ''}); });
        container.appendChild(span);
        placedRects.push({x,y,w:tw,h:th});
        markOccupied(x,y,tw,th);
        return true;
      }
    }
    return false;
  }

  byWeight.forEach((w, idx) => {
    const baseCopies = Math.max(1, Math.round((w.weight||1) / 2));
    const copies = Math.min(6, baseCopies);
    const fs = sizeFor(w.weight||1);
    for(let c=0;c<copies;c++) {
      const fsC = Math.max(10, Math.round(fs * (1 - c*0.12)));
      tryPlaceText(w.text, fsC, palette[idx % palette.length], 900, 0.12);
    }
  });

  const smallWords = words.slice().sort((a,b)=>(a.weight||0)-(b.weight||0));
  const emptyCells = [];
  for(let ry=0; ry<rows; ry++) for(let rx=0; rx<cols; rx++) {
    const cx = rx*cell + cell/2, cy = ry*cell + cell/2;
    if (!occ[ry*cols + rx] && isMask(cx,cy)) emptyCells.push({rx,cx,ry,cy});
  }
  for(let i=emptyCells.length-1;i>0;i--){ const j=Math.floor(Math.random()*(i+1)); [emptyCells[i],emptyCells[j]]=[emptyCells[j],emptyCells[i]]; }

  const fillLimit = Math.min(emptyCells.length, Math.floor((W*H)/(cell*cell) * 0.9));
  let filled = 0;
  for(const cellInfo of emptyCells) {
    if (filled >= fillLimit) break;
    const w = smallWords[Math.floor(Math.random()*smallWords.length)];
    const fs = Math.max(10, Math.round(sizeFor(w.weight||1) * 0.6));
    const twEstimate = Math.ceil((measureCtx.measureText(w.text).width || (fs* w.text.length*0.5))) + 6;
    const x = Math.round(cellInfo.cx - twEstimate/2), y = Math.round(cellInfo.cy - fs/2);
    if (x<0||y<0||x+twEstimate>=W||y+fs>=H) continue;
    if (!isMask(cellInfo.cx, cellInfo.cy)) continue;
    if (!areaFree(x,y,twEstimate,fs, 0.0)) continue;
    const span = document.createElement('span');
    span.className = 'word-item';
    span.textContent = w.text;
    span.style.left = (x / W * 100) + '%';
    span.style.top = (y / H * 100) + '%';
    span.style.fontSize = fs + 'px';
    span.style.lineHeight = fs + 'px';
    span.style.color = palette[Math.floor(Math.random()*palette.length)];
    span.style.whiteSpace = 'nowrap';
    span.addEventListener('click', ()=>showWordInfo(w));
    container.appendChild(span);
    markOccupied(x,y,twEstimate,fs);
    filled++;
  }

  container.style.height = (H / W * 100) + 'vw';
}

function showWordInfo(word) {
  const backdrop = document.getElementById('wc-backdrop');
  document.getElementById('wc-title').textContent = word.text;
  document.getElementById('wc-desc').textContent = word.desc || '暂无介绍';
  backdrop.style.display = 'flex';
}
function hideWordInfo(){ document.getElementById('wc-backdrop').style.display = 'none'; }

document.addEventListener('DOMContentLoaded', function() {
  placeWordsOn80('wordcloud', WORDS);
  window.addEventListener('resize', ()=>{ setTimeout(()=>placeWordsOn80('wordcloud', WORDS),200); });
  document.getElementById('wc-backdrop').addEventListener('click', function(e){ if (e.target === this || e.target.id === 'wc-close') hideWordInfo(); });
  document.getElementById('wc-close').addEventListener('click', hideWordInfo);
});
</script>
          
</div>