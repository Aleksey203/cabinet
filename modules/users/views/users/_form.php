<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\users\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 125]) ?>

    <?= $form->field($model, 'pass1')->textInput(['minlength' => 5]) ?>

    <?= $form->field($model, 'pass2')->textInput(['minlength' => 5]) ?>

    <?= $form->field($model, 'question')->textInput(['maxlength' => 512]) ?>

    <?= $form->field($model, 'answer')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'organization')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'avatar')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'balance')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'role')->textInput() ?>

    <?= $form->field($model, 'ban')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
