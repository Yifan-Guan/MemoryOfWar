<?php

use yii\db\Migration;

/**
 * 为 province 表添加链接字段
 */
class m251219_000001_add_url_to_province_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 添加 url 字段
        $this->addColumn('{{%province}}', 'url', $this->string(255)->null()->comment('省份链接'));
        
        // 为现有数据填充 url，可根据 html_file 自动生成
        $this->execute("UPDATE {{%province}} SET url = CONCAT('/battles/', html_file)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%province}}', 'url');
    }
}
