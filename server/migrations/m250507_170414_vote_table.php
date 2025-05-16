<?php

use yii\db\Migration;

class m250507_170414_vote_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vote', [
            'positive' => $this->boolean()->notNull()->defaultValue(0),
            'commentId' => $this->integer()->notNull(),
            'userId' => $this->integer()->notNull()
        ]);

        $this->addPrimaryKey('pk_vote', 'vote', ['commentId', 'userId']);

        $this->addForeignKey(
            'fk_vote_comment',
            'vote', 'commentId',
            'comment', 'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_vote_user',
            'vote', 'userId',
            'user', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vote');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250507_170414_vote_table cannot be reverted.\n";

        return false;
    }
    */
}
