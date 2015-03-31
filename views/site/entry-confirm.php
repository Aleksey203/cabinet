<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Say';
//$this->params['breadcrumbs'][] = $this->title;
?>
<p>Вы ввели следующую информацию:</p>
<ul>
<li><label>Имя</label>: <?=Html::encode($model->name);?></li>
<li><label>Email</label>: <?=Html::encode($model->email);?></li>
</ul>


