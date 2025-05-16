<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $title
 *
 * @property Post[] $posts
 * @property Posttag[] $posttags
 */
class Tag extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 300],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['id' => 'postId'])->viaTable('posttag', ['tagId' => 'id']);
    }

    /**
     * Gets query for [[Posttags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosttags()
    {
        return $this->hasMany(Posttag::class, ['tagId' => 'id']);
    }

}
