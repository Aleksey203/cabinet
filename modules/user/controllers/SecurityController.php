<?php
/** File: RecoveryController.php Date: 06.04.15 Time: 14:11 */



namespace app\modules\user\controllers;

use dektrium\user\controllers\SecurityController as BaseSecurityController;

use dektrium\user\models\LoginForm;
use Yii;
use dektrium\user\traits\AjaxValidationTrait;


class SecurityController extends BaseSecurityController {

    /**
     * Displays the login page.
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            //$this->goHome();
            $this->redirect(['settings/profile']);
        }

        $model = \Yii::createObject(LoginForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->redirect(['settings/profile']);
        }

        $this->layout = 'enter';

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }

    /**
     * Logs the user out and then redirects to the homepage.
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->getUser()->logout();
        //return $this->goHome();
        return $this->redirect(['security/login']);
    }
} 