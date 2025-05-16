<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $content
 * @property int $postId
 * @property int $userId
 *
 * @property Post $post
 * @property User $user
 * @property User[] $users
 * @property Vote[] $votes
 */
class Comment extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'postId', 'userId'], 'required'],
            [['content'], 'string'],
            [['postId', 'userId'], 'integer'],
            [['postId'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['postId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'postId' => 'Post ID',
            'userId' => 'User ID',
        ];
    }

    public function getScore()
    {
        $score = 0;
        foreach ($this->votes as $vote) {
            $score += $vote->positive ? 1 : -1;
        }
        return $score;
    }

    public function getMyVote()
    {
        return Vote::findOne(['commentId' => $this->id, 'userId' => Yii::$app->user->id]) ?
            Vote::findOne(['commentId' => $this->id, 'userId' => Yii::$app->user->id])->positive :
            null;
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'postId']);
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

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'userId'])->viaTable('vote', ['commentId' => 'id']);
    }

    /**
     * Gets query for [[Votes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(Vote::class, ['commentId' => 'id']);
    }

}
