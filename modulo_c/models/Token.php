<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Token".
 *
 * @property int $id
 * @property string $token
 * @property int $created_at
 * @property string $user_id
 *
 * @property User $user
 */
class Token extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'user_id'], 'required'],
            [['created_at'], 'default', 'value' => fn()=>(new \DateTime())->getTimestamp()],
            [['created_at'], 'integer'],
            [['token'], 'string', 'max' => 522],
            [['user_id'], 'string', 'max' => 33],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['userId' => 'user_id']);
    }


    public function getId()
    {
        return $this->id;
    }

}
