<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Hero $model */

$this->title = 'Create Hero';
$this->params['breadcrumbs'][] = ['label' => 'Heroes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hero-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
