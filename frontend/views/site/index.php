<?php

use yii\bootstrap5\Html;

/** @var yii\web\View $this */

$this->title = 'Memory Of War';
?>
<div class="site-index">

    <?= Html::img('@web/background.png', ['class' => 'img-fluid mb-4']) ?>
    <div class="body-content">
        <div class="row">
            <div class="col-lg-5 card m-4">
                <h2 class="m-2">时间线</h2>

                <p class="m-3">忆往昔峥嵘岁月稠，回顾抗战中那些生死攸关的时刻与指引中华民族走向
                    胜利的精神灯塔。</p>

            </div>
            <div class="col-lg-5 card m-4">
                <h2 class="m-2">重大战役</h2>

                <p class="m-3">一寸山河一寸血，铭记中华大地上的每一场浴血奋战。</p>

            </div>
            <div class="col-lg-5 card m-4">
                <h2 class="m-2">词云图</h2>

                <p class="m-3">字字泣血，诉说抗战岁月的点点滴滴。</p>

            </div>
            <div class="col-lg-5 card m-4">
                <h2 class="m-2">英雄查询</h2>

                <p class="m-3">今天的美好生活，离不开那些为国捐躯的英雄们。</p>

            </div>
        </div>

    </div>
</div>
