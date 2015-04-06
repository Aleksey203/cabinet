<?php
/** File: RecoveryController.php Date: 06.04.15 Time: 14:11 */



namespace app\modules\user\controllers;

use dektrium\user\controllers\SettingsController as BaseSettingsController;
use dektrium\user\models\SettingsForm;
use dektrium\user\traits\AjaxValidationTrait;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Yii;

class SettingsController extends BaseSettingsController {

    /**
     * Shows profile settings form.
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

        $request = \Yii::$app->request->post();

        if (isset($request['ajax'])) $this->performAjaxValidation($model);


        if (\Yii::$app->request->isPost) {
            $model->avatar = UploadedFile::getInstance($model, 'avatar');

            if ($model->avatar && $model->validate()) {
                $path = \Yii::getAlias('@app/web/uploads/users/' . \Yii::$app->user->identity->getId() . '/avatar');
                if (is_dir($path)) {
                    FileHelper::removeDirectory($path);
                }
                FileHelper::createDirectory($path);
                if ($model->avatar->saveAs($path . '/' . $model->avatar->baseName . '.' . $model->avatar->extension)) {
                    $request['Profile']['avatar'] = $model->avatar->baseName . '.' . $model->avatar->extension;

                }
            }
        }

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
} 