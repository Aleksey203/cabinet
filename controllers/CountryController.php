<?php

namespace app\controllers;

use Yii;
use app\models\Country;
use app\models\CountrySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends Controller
{
/*    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->request->isAjax) {
            $data = array();

            $data['html'] = date('H:i:s');

            return json_encode($data);
        }

        return $this->render('index');
    }

}
