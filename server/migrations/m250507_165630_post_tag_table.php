<?php

use yii\db\Migration;

class m250507_165630_post_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('posttag', [
            'postId' => $this->integer()->notNull(),
            'tagId' => $this->integer()->notNull()
        ]);

        $this->addPrimaryKey('pk_posttag', 'posttag', ['postId', 'tagId']);

        $this->addForeignKey(
            'fk_posttag_post',
            'posttag', 'postId',
            'post', 'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_posttag_tag',
            'posttag', 'tagId',
            'tag', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('posttag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250507_165630_post_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
