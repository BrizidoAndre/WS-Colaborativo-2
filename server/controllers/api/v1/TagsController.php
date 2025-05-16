<?php

namespace app\controllers\api\v1;

use app\models\LoginForm;
use app\models\Tag;
use app\models\User;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;

class TagsController extends \app\base\RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['get'],
            ],
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        return Tag::find()->orderBy('id')->all();
    }
}