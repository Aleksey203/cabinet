<?php
/** File: RecoveryController.php Date: 06.04.15 Time: 14:11 */



namespace app\modules\user\controllers;

use dektrium\user\controllers\RecoveryController as BaseRecoveryController;
use dektrium\user\Finder;
use dektrium\user\traits\AjaxValidationTrait;


class RecoveryController extends BaseRecoveryController {

    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->layout = 'enter';
        parent::__construct($id, $module, $finder, $config);
    }
} 