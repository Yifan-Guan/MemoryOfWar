<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hero".
 *
 * @property int $id
 * @property string $name 姓名
 * @property string $life_span 生卒年
 * @property string $identity 身份
 * @property string $war_zone 战区
 * @property string|null $quote 名言
 * @property string|null $description 详细事迹
 * @property string|null $photo_path 图片文件名
 */
class Hero extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hero';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quote', 'description', 'photo_path'], 'default', 'value' => null],
            [['name', 'life_span', 'identity', 'war_zone'], 'required'],
            [['description'], 'string'],
            [['name', 'life_span', 'war_zone'], 'string', 'max' => 50],
            [['identity', 'photo_path'], 'string', 'max' => 100],
            [['quote'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'id' => 'ID',
            'name' => '英雄姓名',
            'life_span' => '生卒年',
            'identity' => '身份',
            'war_zone' => '战区',
            'quote' => '名言',
            'description' => '详细事迹',
            'photo_path' => '照片文件名',
        ];
    }

}
