<?php

namespace app\controllers\api\v1;

use app\models\LoginForm;
use app\models\User;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;

class AuthController extends \app\base\RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'login' => ['post'],
                'register' => ['post'],
            ],
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post(), '') && $model->validate()) {
            if (($user = User::findIdentityByEmail($model->email)) !== null && $user->validatePassword($model->password)) {
                return [
                    'token' => md5($user->email),
                ];
            }
        }
        throw new UnauthorizedHttpException('Invalid login');
    }

    public function actionRegister()
    {
        $model = new User();
        if ($model->load(\Yii::$app->request->post(), '') && $model->validate()) {
            if ($model->save()) {
                $this->response->statusCode = 201;
                return [
                    'id' => $model->id
                ];
            }
        }

        $this->response->statusCode = 422;
        return [
            'errors' => $model->getErrors()
        ];
    }
}