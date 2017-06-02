<?php

namespace app\modules\api;

use Yii;
use yii\base\Theme;

class api extends \yii\base\Module
{
	public $controllerNamespace =  'app\modules\api\controllers';
	public $layout = "@app/modules/api/themes/views/layouts/basicLayout.php";
	
	public function init() 
	{
		parent::init();
		
		// custom initialization code goes here
		\Yii::$app->view->theme = new Theme([
				'basePath' => '@app/modules/api/themes/basic',
				'pathMap' => ['@app/modules/api/views' => '@app/modules/api/themes/basic/views'],
				'baseUrl' => '@app/modules/api/themes/basic',
		]);
		
		\Yii::$app->errorHandler->errorAction = 'api/error/index';
		\Yii::$app->user->enableSession = false;
	}
	
}