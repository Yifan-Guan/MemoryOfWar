<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Hero */

$this->title = $model->name;
?>

<div style="background-color: #d9534f; color: white; padding: 15px 20px; border-radius: 4px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h2 style="margin: 0; font-weight: bold;">
        <?= Html::encode($model->name) ?> 
        <small style="color: #fdd; font-size: 60%; margin-left: 10px;">英雄事迹档案</small>
    </h2>
</div>

<div class="hero-view">
    <div class="row">
        
        <div class="col-md-4">
            <div style="border: 5px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.15); border-radius: 4px; overflow: hidden; margin-bottom: 20px;">
                <img src="<?= Yii::getAlias('@web') . '/images/heroes/' . $model->photo_path ?>" 
                     alt="<?= $model->name ?>" 
                     style="width: 100%; height: auto; display: block;">
            </div>

            <?= Html::a('← 返回英雄列表', ['index'], [
                'class' => 'btn btn-default btn-block', 
                'style' => 'border-color: #d9534f; color: #d9534f; font-weight: bold;'
            ]) ?>
        </div>

        <div class="col-md-8">
            
            <div class="panel panel-default" style="border-top: 3px solid #d9534f;">
                <div class="panel-heading" style="font-weight: bold; background-color: #f9f9f9; color: #d9534f;">基本信息</div>
                <table class="table table-bordered table-striped" style="margin-bottom: 0;">
                    <tbody>
                        <tr>
                            <th style="width: 120px; text-align: right; vertical-align: middle;">英雄姓名</th>
                            <td><h3 style="margin: 5px 0; font-weight: bold; color: #d9534f;"><?= Html::encode($model->name) ?></h3></td>
                        </tr>
                        <tr>
                            <th style="text-align: right;">生卒年</th>
                            <td><?= Html::encode($model->life_span) ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: right;">身份</th>
                            <td><?= Html::encode($model->identity) ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: right;">战区</th>
                            <td><span class="label label-danger"><?= Html::encode($model->war_zone) ?></span></td>
                        </tr>
                        <tr>
                            <th style="text-align: right;">名言</th>
                            <td style="font-style: italic; color: #666;">"<?= Html::encode($model->quote) ?>"</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="panel panel-default" style="border-top: 3px solid #d9534f; margin-top: 20px;">
                <div class="panel-heading" style="font-weight: bold; background-color: #f9f9f9; color: #d9534f;">详细事迹</div>
                <div class="panel-body" style="padding: 20px; font-size: 16px; line-height: 1.8; min-height: 150px;">
                    <?php if ($model->description): ?>
                        <?= nl2br(Html::encode($model->description)) ?>
                    <?php else: ?>
                        <p style="color: #999; text-align: center; padding-top: 30px;">（暂无详细录入...）</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>