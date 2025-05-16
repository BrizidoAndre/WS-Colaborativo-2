<?php

namespace app\models\Players;

use app\models\Players;

class PlayerLogin extends Players
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
        ];
    }
}