<?php

namespace app\models\Players;

use app\models\Players;

class PlayerPassword extends Players
{
    public function rules()
    {
        return [
            ['password', 'compare', 'compareAttribute' => 'passwordConfirmation'],
        ];
    }
}