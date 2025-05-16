<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\User;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class SiteController extends \app\base\RestController
{
    public function actionIndex()
    {
        return [
            'openApi' => '3.0.3',
            'info' => [
                'title' => 'ConectaDEV API',
                'version' => '1.0.0',
                'description' => 'API da plataforma Conecta DEV',
            ]
        ];
    }
}