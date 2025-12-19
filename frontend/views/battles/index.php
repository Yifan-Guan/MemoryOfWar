<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = '重大战役';
$this->params['breadcrumbs'][] = $this->title;

// 获取 battles 目录下的所有 HTML 文件
$battlesDir = Yii::getAlias('@frontend/web/battles');
$htmlFiles = [];
if (is_dir($battlesDir)) {
    $files = scandir($battlesDir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $htmlFiles[] = $file;
        }
    }
}
sort($htmlFiles);
?>

<div class="battles-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="battles-list" style="margin: 20px 0;">
        <p>选择一个地区查看相关战役信息：</p>
        <ul class="list-group" style="display: flex; flex-wrap: wrap; gap: 10px;">
            <?php foreach ($htmlFiles as $file): ?>
                <?php 
                    $filename = pathinfo($file, PATHINFO_FILENAME);
                    // 跳过不需要的文件
                    if (in_array($file, ['index.html', 'start.html', 'start_c_1.html', 'start_with_pages.html'])) {
                        continue;
                    }
                ?>
                <li class="list-group-item" style="flex: 0 0 auto;">
                    <?= Html::a($filename, ['/battles/view', 'file' => $file], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
