<?php
/** File: RecoveryController.php Date: 06.04.15 Time: 14:11 */



namespace app\modules\user\controllers;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use dektrium\user\Finder;
use dektrium\user\traits\AjaxValidationTrait;
use app\modules\user\models\RegistrationForm;
use yii\web\NotFoundHttpException;


class RegistrationController extends BaseRegistrationController {

    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->layout = 'enter';
        parent::__construct($id, $module, $finder, $config);
    }

    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException;
        }

        $model = \Yii::createObject(RegistrationForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            return $this->redirect(['settings/profile']);
        }

        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
} 