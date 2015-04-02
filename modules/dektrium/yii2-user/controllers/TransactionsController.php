<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dektrium\user\controllers;

use dektrium\user\Finder;
use dektrium\user\models\Transactions;
use dektrium\user\models\User;
use yii\base\Model;

use yii\web\Controller;
use yii\filters\AccessControl;

use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * SettingsController manages updating user settings (e.g. profile, email and password).
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class TransactionsController extends Controller
{
    /** @inheritdoc */
    public $defaultAction = 'withdraw';

    /** @var Finder */
    protected $finder;

    /**
     * @param string $id
     * @param \yii\base\Module $module
     * @param Finder $finder
     * @param array $config
     */
    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['withdraw'],
                        'roles'   => ['@']
                    ],
                ]
            ],
        ];
    }

    /** @inheritdoc */
    public function actions()
    {
        return [
            'connect' => [
                'class'           => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'connect'],
            ]
        ];
    }

    /**
     * Функция снятия либо зачисления средств на счёт
     */
    public function actionWithdraw($type = 'plus', $summ=55)
    {
        $model = User::findOne(\Yii::$app->user->identity->getId());

        if ($type == 'minus') $model->balance -= $summ;
        if ($type == 'plus') $model->balance += $summ;

        if ($model->balance>=0) {
            if ($model->save(false)) {
                $transaction = new Transactions();
                $transaction->setAttribute('date', time());
                $transaction->setAttribute('user_id', \Yii::$app->user->identity->getId());
                $transaction->setAttribute('summa', $summ);
                if ($type == 'minus') {
                    $transaction->setAttribute('summa', -1*$summ);
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Услуга успешно оплачена! Списано '.$summ.' руб.'));
                }
                if ($type == 'plus')
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Ваш счёт успешно пополнен на '.$summ.' руб.!'));
                $transaction->save();
            }
        }
        else {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'У Вас недостаточно средств на счету'));
        }

        $profile = $this->finder->findProfileById(\Yii::$app->user->getId());

        if ($profile === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('show', [
            'profile' => $profile,
        ]);

    }

}
