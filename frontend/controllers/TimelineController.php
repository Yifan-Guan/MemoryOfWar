<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use frontend\models\Timeline;

class TimelineController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * 主页面
     */
    public function actionIndex()
    {
        $events = Timeline::getEventsByPhase();
        
        // 默认显示第一个事件
        $firstEvent = !empty($events) ? reset($events)[0] : null;
        
        return $this->render('index', [
            'events' => $events,
            'firstEvent' => $firstEvent,
        ]);
    }

    /**
     * 获取事件详情（AJAX接口）
     */
    public function actionDetail($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $eventId = (int) $id;
        $event = Timeline::findOne($eventId);
        
        if (!$event) {
            throw new NotFoundHttpException('事件不存在');
        }
        
        return [
            'success' => true,
            'data' => [
                'id' => $event->id,
                'title' => $event->title,
                'subtitle' => $event->subtitle,
                'date' => $event->date,
                'alias' => $event->alias,
                'description' => $event->description,
                'image_path' => $event->image_path,
                'image_caption' => $event->image_caption,
                'phase' => $event->phase,
            ],
        ];
    }

    /**
     * 获取所有事件（AJAX接口）
     */
    public function actionAllEvents()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $events = Timeline::getAllEventsArray();
        
        return [
            'success' => true,
            'data' => $events
        ];
    }
}