<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posttag".
 *
 * @property int $postId
 * @property int $tagId
 *
 * @property Post $post
 * @property Tag $tag
 */
class Posttag extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posttag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postId', 'tagId'], 'required'],
            [['postId', 'tagId'], 'integer'],
            [['postId', 'tagId'], 'unique', 'targetAttribute' => ['postId', 'tagId']],
            [['postId'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['postId' => 'id']],
            [['tagId'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::class, 'targetAttribute' => ['tagId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'postId' => 'Post ID',
            'tagId' => 'Tag ID',
        ];
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
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tagId']);
    }

}
