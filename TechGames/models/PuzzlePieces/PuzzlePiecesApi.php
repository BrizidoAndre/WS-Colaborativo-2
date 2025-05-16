<?php

namespace app\models\PuzzlePieces;

use app\models\PuzzlePieces;

class PuzzlePiecesApi extends PuzzlePieces
{
    public function fields()
    {
        return [
            'id',
            'url' => 'image_path',
            'currentPosition' => 'position'
        ];
    }
}