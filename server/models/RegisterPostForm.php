<?php

namespace app\models;

use yii\base\Model;

class RegisterPostForm extends Model
{
    public $title;
    public $description;
    public $tags;
    public $content;

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 300],
            ['tags', 'each', 'rule' => [
                'exist',
                'targetClass' => Tag::class,
                'targetAttribute' => 'id'
            ]],
            ['tags', 'validateTagsCount'],
        ];
    }

    function validateTagsCount()
    {
        if (count($this->tags) > 5) {
            $this->addError('tags', 'No more than 5 tags are allowed');
        }
    }
}