<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class BattlesController extends Controller
{
    // 禁用 Yii 的 layout，让 HTML 文件直接访问
    public $layout = false;

    public function actionIndex()
    {
        // 直接显示中国地图
        return $this->actionShowMap('中国地图.html');
    }

    public function actionShowMap($file = '中国地图.html')
    {
        // 安全检查：防止目录遍历攻击
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
        $this->layout = '@app/views/layouts/main'; // 使用正常的 layout
        return $this->render('index');
    }
}
