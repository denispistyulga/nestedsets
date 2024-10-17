<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\menu\Menu $model */

$this->title = 'Создать папку';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
