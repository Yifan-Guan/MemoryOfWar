<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Province;
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
        // 显示省份列表，从数据库获取
        $this->layout = '@app/views/layouts/main';
        $provinces = Province::getAllOrdered();
        return $this->render('index', ['provinces' => $provinces]);
    }

    public function actionProvince($id)
    {
        // 根据省份ID显示对应的HTML页面
        $province = Province::findOne($id);
        if (!$province) {
            throw new NotFoundHttpException('省份不存在');
        }

        $filepath = Yii::getAlias('@frontend/web/battles/' . $province->html_file);
        if (!file_exists($filepath)) {
            throw new NotFoundHttpException('页面文件不存在');
        }

        Yii::$app->response->format = 'html';
        return file_get_contents($filepath);
    }
}
