<?php

use yii\db\Migration;

class m250507_170222_post_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'createdAt' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'content' => $this->text()->notNull(),
            'postId' => $this->integer()->notNull(),
            'userId' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk_comment_post',
            'comment', 'postId',
            'post', 'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_comment_user',
            'comment', 'userId',
            'user', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comment');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250507_170222_post_comment_table cannot be reverted.\n";

        return false;
    }
    */
}
