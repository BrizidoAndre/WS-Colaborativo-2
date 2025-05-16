<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vote".
 *
 * @property int $positive
 * @property int $commentId
 * @property int $userId
 *
 * @property Comment $comment
 * @property User $user
 */
class Vote extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vote';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['positive'], 'default', 'value' => 0],
            [['positive', 'commentId', 'userId'], 'integer'],
            [['commentId', 'userId'], 'required'],
            [['commentId', 'userId'], 'unique', 'targetAttribute' => ['commentId', 'userId']],
            [['commentId'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::class, 'targetAttribute' => ['commentId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'positive' => 'Positive',
            'commentId' => 'Comment ID',
            'userId' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Comment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::class, ['id' => 'commentId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

}
