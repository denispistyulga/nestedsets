<?php

use app\models\menu\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\menu\Menu $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin();
    echo $form->errorSummary($model);
    ?>
<!--    --><?//= $form->field($model, 'sub_menu')->dropDownList(ArrayHelper::map(Menu::find()->asArray()->all(),'id','name')) ?>

    <?= $form->field($model, 'sub_menu')->dropDownList(ArrayHelper::map(Menu::find()->asArray()->all(),'id','name'),
        ['prompt'=>'Верхний уровень']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<!--    --><?//= $form->field($model, 'tree')->dropDownList([0]) ?>

<!--    --><?//= $form->field($model, 'left')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'right')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'depth')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
