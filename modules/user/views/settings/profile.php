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
use newerton\jcrop\jCrop;
use dosamigos\fileupload\FileUpload;

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


                <?php echo $form->field($model, 'website') ?>

                <?= $form->field($model, 'location') ?>

                <?= $form->field($model, 'bio')->textarea() ?>

                <div class="form-group field-profile-avatar">



                    <div id="avatar_img" class="col-lg-offset-3 col-lg-9" style="margin-bottom: 15px;">
                        <?php if ($model->avatar) { ?>
                        <img src="/uploads/users/<?= Html::encode($model->user_id) ?>/avatar/<?= Html::encode($model->avatar) ?>" alt="" class="img-rounded img-responsive" />
                        <?php
                            echo newerton\fancybox\FancyBox::widget([
                                'target' => 'a[rel=fancybox]',
                                //'helpers' => true,
                                'mouse' => false,
                                'config' => [
                                    'maxWidth' => '95%',
                                    'maxHeight' => '95%',
                                    //'playSpeed' => 7000,
                                    'padding' => [20,50,20,50],
                                    //'fitToView' => false,
                                    //'width' => '70%',
                                    //'height' => '70%',
                                    //'autoSize' => false,
                                    'closeClick' => false,
                                    'openEffect' => 'elastic',
                                    'closeEffect' => 'elastic',
                                    //'prevEffect' => 'elastic',
                                    //'nextEffect' => 'elastic',
                                    'closeBtn' => true,
                                    'openOpacity' => true,
                                    'afterLoad' => new yii\web\JsExpression("function() {
                                    setTimeout('$(\"#start_imageId\").trigger(\"click\")' , 200);
                                    var width = $('#imageId').width();
                                    //$.fancybox.toggle();
                                    }"),
                                    'helpers' => [
                                        'title' => ['type' => 'float'],
                                        'buttons' => [],
                                        'thumbs' => ['width' => 68, 'height' => 50],
                                        'overlay' => [
                                            'css' => [
                                                'background' => 'rgba(0, 0, 0, 0.8)'
                                            ]
                                        ]
                                    ],
                                ]
                            ]);
                            echo Html::a('Обрезать изображение','#modify',['id'=>'a_modify', 'rel' => 'fancybox']);?>
                            <div style="display: none;">
                                <div id="modify">
                                    <?php
                                    if ($model->avatar)
                                        echo jCrop::widget([
                                            // Image URL
                                            'url' => '/uploads/users/'.Html::encode($model->user_id).'/avatar/'.Html::encode($model->avatar),
                                            // options for the IMG element
                                            'imageOptions' => [
                                                'id' => 'imageId',
                                                //'width' => 600,
                                                //'alt' => 'Crop this image'
                                            ],
                                            // Jcrop options (see Jcrop documentation [http://deepliquid.com/content/Jcrop_Manual.html])
                                            'jsOptions' => array(
                                                'minSize' => [100, 100],
                                                'aspectRatio' => 1,
                                                //'onRelease' => new yii\web\JsExpression("function() {ejcrop_cancelCrop(this);}"),
                                                'onRelease' => new yii\web\JsExpression("function() {ejcrop_cancelCrop(this); }"),
                                                //customization
                                                'bgColor' => '#ffffff',
                                                'bgOpacity' => 0.4,
                                                'selection' => true,
                                                'theme' => 'light',
                                            ),
                                            // if this array is empty, buttons will not be added
                                            'buttons' => array(
                                                'start' => array(
                                                    'label' => 'Выделить область рисунка',
                                                    'htmlOptions' => array(
                                                        'class' => 'myClass',
                                                        'style' => 'color:red;'
                                                    )
                                                ),
                                                'crop' => array(
                                                    'label' => 'Сохранить',
                                                ),
                                                'cancel' => array(
                                                    'label' => 'Отмена'
                                                )
                                            ),
                                            // URL to send request to (unused if no buttons)
                                            'ajaxUrl' => \yii\helpers\Url::to(['settings/crop']),
                                            // Additional parameters to send to the AJAX call (unused if no buttons)
                                            'ajaxParams' => ['dataType'=>'json'],
                                        ]);
                                    ?>
                                </div>
                            </div>

                        <?php }?>


                    </div>

                <?php //echo $form->field($model, 'avatar')->fileInput() ?>
                <label class="col-lg-3 control-label" for="profile-avatar" style="padding-top: 0;">Фото</label>
                <?php $clientEvents = ($model->avatar) ?
                         '$("#avatar_img img, #imageId").attr("src","/uploads/users/'.$model->user_id.'/avatar/" + data.files[0].name); $.fancybox.update();'
                       : 'window.location.reload();';
                    ?>
                <?= FileUpload::widget([
                    'model' => $model,
                    'attribute' => 'avatar',
                    'url' => ['settings/profile', 'id' => $model->user_id], // your url, this is just for demo purposes,
                    'options' => ['accept' => 'image/*','class'=>'col-lg-9'],
                    'clientOptions' => [
                        'maxFileSize' => 2000000,
                    ],
                    // Also, you can specify jQuery-File-Upload events
                    // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
                    'clientEvents' => [
                        'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                                '.$clientEvents.'
                            }',
                        'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
                    ],
                ]);?>
                    <div class="col-sm-offset-3 col-lg-9"><div class="help-block"></div>
                    </div>
                </div>


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
<?php
if ($model->avatar) $this->registerJsFile('/js/ejcrop.js',['depends' => [\newerton\jcrop\jCropAsset::className()]]);
?>