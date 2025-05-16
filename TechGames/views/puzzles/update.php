<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Puzzles $model */

$this->title = 'Update Puzzles: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Puzzles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="puzzles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
