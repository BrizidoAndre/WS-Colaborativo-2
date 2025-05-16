<?php

namespace app\controllers\api;

use app\bases\Bearer;
use app\models\Players;
use yii\filters\Cors;
use yii\rest\Controller;

class RestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        $behaviors['cors'] = [
            'class' => Cors::class
        ];
        $behaviors['authenticator'] = [
            'class' => Bearer::class,
            'user' => \Yii::$app->player
        ];
        return $behaviors;
    }

    function code($code)
    {
        \Yii::$app->response->statusCode = $code;
    }

    public function prepareMessage($code,$message)
    {
        $this->code($code);
        return [
            'statusCode' => $code,
            ...$message,
        ];
    }
}