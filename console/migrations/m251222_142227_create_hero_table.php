<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%hero}}`.
 */
class m251222_142227_create_hero_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. 创建表结构 (Create Table)
        // 这里定义了我们项目中用到的所有字段
        $this->createTable('{{%hero}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->comment('英雄姓名'),
            'life_span' => $this->string(50)->comment('生卒年'),
            'identity' => $this->string(100)->comment('身份/军衔'),
            'war_zone' => $this->string(50)->comment('所属战区'),
            'quote' => $this->string(255)->comment('名言'),
            'description' => $this->text()->comment('详细事迹'),
            'photo_path' => $this->string(255)->comment('照片路径'),
        ]);

        // 2. 插入初始化数据 (Seed Data)
        // 这一步是为了让别人拿到代码运行迁移后，数据库里不至于空空如也。
        // 我帮你放了两条最有代表性的数据进去。
        $this->batchInsert('{{%hero}}', 
            ['name', 'life_span', 'identity', 'war_zone', 'quote', 'description', 'photo_path'],
            [
                [
                    '杨靖宇', 
                    '1905-1940', 
                    '东北抗日联军第一路军总司令', 
                    '东北', 
                    '头颅可断，腹肌可剖，气节不可丢！', 
                    '著名抗日民族英雄。1940年2月23日，在吉林濛江县（今靖宇县）被日军包围，孤身一人与大量日寇激战五昼夜，壮烈殉国。日军解剖其遗体，发现胃里只有树皮、草根和棉絮，无一粒粮食，日军为之震惊。', 
                    'yangjingyu.png'
                ],
                [
                    '张自忠', 
                    '1891-1940', 
                    '第33集团军总司令', 
                    '华北', 
                    '我力战而死，自问对国家对民族可告无愧。', 
                    '抗战中牺牲的最高级别将领。1940年5月，在枣宜会战中，张自忠亲率部渡河作战，在湖北宜城南瓜店遭日军重兵包围，身中七弹，壮烈殉国。', 
                    'zhangzizhong.png'
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // 如果后悔了（回滚），就删除这张表
        $this->dropTable('{{%hero}}');
    }
}