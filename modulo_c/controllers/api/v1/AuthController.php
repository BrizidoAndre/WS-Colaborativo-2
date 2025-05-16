<?php

namespace app\controllers\api\v1;

use app\models\Token;
use app\models\User;

class AuthController extends RestController
{
    public function actionLogin()
    {
        $user = new User();
        $user->load($this->request->post(), '');
        $userFound = User::findOne(['email' => $user->email, 'password' => $user->password]);
        if (!$user->validate() || !$userFound) {
            return $this->prepareMessage(400, [
                'token' => 'Invalid credentials',
            ]);
        }
        $token = new Token();
        $token->user_id = $userFound->userId;
        $token->token = \Yii::$app->security->generateRandomString(50);
        $token->save();
        return $this->prepareMessage(200, [
            'token' => $token->token
        ]);
    }
}