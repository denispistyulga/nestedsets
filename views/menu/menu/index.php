<?php

use app\models\menu\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\menu\SearchMenu $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать папку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            'name',
            'left',
            'right',
            //'depth',
            //'created_at',
            //'updated_at',

            [
                'filter' => false,
                'attribute' => 'created_at',
                'content' => function ($data) {
                    return date('d.m.Y H:i:s', $data['created_at']);
                }
            ],

            [
                'filter' => false,
                'attribute' => 'updated_at',
                'content' => function ($data) {
                    if (!empty($data['updated_at'])) {
                        return date('d.m.Y H:i:s', $data['updated_at']);
                    }
                }
            ],


            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Menu $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
