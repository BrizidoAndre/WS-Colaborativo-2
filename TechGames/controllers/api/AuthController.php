<?php

namespace app\controllers\api;

use app\models\Players;

class AuthController extends RestController
{
    public function actionRegister()
    {
        $player = new Players();
        $player->load($this->request->post(), '');
        $playerRequired = new Players\PlayerRequired();
        $playerUnique = new Players\PlayerUnique();
        $playerPass = new Players\PlayerPassword();
        $playerRequired->setAttributes($player->attributes);
        $playerRequired->passwordConfirmation = $player->passwordConfirmation;
        $playerUnique->setAttributes($player->attributes);
        $playerPass->setAttributes($player->attributes);
        $playerPass->setAttributes($player->attributes);
        $playerPass->passwordConfirmation = ($player->passwordConfirmation);
        if (!$playerRequired->validate()) {
            $this->code(422);
            return [
                'statusCode' => $this->response->statusCode,
                'message' => 'Corpo da requisição inválido'
            ];
        }
        if (!$playerUnique->validate()) {
            $this->code(409);
            return [
                'statusCode' => $this->response->statusCode,
                'message' => 'O email fornecido já está cadastrado'
            ];
        }
        if (!$playerPass->validate()) {
            $this->code(400);
            return [
                'statusCode' => $this->response->statusCode,
                'message' => 'Senhas não coincidem'
            ];
        }
        $player->password = hash('sha256', $player->password);
        $player->save();
        $this->code(201);
        return [
            'statusCode' => $this->response->statusCode,
            'message' => 'Usuário criado com sucesso'
        ];
    }

    public function actionLogin()
    {
        $playerLogin = new Players\PlayerLogin();
        $playerLogin->load($this->request->post(), '');
        if (!$playerLogin->validate()) {
            $this->code(422);
            return [
                'statusCode' => $this->response->statusCode,
                'message' => 'Corpo da requisição inválido'
            ];
        }
        $playerFound = Players::findOne(['email' => $playerLogin->email, 'password' => hash('sha256', $playerLogin->password)]);
        if (!$playerFound) {
            $this->code(401);
            return [
                'statusCode' => $this->response->statusCode,
                'message' => 'Credenciais inválidas'
            ];
        }
        $playerFound->token = \Yii::$app->security->generateRandomString(100);
        $playerFound->token_time = (new \DateTime())->getTimestamp();
        $playerFound->save();
        return [
            'statusCode' => $this->response->statusCode,
            'message' => $playerFound->token
        ];
    }
}