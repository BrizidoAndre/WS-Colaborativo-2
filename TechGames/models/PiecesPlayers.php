<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PiecesPlayers".
 *
 * @property int $id
 * @property int $puzzle_piece_id
 * @property int $currentPosition
 * @property int $player_id
 *
 * @property Players $player
 * @property PuzzlePieces $puzzlePiece
 */
class PiecesPlayers extends \yii\db\ActiveRecord
{
    public $pieceId;
    public $position;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'PiecesPlayers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pieceId', 'position'], 'required'],
            [['player_id'], 'default','value' => Yii::$app->player->id],
            [['puzzle_piece_id', 'currentPosition', 'player_id'], 'integer'],
            [['pieceId', 'currentPosition', 'player_id', 'position'], 'integer'],
            [['position'], 'integer', 'min' => 0],
            [['position'], function ($attribute) {
                $puzzle = PuzzlePieces::findOne(['id' => $this->pieceId]);
                if ($puzzle && $puzzle->puzzle->piecesAmount < $this->position) {
                    $this->addError($attribute, 'Posição maior que o do tabuleiro');
                }
            }],
            [['pieceId'], 'exist', 'skipOnError' => true, 'targetClass' => Players::class, 'targetAttribute' => ['pieceId' => 'id']],
            [['puzzle_piece_id'], 'exist', 'skipOnError' => true, 'targetClass' => PuzzlePieces::class, 'targetAttribute' => ['puzzle_piece_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'puzzle_piece_id' => 'Puzzle Piece ID',
            'currentPosition' => 'Current Position',
            'player_id' => 'Player ID',
        ];
    }

    /**
     * Gets query for [[Player]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Players::class, ['id' => 'player_id']);
    }

    /**
     * Gets query for [[PuzzlePiece]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuzzlePiece()
    {
        return $this->hasOne(PuzzlePieces::class, ['id' => 'puzzle_piece_id']);
    }

}
