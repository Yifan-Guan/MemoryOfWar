<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use common\models\Province;

/**
 * Battles controller
 */
class BattlesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'search-province' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    /**
     * 显示省份列表页面
     */
    public function actionIndex()
    {
        $provinces = Province::getAllOrdered();
        return $this->render('index', [
            'provinces' => $provinces,
        ]);
    }

    /**
     * 搜索省份API
     * 
     * @return array JSON响应
     */
    public function actionSearchProvince()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $name = Yii::$app->request->get('name') ?: Yii::$app->request->post('name');
        
        if (empty($name)) {
            return [
                'success' => false,
                'message' => '请输入省份名称'
            ];
        }
        
        // 去除"省"、"市"、"自治区"等后缀进行模糊匹配
        $searchName = trim($name);
        
        // 尝试精确匹配
        $province = Province::find()
            ->where(['name' => $searchName])
            ->one();
        
        // 如果精确匹配失败，尝试模糊匹配
        if (!$province) {
            // 去除常见后缀
            $cleanName = preg_replace('/(省|市|自治区|维吾尔|回族|壮族)/', '', $searchName);
            
            $province = Province::find()
                ->where(['like', 'name', $cleanName])
                ->one();
        }
        
        if ($province) {
            return [
                'success' => true,
                'data' => [
                    'id' => $province->id,
                    'name' => $province->name,
                    'url' => $province->getHtmlUrl(),
                    'description' => $province->description,
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => '未找到省份 "' . $searchName . '"，请检查输入是否正确'
            ];
        }
    }

    /**
     * 查看某个省份的详情
     */
    public function actionProvince($id)
    {
        $province = Province::findOne($id);
        
        if ($province) {
            // 重定向到对应的HTML页面
            return $this->redirect($province->getHtmlUrl());
        } else {
            throw new \yii\web\NotFoundHttpException('省份不存在');
        }
    }
}
