<?php

use app\models\Puzzles;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PuzzlesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Puzzles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="puzzles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Puzzles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img(['images/' . $model->image], ['styles' => [
                        'width' => 100,
                        'height' => 100
                    ]]);
                },
                'label' => 'Thumbnail'
            ],
            'piecesAmount',
            [
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Link da página', ['puzzles/view', 'id' => $model->id]);
                },
                'label' => 'Link da página'
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Puzzles $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
