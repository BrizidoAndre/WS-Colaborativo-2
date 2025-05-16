<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Role".
 *
 * @property string $roleId
 * @property string|null $title
 *
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'default', 'value' => null],
            [['roleId'], 'required'],
            [['roleId'], 'string', 'max' => 33],
            [['title'], 'string', 'max' => 100],
            [['title'], 'unique'],
            [['roleId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'roleId' => 'Role ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['roleId' => 'roleId']);
    }

    public function getId()
    {
        $this->roleId;
    }


}
