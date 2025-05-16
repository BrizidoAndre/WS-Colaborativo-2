<?php

use yii\db\Migration;

class m250507_164655_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string(300)->notNull(),
            'email' => $this->string(300)->notNull()->unique(),
            'phone' => $this->char(11)->unique(),
            'password' => $this->string(100)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250507_164655_user_table cannot be reverted.\n";

        return false;
    }
    */
}
