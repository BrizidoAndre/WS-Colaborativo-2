<?php

namespace app\bases;

use app\models\Players;
use yii\filters\auth\HttpBearerAuth;

class Bearer extends HttpBearerAuth
{
    public $except = ['register','login'];
    public function handleFailure($response)
    {
        \Yii::$app->response->statusCode = 403;
        \Yii::$app->response->data = [
            'statusCode' => \Yii::$app->response->statusCode,
            'message' => 'Token inválido'
        ];
    }
}