<?php

use yii\db\Migration;

class m250507_165503_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'createdAt' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'title' => $this->string(100)->notNull(),
            'description' => $this->string(300),
            'content' => $this->text()
        ]);

        $this->addForeignKey(
            'fk_user_post',
            'post', 'userId',
            'user', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250507_165503_post_table cannot be reverted.\n";

        return false;
    }
    */
}
