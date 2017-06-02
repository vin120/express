<?php

namespace app\modules\admin;

use Yii;
use yii\base\Theme;

class admin extends \yii\base\Module
{
	public $controllerNamespace =  'app\modules\admin\controllers';
	public $layout = "@app/modules/admin/themes/views/layouts/basicLayout.php";
	
	public function init() 
	{
		parent::init();
		
		// custom initialization code goes here
		\Yii::$app->view->theme = new Theme([
				'basePath' => '@app/modules/admin/themes/basic',
				'pathMap' => ['@app/modules/admin/views' => '@app/modules/admin/themes/basic/views'],
				'baseUrl' => '@app/modules/admin/themes/basic',
		]);
		
		\Yii::$app->errorHandler->errorAction = 'admin/error/index';
	}
	
}