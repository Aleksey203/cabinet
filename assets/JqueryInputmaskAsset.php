<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class JqueryInputmaskAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.inputmask';
    public $js = [
        'dist/jquery.inputmask.bundle.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
