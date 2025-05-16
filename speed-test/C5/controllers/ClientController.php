<?php

namespace app\controllers;

use app\models\Artist;
use app\models\Song;
use yii\helpers\VarDumper;
use yii\web\Controller;

class ClientController extends Controller
{
    public function actionIndex()
    {
        $art = new Artist();
        if ($this->request->isPost) {
            $art->load($this->request->post());
            VarDumper::dump($art->attributes);
        }
        return $this->render('index',
        [
            'art' => $art
        ]);
    }
}