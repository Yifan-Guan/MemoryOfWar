<?php

use yii\db\Migration;

/**
 * 创建省份表
 */
class m251219_000000_create_province_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%province}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->comment('省份名称'),
            'html_file' => $this->string(100)->notNull()->comment('对应的HTML文件名'),
            'description' => $this->text()->comment('省份描述'),
            'order' => $this->integer()->defaultValue(0)->comment('排序'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // 创建索引
        $this->createIndex('idx-province-name', '{{%province}}', 'name');
        
        // 插入初始数据
        $provinces = [
            ['上海', '上海.html', '上海市'],
            ['云南', '云南.html', '云南省'],
            ['内蒙古', '内蒙古.html', '内蒙古自治区'],
            ['北京', '北京.html', '北京市'],
            ['台湾', '台湾.html', '台湾省'],
            ['吉林', '吉林.html', '吉林省'],
            ['四川', '四川.html', '四川省'],
            ['天津', '天津.html', '天津市'],
            ['宁夏', '宁夏.html', '宁夏回族自治区'],
            ['安徽', '安徽.html', '安徽省'],
            ['山东', '山东.html', '山东省'],
            ['山西', '山西.html', '山西省'],
            ['广东', '广东.html', '广东省'],
            ['广西', '广西.html', '广西壮族自治区'],
            ['新疆', '新疆.html', '新疆维吾尔自治区'],
            ['江苏', '江苏.html', '江苏省'],
            ['江西', '江西.html', '江西省'],
            ['河北', '河北.html', '河北省'],
            ['河南', '河南.html', '河南省'],
            ['浙江', '浙江.html', '浙江省'],
            ['海南', '海南.html', '海南省'],
            ['湖北', '湖北.html', '湖北省'],
            ['湖南', '湖南.html', '湖南省'],
            ['甘肃', '甘肃.html', '甘肃省'],
            ['福建', '福建.html', '福建省'],
            ['西藏', '西藏.html', '西藏自治区'],
            ['贵州', '贵州.html', '贵州省'],
            ['辽宁', '辽宁.html', '辽宁省'],
            ['重庆', '重庆.html', '重庆市'],
            ['陕西', '陕西.html', '陕西省'],
            ['青海', '青海.html', '青海省'],
            ['黑龙江', '黑龙江.html', '黑龙江省'],
        ];

        $time = time();
        foreach ($provinces as $i => $province) {
            $this->insert('{{%province}}', [
                'name' => $province[0],
                'html_file' => $province[1],
                'description' => $province[2],
                'order' => $i + 1,
                'created_at' => $time,
                'updated_at' => $time,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%province}}');
    }
}
