<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Puzzles $model */

$this->title = 'Create Puzzles';
$this->params['breadcrumbs'][] = ['label' => 'Puzzles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="puzzles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
