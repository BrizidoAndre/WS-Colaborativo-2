<?php

namespace app\controllers\api;

use app\bases\Bearer;
use app\controllers\PuzzlesController;
use app\models\PiecesPlayers;
use app\models\Puzzles;
use Faker\Core\DateTime;

class GamesController extends RestController
{
    public function actionCurrent()
    {
        $puzzle = Puzzles::findOne(['date' => date('Y-m-d')]);
        if (!$puzzle) {
            $this->code(404);
            return [
                'statusCode' => $this->response->statusCode,
                'message' => 'Jogo indisponível'
            ];
        }
        $pieces = $puzzle->puzzlePieces;
        $this->code(200);

        return [
            'statusCode' => $this->response->statusCode,
            'thumbnailURL' => $puzzle->image,
            'piecesURL' => $pieces,
            'completed' => false
        ];
    }

    public function actionArchive()
    {
        $date = date('Y-m-d');
        $puzzles = Puzzles\PuzzlesList::find();
        $puzzles->andWhere("date < '$date'");
        return $this->prepareMessage(200, [
            'games' => $puzzles->all(),
        ]);
    }

    public function actionGet($date)
    {
        $dateTimeStamp = date_create_from_format('Y-m-d', $date)->getTimestamp();
        $now = (date_create_from_format('Y-m-d', date('Y-m-d')))->getTimestamp();
        $puzzle = Puzzles::findOne(['date' => $date]);
        if (!$puzzle || $dateTimeStamp > $now) {
            return $this->prepareMessage(404, [
                'message' => 'Jogo indisponível'
            ]);
        }
        return $this->prepareMessage(200, [
            'thumbnailURl' => 'blur_' . $puzzle->image,
            'piecesURL' => $puzzle->puzzlePieces,
            'completed' => false
        ]);
    }

    public function actionPlaceMove($date = 'now')
    {
        $date = $date === 'now' ? date('Y-m-d') : $date;
        $dateTimeStamp = date_create_from_format('Y-m-d', $date)->getTimestamp();
        $now = (date_create_from_format('Y-m-d', date('Y-m-d')))->getTimestamp();
        $puzzle = Puzzles::findOne(['date' => $date]);
        if (!$puzzle || $dateTimeStamp > $now) {
            return $this->prepareMessage(404, [
                'message' => 'Jogo indisponível'
            ]);
        }
        $piecePlayer = new PiecesPlayers();
        $piecePlayer->load($this->request->post(), '');
        if (!$piecePlayer->validate()) {
            return $this->prepareMessage(400, [
                'message' => 'Valores inválidos'
            ]);
        }
        $piecePlayer->puzzle_piece_id = $piecePlayer->pieceId;
        $piecePlayer->currentPosition = $piecePlayer->position;
        $piecePlayer->player_id = \Yii::$app->player->identity->id;
        $piecePlayer->save(false);
        return $this->prepareMessage(200, [
            'message' => 'Posição atualizada'
        ]);
    }
}