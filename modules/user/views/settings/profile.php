<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => 'form-horizontal signup-form', 'enctype' => 'multipart/form-data'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                ]); ?>

                <?= $form->field($model, 'name') ?>



                <?php //echo $form->field($model, 'public_email') ?>

                <?php echo $form->field($model, 'website') ?>

                <?= $form->field($model, 'location') ?>

                <?= $form->field($model, 'bio')->textarea() ?>

                <?php if ($model->avatar) { ?>
                    <div class="col-lg-offset-3" style="margin-bottom: 15px;">
                        <img src="/uploads/users/<?= Html::encode($model->user_id) ?>/avatar/<?= Html::encode($model->avatar) ?>" alt="" style="max-width: 180px;" class="img-rounded img-responsive" />
                    </div>
                <?php }?>
                <?= $form->field($model, 'avatar')->fileInput() ?>


                <?php
                /*echo \newerton\jcrop\jCrop::widget([
                    // Image URL
                    'url' => '/uploads/users/'.Html::encode($model->user_id).'/avatar/'.Html::encode($model->avatar),
                    // options for the IMG element
                    'imageOptions' => [
                        'id' => 'imageId',
                        'width' => 600,
                        'alt' => 'Crop this image'
                    ],
                    // Jcrop options (see Jcrop documentation [http://deepliquid.com/content/Jcrop_Manual.html])
                    'jsOptions' => array(
                        'minSize' => [50, 50],
                        'aspectRatio' => 1,
                        'onRelease' => new yii\web\JsExpression("function() {ejcrop_cancelCrop(this);}"),
                        //customization
                        'bgColor' => '#FF0000',
                        'bgOpacity' => 0.4,
                        'selection' => true,
                        'theme' => 'light',
                    ),
                    // if this array is empty, buttons will not be added
                    'buttons' => array(
                        'start' => array(
                            'label' => 'Adjust thumbnail cropping',
                            'htmlOptions' => array(
                                'class' => 'myClass',
                                'style' => 'color:red;'
                            )
                        ),
                        'crop' => array(
                            'label' => 'Apply cropping',
                        ),
                        'cancel' => array(
                            'label' => 'Cancel cropping'
                        )
                    ),
                    // URL to send request to (unused if no buttons)
                    'ajaxUrl' => 'controller/ajaxcrop',
                    // Additional parameters to send to the AJAX call (unused if no buttons)
                    'ajaxParams' => ['someParam' => 'someValue'],
                ]);*/
                ?>

                <?php //echo $form->field($model, 'gravatar_email')->hint(\yii\helpers\Html::a(Yii::t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com')) ?>



                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= \yii\helpers\Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
                    </div>
                </div>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>