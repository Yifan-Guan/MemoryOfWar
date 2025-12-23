<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\HeroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '英雄查询';
?>

<style>
    /* 强制分页列表横向排列 */
    ul.pagination {
        display: inline-flex;
        padding-left: 0;
        list-style: none;
        border-radius: 4px;
    }
    
    /* 给每个按钮之间加 5px 的间距 */
    ul.pagination > li {
        display: inline;
        margin: 0 5px; /* <--- 这就是你要的间隔！ */
    }

    /* 美化按钮外观：变成圆角方块 */
    ul.pagination > li > a, ul.pagination > li > span {
        position: relative;
        float: left;
        padding: 8px 16px; /* 按钮做大一点，更好点 */
        line-height: 1.5;
        text-decoration: none;
        color: #d9534f; /* 字体红色 */
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 6px; /* 圆角 */
        transition: all 0.3s;
    }

    /* 鼠标悬停时的效果 */
    ul.pagination > li > a:hover {
        background-color: #eee;
        color: #a94442;
    }

    /* 当前选中页面的样式 (变成实心红) */
    ul.pagination > .active > a, 
    ul.pagination > .active > span, 
    ul.pagination > .active > a:hover, 
    ul.pagination > .active > span:hover {
        color: #fff;
        background-color: #d9534f; /* 红色背景 */
        border-color: #d9534f;
        cursor: default;
    }
    
    /* 禁用状态的样式 (比如到了最后一页) */
    ul.pagination > .disabled > span,
    ul.pagination > .disabled > span:hover,
    ul.pagination > .disabled > a,
    ul.pagination > .disabled > a:hover {
        color: #777;
        background-color: #fff;
        border-color: #ddd;
        cursor: not-allowed;
    }
</style>

<div style="background-color: #d9534f; color: white; padding: 20px; text-align: center; margin-bottom: 20px; border-radius: 4px;">
    <h2 style="margin: 0; font-weight: bold;">抗战英雄事迹查询系统</h2>
    <p style="margin-top: 10px; font-size: 16px;">★ 铭记历史 · 致敬英雄 · 珍爱和平 ★</p>
</div>

<div class="hero-search" style="background: #e6e6e6; padding: 20px; margin-bottom: 20px; border-radius: 5px;">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
</div>

<div class="row">
    <?php 
    $models = $dataProvider->getModels(); 
    ?>
    
    <?php foreach ($models as $model): ?>
    <div class="col-md-3 col-sm-6"> 
        <div class="panel panel-danger" style="text-align: center; border: 1px solid #d9534f; border-radius: 8px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <div class="panel-body" style="background-color: #d9534f; padding: 15px;">
                <div style="width: 100px; height: 120px; margin: 0 auto 10px; border: 2px solid white; overflow: hidden;">
                    <img src="<?= Yii::getAlias('@web') . '/images/heroes/' . $model->photo_path ?>" 
                         alt="<?= $model->name ?>" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                
                <h4 style="color: white; margin-top: 5px; font-weight: bold;">
                    <?= Html::encode($model->name) ?>
                    <br>
                    <small style="color: #eee; font-size: 12px;"><?= Html::encode($model->life_span) ?></small>
                </h4>
            </div>
            
            <div class="panel-footer" style="background-color: #d43f3a; color: white; border-top: none; padding: 10px; height: 150px; position: relative;">
                <p style="font-size: 13px; font-weight: bold; margin-bottom: 5px; height: 35px; overflow: hidden;">
                    <?= Html::encode($model->identity) ?>
                </p>
                <p style="font-style: italic; font-size: 12px; margin-bottom: 30px; opacity: 0.9; height: 40px; overflow: hidden;">
                    "<?= Html::encode($model->quote) ?>"
                </p>
                
                <div style="position: absolute; bottom: 15px; width: 100%; left: 0;">
                    <?= Html::a('查看事迹详情', ['view', 'id' => $model->id], [
                        'class' => 'btn btn-default btn-xs', 
                        'style' => 'color: #FFD700; background-color: transparent; border: 1px solid #FFD700; font-weight: bold; border-radius: 20px; padding: 5px 15px;'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div style="display: flex; justify-content: center; margin-top: 30px; margin-bottom: 50px;">
    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination,
        // 这里不需要额外的 options，顶部的 CSS 会自动抓取 ul.pagination
    ]) ?>
</div>