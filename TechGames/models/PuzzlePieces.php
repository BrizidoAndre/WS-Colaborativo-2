<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PuzzlePieces".
 *
 * @property int $id
 * @property string $image_path
 * @property int $position
 * @property int $puzzle_id
 *
 * @property PiecesPlayers[] $piecesPlayers
 * @property Puzzles $puzzle
 */
class PuzzlePieces extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'PuzzlePieces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_path', 'position', 'puzzle_id'], 'required'],
            [['position', 'puzzle_id'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
            [['puzzle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Puzzles::class, 'targetAttribute' => ['puzzle_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_path' => 'Image Path',
            'position' => 'Position',
            'puzzle_id' => 'Puzzle ID',
        ];
    }

    /**
     * Gets query for [[PiecesPlayers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPiecesPlayers()
    {
        return $this->hasMany(PiecesPlayers::class, ['puzzle_piece_id' => 'id']);
    }

    /**
     * Gets query for [[Puzzle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuzzle()
    {
        return $this->hasOne(Puzzles::class, ['id' => 'puzzle_id']);
    }

}
