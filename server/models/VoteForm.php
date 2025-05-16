<?php

namespace app\models;

use yii\base\Model;

class VoteForm extends Model
{
    public $positive;

    public function rules()
    {
        return [
            [['positive'], 'required'],
            [['positive'], 'boolean']
        ];
    }
}