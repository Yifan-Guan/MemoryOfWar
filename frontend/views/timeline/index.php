<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Timeline;

/* @var $this yii\web\View */
/* @var $events array */
/* @var $firstEvent Timeline|null */

$this->title = '抗日战争历史事件';

$currentEvent = $firstEvent;
$detailUrl = Url::to(['timeline/detail']);
?>

<div class="container-fluid py-3">
    <div class="row g-3">
        <!-- 左侧时间轴 -->
        <div class="col-12 col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <strong>时间轴</strong>
                </div>
                <div class="card-body p-0">
                    <?= $this->render('@app/views/timeline/_timeline', ['events' => $events]) ?>
                </div>
            </div>
        </div>

        <!-- 右侧事件详情 -->
        <div class="col-12 col-md-8">
            <div class="card shadow-sm" id="contentArea">
                <div class="card-body">
                <?php if ($currentEvent): ?>
                    <div class="event-content">
                        <h2 class="event-detail-title"><?= Html::encode($currentEvent->title) ?></h2>
                        <?php if ($currentEvent->subtitle): ?>
                            <div class="event-subtitle text-muted mb-2"><?= Html::encode($currentEvent->subtitle) ?></div>
                        <?php endif; ?>
                        <div class="event-info mb-3">
                            <?php if ($currentEvent->date): ?>
                                <div class="info-row"><span class="info-label">时间：</span><?= Html::encode($currentEvent->date) ?></div>
                            <?php endif; ?>
                            <?php if ($currentEvent->alias): ?>
                                <div class="info-row"><span class="info-label">别称：</span><?= Html::encode($currentEvent->alias) ?></div>
                            <?php endif; ?>
                        </div>
                        <?php if ($currentEvent->image_path): ?>
                            <?= Html::img($currentEvent->image_path, [
                                'class' => 'event-image',
                                'alt' => Html::encode($currentEvent->title),
                                'onerror' => "this.src='https://via.placeholder.com/800x400/DC3545/FFFFFF?text=历史图片'"
                            ]) ?>
                            <?php if ($currentEvent->image_caption): ?>
                                <div class="image-caption"><?= Html::encode($currentEvent->image_caption) ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="event-description">
                            <?= nl2br(Html::encode($currentEvent->description)) ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <h5>暂无数据</h5>
                        <p>请检查数据库是否有事件数据</p>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$currentEventIdJS = $currentEvent ? $currentEvent->id : 'null';
$js = <<<JS

let currentEventId = {$currentEventIdJS};

// 点击时间轴条目
$(document).on('click', '.event-item', function() {
    const eventId = $(this).data('id');
    if (!eventId || eventId === currentEventId) return;
    loadEventDetail(eventId);
});

function loadEventDetail(eventId) {
    // 加载状态
    $('#contentArea .card-body').html(
        '<div class="text-center py-4">' +
            '<div class="spinner-border text-danger" role="status"><span class="visually-hidden">加载中...</span></div>' +
            '<p class="mt-3 mb-0">加载中...</p>' +
        '</div>'
    );

    // 激活态
    $('.event-item').removeClass('active');
    $('.event-item[data-id="' + eventId + '"]').addClass('active');

    // 请求详情
    $.ajax({
        url: '{$detailUrl}',
        method: 'GET',
        data: { id: eventId },
        dataType: 'json'
    }).done(function(response) {
        if (response && response.success) {
            renderEventDetail(response.data);
            currentEventId = eventId;
        } else {
            showError('加载失败');
        }
    }).fail(function() {
        showError('网络错误，请重试');
    });
}

function renderEventDetail(data) {
    const imageHtml = data.image_path ? `
        <img src="\${data.image_path}" class="event-image" alt="\${data.title}"
                 onerror="this.src='https://via.placeholder.com/800x400/DC3545/FFFFFF?text=历史图片'">` : '';
    const captionHtml = data.image_caption ? `<div class="image-caption">\${data.image_caption}</div>` : '';
    let infoHtml = '<div class="event-info mb-3">';
    if (data.date) infoHtml += `<div class="info-row"><span class="info-label">时间：</span>\${data.date}</div>`;
    if (data.alias) infoHtml += `<div class="info-row"><span class="info-label">别称：</span>\${data.alias}</div>`;
    infoHtml += '</div>';

    const html = `
        <div class="event-content">
            <h2 class="event-detail-title">\${data.title}</h2>
            \${data.subtitle ? `<div class="event-subtitle text-muted mb-2">\${data.subtitle}</div>` : ''}
            \${infoHtml}
            \${imageHtml}
            \${captionHtml}
            <div class="event-description">\${(data.description || '').replace(/\\n/g, '<br>')}</div>
        </div>`;

    $('#contentArea .card-body').html(html);
}

function showError(message) {
    $('#contentArea .card-body').html(
        `<div class="empty-state">
                <h5 class="text-danger mb-2">错误</h5>
                <p class="mb-3">\${message}</p>
                \${currentEventId ? '<button class="btn btn-danger" onclick="loadEventDetail(currentEventId)">重新加载</button>' : ''}
         </div>`
    );
}

// 页面初始化激活第一个条目
$(function() {
    if (currentEventId) {
        console.log('激活事件ID:', currentEventId);
        $('.event-item[data-id="' + currentEventId + '"]').addClass('active');
    }
});
JS;

$this->registerJs($js);

$css = <<<CSS
.timeline-vertical { position: relative; padding-left: 1.5rem; }
.timeline-vertical::before { content: ''; position: absolute; left: 0.5rem; top: 0; bottom: 0; width: 3px; background-color: #dc3545; }
.phase-title { background-color: #dc3545; color: #fff; padding: .5rem .75rem; margin: 0; font-weight: 600; }
.event-list { list-style: none; margin: 0; padding: 0; }
.event-item { padding: .75rem; border-bottom: 1px solid #eee; cursor: pointer; position: relative; }
.event-item:hover { background-color: #f8f9fa; }
.event-item.active { background-color: #dc3545; color: #fff; }
.event-item.active .event-date { color: rgba(255,255,255,.85); }
.event-title { font-weight: 600; }
.event-date { font-size: .875rem; color: #6c757d; }
.event-detail-title { color: #c82333; font-size: 1.5rem; font-weight: 700; border-bottom: 2px solid #dc3545; padding-bottom: .5rem; }
.event-image { width: 100%; max-height: 380px; object-fit: cover; border-radius: .5rem; margin: 1rem 0; }
.image-caption { text-align: center; color: #666; font-style: italic; font-size: .9rem; }
.event-info .info-row { margin-bottom: .5rem; padding-bottom: .5rem; border-bottom: 1px dashed #eee; }
.event-info .info-label { font-weight: 600; color: #dc3545; min-width: 80px; display: inline-block; }
.empty-state { text-align: center; padding: 2rem; color: #666; }
CSS;
$this->registerCss($css);

?>