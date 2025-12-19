<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Major Battles';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="battles-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a('Create Battles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="battles-content">
        <!-- 在这里添加您的内容 -->
        <p>欢迎来到 Major Battles 页面</p>
    </div>
</div>
