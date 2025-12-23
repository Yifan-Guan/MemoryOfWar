<?php

/** @var yii\web\View $this */
/** @var common\models\Province[] $provinces */

use yii\helpers\Html;

$this->title = '重大战役 - 省份列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="battles-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="battles-list" style="margin: 20px 0;">
        <p><?= Html::a('查看中国地图', \yii\helpers\Url::to('@web/battles/中国地图.html'), ['class' => 'btn btn-success', 'target' => '_blank']) ?></p>
        
        <p>选择一个省份查看相关战役信息：</p>
        
        <div class="row">
            <?php foreach ($provinces as $province): ?>
                <div class="col-md-3 col-sm-4 col-6 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= Html::encode($province->name) ?></h5>
                            <p class="card-text text-muted small"><?= Html::encode($province->description) ?></p>
                            <?= Html::a('查看详情', ['/battles/province', 'id' => $province->id], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
