<?php

/** @var yii\web\View $this */
/** @var string $file */

$this->title = pathinfo($file, PATHINFO_FILENAME);
?>

<div class="battles-view">
    <p>
        <?= \yii\helpers\Html::a('返回列表', ['/battles/index'], ['class' => 'btn btn-secondary']) ?>
    </p>
    
    <!-- 直接使用相对路径访问 HTML 文件，浏览器会自动找到 /battles/ 目录下的文件 -->
    <iframe src="/battles/<?= urlencode($file) ?>" 
            style="width: 100%; height: 800px; border: 1px solid #ccc;"
            frameborder="0"
            allowfullscreen>
    </iframe>
</div>
