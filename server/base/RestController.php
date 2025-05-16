<?php


namespace app\base;

use yii\filters\Cors;
use yii\web\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="My first API", version="1.0")
 */
class RestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['cors'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => [
                    '*',
                ],
                'Access-Control-Request-Method' => [
                    'GET',
                    'POST',
                    'PUT',
                    'PATCH',
                    'DELETE',
                    'HEAD',
                    'OPTIONS',
                ],
                'Access-Control-Request-Headers' => [
                    '*',
                ],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ]
        ];
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ]
        ];
        return $behaviors;
    }
}