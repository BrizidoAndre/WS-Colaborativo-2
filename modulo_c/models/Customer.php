<?php

namespace app\models;

class Customer extends User
{

    public function rules()
    {
        return [
            [['email', 'password', 'phone', 'name', ], 'required'],
            [['userId', 'roleId'], 'string', 'max' => 33],
            [['name', 'email', 'password'], 'string', 'max' => 300],
            [['phone'], 'string', 'length' => 11],
            [['email'], 'unique'],
            ['password', 'match', 'pattern' => '/[A-Z]{2,}/'],
            ['password', 'match', 'pattern' => '/[a-z]{2,}/'],
            ['password', 'match', 'pattern' => '/[\@\#\&\?\-\_]{2,}/i'],
            [['userId'], 'default','value' => \Yii::$app->security->generateRandomString(33)],
            [['roleId'], 'default','value' => 'y1lPuUoiyZqjHoG324tXK6It1awGc9qg'],
            [['roleId'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['roleId' => 'roleId']],
        ];
    }
}