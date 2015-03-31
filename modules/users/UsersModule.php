<?php

namespace app\modules\users;

class UsersModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\users\controllers';

    public function init()
    {
        parent::init();

        $this->params['me'] = '203';

        // custom initialization code goes here
    }
}
