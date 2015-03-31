<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->title = 'Say';
//$this->params['breadcrumbs'][] = $this->title;
?>

    <?php $form = ActiveForm::begin();?>

        <?=$form->field($model, 'name')->label('Ваше имя');?>
        <?=$form->field($model, 'email');?>
        <div class="form-group">
            <?=Html::submitButton('Отправить',['class'=>'btn btn-primary']);?>
        </div>
    <?php $form = ActiveForm::end(); ?>

