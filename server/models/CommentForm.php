<?php

namespace app\models;

use yii\base\Model;

class CommentForm extends Model
{
    public $content;

    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string']
        ];
    }
}