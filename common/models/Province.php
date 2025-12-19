<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Province model
 *
 * @property int $id
 * @property string $name 省份名称
 * @property string $html_file 对应的HTML文件名
 * @property string|null $description 省份描述
 * @property int $order 排序
 * @property int $created_at
 * @property int $updated_at
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%province}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'html_file'], 'required'],
            [['description'], 'string'],
            [['order', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['html_file'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '省份名称',
            'html_file' => 'HTML文件',
            'description' => '描述',
            'order' => '排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取省份的HTML文件完整路径
     */
    public function getHtmlUrl()
    {
        return '/battles/' . $this->html_file;
    }

    /**
     * 获取所有省份按排序顺序
     */
    public static function getAllOrdered()
    {
        return self::find()->orderBy(['order' => SORT_ASC])->all();
    }
}
