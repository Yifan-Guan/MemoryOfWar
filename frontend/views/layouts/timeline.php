<?php
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Breadcrumbs;
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        :root {
            --timeline-color: #dc3545;
            --timeline-bg: #ffffff;
            --content-bg: #f8f9fa;
            --primary-red: #dc3545;
            --dark-red: #c82333;
            --light-gray: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', 'Microsoft YaHei', sans-serif;
            background-color: #f5f5f5;
        }
        
        .main-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
            min-height: 80vh;
        }
        
        .timeline-section {
            background-color: var(--timeline-bg);
            border-right: 2px solid var(--light-gray);
            height: 100%;
            padding: 0;
        }
        
        .content-section {
            background-color: var(--content-bg);
            padding: 0;
        }
        
        .phase-title {
            background-color: var(--primary-red);
            color: white;
            padding: 12px 20px;
            margin: 0;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .event-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .event-item {
            padding: 12px 20px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .event-item:hover {
            background-color: #f8f9fa;
        }
        
        .event-item.active {
            background-color: #dc3545;
            color: white;
        }
        
        .event-item.active::before {
            content: '';
            position: absolute;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-left: 10px solid #dc3545;
        }
        
        .event-title {
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .event-date {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .event-item.active .event-date {
            color: rgba(255,255,255,0.8);
        }
        
        .content-header {
            background-color: var(--primary-red);
            color: white;
            padding: 25px 30px;
            margin-bottom: 0;
        }
        
        .main-title {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .content-wrapper {
            padding: 30px;
            height: calc(100% - 100px);
            overflow-y: auto;
        }
        
        .event-detail-title {
            color: var(--dark-red);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--primary-red);
            padding-bottom: 10px;
        }
        
        .event-subtitle {
            color: #6c757d;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        .event-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        
        .info-row {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #eee;
        }
        
        .info-label {
            font-weight: bold;
            color: var(--primary-red);
            min-width: 100px;
            display: inline-block;
        }
        
        .event-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .image-caption {
            text-align: center;
            color: #666;
            font-style: italic;
            margin-top: 8px;
            font-size: 0.9rem;
        }
        
        .event-description {
            line-height: 1.8;
            font-size: 1.05rem;
            text-align: justify;
        }
        
        .loading {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        
        .timeline-vertical {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline-vertical::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 3px;
            background-color: var(--primary-red);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -33px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary-red);
            border: 3px solid white;
            box-shadow: 0 0 0 3px var(--primary-red);
        }
        
        @media (max-width: 768px) {
            .main-title {
                font-size: 1.8rem;
            }
            
            .content-wrapper {
                padding: 20px;
            }
            
            .timeline-section, .content-section {
                height: auto;
            }
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<?php $events = ['part1' => []]; ?>

<div class="container-fluid py-4">
    <div class="row main-container mx-auto" style="max-width: 1400px;">
        <!-- 时间轴区域 -->
        <div class="col-lg-4 col-md-5 timeline-section">
            <?= $this->render('@app/views/timeline/_timeline', ['events' => $events]) ?>
        </div>
        
        <!-- 内容展示区域 -->
        <div class="col-lg-8 col-md-7 content-section">
            <?= $content ?>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>