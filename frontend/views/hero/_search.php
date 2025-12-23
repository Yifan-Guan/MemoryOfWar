<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="hero-search" style="background: #e6e6e6; padding: 15px; margin-bottom: 20px; border-radius: 5px;">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            // 使用 Flex 布局，强制所有元素在一行显示，并且居中对齐
            'style' => 'display: flex; justify-content: center; align-items: center; gap: 20px;'
        ],
    ]); ?>

    <div style="display: flex; align-items: center;">
        <label style="margin-right: 8px; margin-bottom: 0; font-weight: normal;">搜索英雄：</label>
        <?= $form->field($model, 'name')->textInput([
            'placeholder' => '请输入姓名...', 
            'style' => 'width: 180px;'
        ])->label(false) ?>
    </div>

    <div style="display: flex; align-items: center;">
        <label style="margin-right: 8px; margin-bottom: 0; font-weight: normal;">按战区查看：</label>
        <?= $form->field($model, 'war_zone')->dropDownList(
            [
                '东北' => '东北战区',
                '华北' => '华北战区',
                '华中' => '华中战区',
                '华东' => '华东战区',
                '华南' => '华南战区',
            ], 
            ['prompt' => '--- 全部战区 ---', 'style' => 'width: 160px;']
        )->label(false) ?>
    </div>

    <div style="display: flex; gap: 10px;">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary', 'style' => 'background-color: #d9534f; border-color: #d43f3a;']) ?>
        <?= Html::a('重置', ['index'], ['class' => 'btn btn-default', 'style' => 'background-color: white;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>