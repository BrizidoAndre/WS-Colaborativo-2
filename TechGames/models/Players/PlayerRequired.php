<?php

namespace app\models\Players;

use app\models\Players;

class PlayerRequired extends Players
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'phone','name','passwordConfirmation'], 'required']
        ];
    }
}