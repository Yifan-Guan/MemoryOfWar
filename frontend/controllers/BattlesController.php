<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class BattlesController extends Controller
{
    // 禁用布局，直接输出 Axure 生成的静态页面
    public $layout = false;

    public function actionIndex()
    {
        // 直接显示中国地图静态页面
        return $this->actionShowMap('中国地图.html');
    }

    public function actionShowMap($file = '中国地图.html')
    {
        $basename = basename($file);
        $filepath = Yii::getAlias('@frontend/web/battles/' . $basename);
        
        if (!file_exists($filepath) || pathinfo($filepath, PATHINFO_EXTENSION) !== 'html') {
            throw new NotFoundHttpException('页面不存在');
        }

        Yii::$app->response->format = 'html';
        return file_get_contents($filepath);
    }

    public function actionList()
    {
        // 如果需要显示列表，可改回使用布局渲染 index 视图
        $this->layout = '@app/views/layouts/main';
        return $this->render('index');
    }
}
