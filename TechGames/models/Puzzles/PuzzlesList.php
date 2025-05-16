<?php

namespace app\models\Puzzles;

use app\models\Puzzles;

class PuzzlesList extends Puzzles
{
    public function fields()
    {
        return [
            'thumbnailURL' => fn() => 'blur_' . $this->image,
            'piecesAmount',
            'completed' => fn() => false,
        ];
    }
}