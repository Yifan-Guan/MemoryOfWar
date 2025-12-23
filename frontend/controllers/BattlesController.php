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
        
        // 如果数据库不可用，则直接走文件系统回退，避免抛出连接异常
        $dbAvailable = false;
        try {
            Yii::$app->db->open();
            $dbAvailable = Yii::$app->db->isActive;
        } catch (\Throwable $e) {
            $dbAvailable = false;
        }

        // 去除"省"、"市"、"自治区"等后缀进行模糊匹配
        $searchName = trim($name);
        
        // 尝试精确匹配
        $province = null;
        if ($dbAvailable) {
            try {
                $province = Province::find()
                    ->where(['name' => $searchName])
                    ->one();
            } catch (\Throwable $e) {
                // 数据库异常则继续回退
            }
        }
        
        // 如果精确匹配失败，尝试模糊匹配
        if (!$province && $dbAvailable) {
            // 去除常见后缀
            $cleanName = preg_replace('/(省|市|自治区|维吾尔|回族|壮族)/u', '', $searchName);
            
            try {
                $province = Province::find()
                    ->where(['like', 'name', $cleanName])
                    ->one();
            } catch (\Throwable $e) {
                // 忽略，继续回退
            }
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
        }

        // 数据库无结果或不可用，走文件系统回退：匹配 battles 目录下的 HTML 文件
        $battlesDir = Yii::getAlias('@frontend/web/battles');
        $candidates = [];
        $candidates[] = $searchName . '.html';
        $candidates[] = preg_replace('/(省|市|自治区|维吾尔|回族|壮族)/u', '', $searchName) . '.html';

        foreach ($candidates as $fileName) {
            $fullPath = $battlesDir . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($fullPath)) {
                return [
                    'success' => true,
                    'data' => [
                        'id' => null,
                        'name' => $searchName,
                        'url' => '/battles/' . $fileName,
                        'description' => null,
                    ]
                ];
            }
        }

        // 最后尝试在所有 HTML 文件中做包含匹配
        $files = glob($battlesDir . DIRECTORY_SEPARATOR . '*.html');
        $needle = preg_replace('/(省|市|自治区|维吾尔|回族|壮族)/u', '', $searchName);
        foreach ($files as $path) {
            $base = basename($path);
            $nameNoExt = mb_substr($base, 0, mb_strlen($base) - 5); // 去掉 .html
            if ($needle !== '' && mb_strpos($nameNoExt, $needle) !== false) {
                return [
                    'success' => true,
                    'data' => [
                        'id' => null,
                        'name' => $searchName,
                        'url' => '/battles/' . $base,
                        'description' => null,
                    ]
                ];
            }
        }

        return [
            'success' => false,
            'message' => '未找到省份 "' . $searchName . '"，请检查输入是否正确'
        ];
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
