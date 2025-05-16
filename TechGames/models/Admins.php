<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "Admins".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property int $firstAccess
 * @property string|null $name
 */
class Admins extends \yii\db\ActiveRecord implements IdentityInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Admins';
    }

    public static function findByUsername($username)
    {
        return self::findOne(['email' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'default', 'value' => null],
            [['firstAccess'], 'default', 'value' => 0],
            [['email', 'phone'], 'required'],
            [['email'], 'unique'],
            [['firstAccess'], 'integer'],
            [['email', 'phone', 'name'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 522],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Telefone',
            'firstAccess' => 'First Access',
            'name' => 'Nome',
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function validatePassword($password)
    {
        return $this->password === hash('sha256',$password);
    }
}
