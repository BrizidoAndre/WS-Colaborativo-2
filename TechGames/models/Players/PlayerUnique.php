<?php

namespace app\models\Players;

use app\models\Players;

class PlayerUnique extends Players
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'unique'],
        ];
    }
}