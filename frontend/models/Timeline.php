<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "timeline".
 *
 * @property int $id 主键ID
 * @property string $phase 阶段：局部抗战、全面抗战
 * @property int $order 显示顺序
 * @property string $title 事件标题
 * @property string|null $subtitle 副标题
 * @property string|null $date 日期
 * @property string|null $alias 事件别称
 * @property string $description 事件描述
 * @property string|null $image_path 图片路径
 * @property string|null $image_caption 图片说明
 */
class Timeline extends \yii\db\ActiveRecord
{
    public const PHASE_LOCAL = '局部抗战';
    public const PHASE_FULL = '全面抗战';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timeline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subtitle', 'date', 'alias', 'image_path', 'image_caption'], 'default', 'value' => null],
            [['order'], 'default', 'value' => 0],
            [['phase', 'title', 'description'], 'required'],
            [['order'], 'integer'],
            [['description'], 'string'],
            [['phase', 'date'], 'string', 'max' => 50],
            [['title', 'subtitle', 'alias'], 'string', 'max' => 200],
            [['image_path', 'image_caption'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phase' => 'Phase',
            'order' => 'Order',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'date' => 'Date',
            'alias' => 'Alias',
            'description' => 'Description',
            'image_path' => 'Image Path',
            'image_caption' => 'Image Caption',
        ];
    }

    /**
     * 获取所有阶段
     */
    public static function getPhases()
    {
        return [
            self::PHASE_LOCAL => '局部抗战',
            self::PHASE_FULL => '全面抗战',
        ];
    }


    /**
     * 按阶段分组获取事件
     */
    public static function getEventsByPhase()
    {
        $phaseOrders = [
            '局部抗战' => 1,
            '全面抗战' => 2,
            '战略相持' => 3,
            '战略反攻' => 4,
            '胜利时刻' => 5,
        ];

        $events = self::find()
            ->orderBy(['phase' => SORT_ASC, 'order' => SORT_ASC])
            ->all();
            
        $grouped = [];
        foreach ($events as $event) {
            $grouped[$event->phase][] = $event;
        }

        uksort($grouped, function($a, $b) use ($phaseOrders) {
            return $phaseOrders[$a] <=> $phaseOrders[$b];
        });
        
        return $grouped;
    }

    /**
     * 获取所有事件（用于AJAX）
     */
    public static function getAllEventsArray()
    {
        $events = self::find()
            ->orderBy(['phase' => SORT_ASC, 'order' => SORT_ASC])
            ->asArray()
            ->all();
            
        $grouped = [];
        foreach ($events as $event) {
            $grouped[$event['phase']][] = $event;
        }
        
        return $grouped;
    }

}
