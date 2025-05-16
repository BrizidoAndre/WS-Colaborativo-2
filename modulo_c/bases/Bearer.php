<?php

namespace app\bases;

use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;

class Bearer extends HttpBearerAuth
{
    public $except = ['login'];
    public function handleFailure($response)
    {
        \Yii::$app->response->statusCode = 401;
        \Yii::$app->response->data = [
            'statusCode' => \Yii::$app->response->statusCode,
            'message' => 'Unauthenticated user'
        ];
    }
}