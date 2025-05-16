<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $userId
 * @property string|null $createdAt
 * @property string $title
 * @property string|null $description
 * @property string|null $content
 *
 * @property Comment[] $comments
 * @property Posttag[] $posttags
 * @property Tag[] $tags
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'content'], 'default', 'value' => null],
            [['userId', 'title'], 'required'],
            [['userId'], 'integer'],
            [['createdAt'], 'safe'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 300],
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
            'userId' => 'User ID',
            'createdAt' => 'Created At',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['postId' => 'id']);
    }

    /**
     * Gets query for [[Posttags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosttags()
    {
        return $this->hasMany(Posttag::class, ['postId' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tagId'])->viaTable('posttag', ['postId' => 'id']);
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
