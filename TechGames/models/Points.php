<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Points".
 *
 * @property int $id
 * @property string $time
 * @property string $date
 * @property int $puzzle_id
 * @property int $player_id
 *
 * @property Players $player
 * @property Puzzles $puzzle
 */
class Points extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Points';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time', 'date', 'puzzle_id', 'player_id'], 'required'],
            [['time', 'date'], 'safe'],
            [['puzzle_id', 'player_id'], 'integer'],
            [['player_id'], 'exist', 'skipOnError' => true, 'targetClass' => Players::class, 'targetAttribute' => ['player_id' => 'id']],
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
            'time' => 'Time',
            'date' => 'Date',
            'puzzle_id' => 'Puzzle ID',
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
     * Gets query for [[Puzzle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuzzle()
    {
        return $this->hasOne(Puzzles::class, ['id' => 'puzzle_id']);
    }

}
