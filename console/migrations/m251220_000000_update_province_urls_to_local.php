<?php

use yii\db\Migration;

/**
 * 更新province表的url字段，指向本地battles目录下的HTML文件
 */
class m251220_000000_update_province_urls_to_local extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 为每个省份设置对应的本地HTML页面URL
        $this->execute("UPDATE {{%province}} SET url = CONCAT('/battles/', html_file) WHERE html_file IS NOT NULL AND html_file != ''");
        
        echo "Province URLs updated successfully.\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // 清空url字段
        $this->execute("UPDATE {{%province}} SET url = NULL");
        
        return true;
    }
}
