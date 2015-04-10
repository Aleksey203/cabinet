<?php
/** File: RecoveryController.php Date: 06.04.15 Time: 14:11 */



namespace app\modules\user\controllers;

use app\modules\user\models\Profile;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use dektrium\user\models\SettingsForm;
use dektrium\user\traits\AjaxValidationTrait;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Yii;
use yii\imagine\Image;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SettingsController extends BaseSettingsController {

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'disconnect' => ['post']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['profile', 'account', 'confirm', 'crop', 'networks', 'disconnect'],
                        'roles'   => ['@']
                    ],
                ]
            ],
        ];
    }
    /**
     * Shows profile settings form.
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

        $request = \Yii::$app->request->post();
        unset($request['Profile']['avatar']);

        if (isset($request['ajax'])) $this->performAjaxValidation($model);


        if (\Yii::$app->request->isPost AND UploadedFile::getInstance($model, 'avatar')) {
            $model->avatar = UploadedFile::getInstance($model, 'avatar');

            if ($model->avatar && $model->validate()) {
                $path = \Yii::getAlias('@app/web/uploads/users/' . \Yii::$app->user->identity->getId() . '/avatar');
                if (is_dir($path)) {
                    FileHelper::removeDirectory($path);
                }
                FileHelper::createDirectory($path);
                $imgPath = $path . '/' . $model->avatar->baseName . '.' . $model->avatar->extension;
                if ($model->avatar->saveAs($imgPath)) {
                    $size = getimagesize($imgPath);
                    $width = 600;
                    if ($width>=$size[0]) {
                        $width = $size[0];
                        $height = $size[1];
                    }
                    else {
                        $height = ceil($size[1]/$size[0]*$width);
                    }
                    $height2 = 600;
                    if ($height2<$height) {
                        $height = $height2;
                        $width = ceil($size[0]/$size[1]*$height);
                    }
                    Image::thumbnail($imgPath, $width, $height, 'inset')
                        ->save($imgPath, ['quality' => 100]);;
                    $request['Profile']['avatar'] = $model->avatar->baseName . '.' . $model->avatar->extension;

                }
            }
        }
        //else $request['Profile']['avatar'] = $model->avatar;

        if (\Yii::$app->request->isAjax) {
            $data = array();
            if ($model->load($request) && $model->save()) {
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
                $data['message'] = $this->renderPartial('/_alert', ['module' => Yii::$app->getModule('user')]);
            }
            return json_encode($data);
        }

        if ($model->load($request) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionAccount()
    {
        /** @var SettingsForm $model */
        $model = \Yii::createObject(SettingsForm::className());

        $request = \Yii::$app->request->post();

        if (isset($request['ajax'])) $this->performAjaxValidation($model);

        if (\Yii::$app->request->isAjax) {
            $data = array();
            $model->load($request);
            if ($model->load($request) && $model->save()) {
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
                $data['message'] = $this->renderPartial('/_alert', ['module' => Yii::$app->getModule('user')]);
            }
            return json_encode($data);
        }

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your account details have been updated'));
            return $this->refresh();
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }

    /**
 * Вырезание рисунка
 */
    public function actionCrop()
    {
        $path = \Yii::getAlias('@app/web/uploads/users/' . \Yii::$app->user->identity->getId() . '/avatar');
        $model = Profile::findOne(\Yii::$app->user->identity->getId());
        if (\Yii::$app->request->isPost) {
            $imgPath = $path . '/' . $model->avatar;
            $request = \Yii::$app->request->post();
            Image::crop($imgPath, $request['imageId_w'], $request['imageId_h'], [$request['imageId_x'],$request['imageId_y']])
                ->save($path . '/j-' . $model->avatar, ['quality' => 100]);

            $size = getimagesize($path . '/j-' . $model->avatar);
            $width = 320;
            if ($width>=$size[0]) {
                $width = $size[0];
                $height = $size[1];
            }
            else {
                $height = ceil($size[1]/$size[0]*$width);
            }
            Image::thumbnail($path . '/j-' . $model->avatar, $width, $height, 'inset')
                ->save($path . '/j-' . $model->avatar, ['quality' => 100]);
            $model->avatar = 'j-'.$model->avatar;
            $model->save();

            $src = '/uploads/users/'.$model->user_id.'/avatar/'.$model->avatar;
            return $src;

        }
    }
} 