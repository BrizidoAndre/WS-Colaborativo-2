<?php

namespace app\models;

use app\models\PuzzlePieces\PuzzlePiecesApi;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Puzzles".
 *
 * @property int $id
 * @property UploadedFile $image
 * @property int $piecesAmount
 * @property string $date
 *
 * @property Points[] $points
 * @property PuzzlePieces[] $puzzlePieces
 */
class Puzzles extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Puzzles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'piecesAmount'], 'required'],
            [['piecesAmount'], 'integer'],
            [['piecesAmount'], 'in', 'range' => [4, 9, 16, 25, 36, 49, 64, 81]],
            [['date'], 'date', 'format' => 'php: Y-m-d'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('images/' . $this->image->baseName . '.' . $this->image->extension);
            $this->image->saveAs('images/blur_' . $this->image->baseName . '.' . $this->image->extension);
            $this->image->saveAs('images/' . Yii::$app->security->generateRandomString(34) . '.' . $this->image->extension);
            $this->image = $this->image->baseName . '.' . $this->image->extension;
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'piecesAmount' => 'Número de peças',
            'date' => 'Data',
        ];
    }

    /**
     * Gets query for [[Points]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoints()
    {
        return $this->hasMany(Points::class, ['puzzle_id' => 'id']);
    }

    /**
     * Gets query for [[PuzzlePieces]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuzzlePieces()
    {
        return $this->hasMany(PuzzlePiecesApi::class, ['puzzle_id' => 'id']);
    }

}
