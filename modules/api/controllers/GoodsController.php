<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;

class GoodsController extends BaseController
{
	
	public function actionZhuhaiupload()
	{
		
		if(Yii::$app->request->isPost){
			
			
			
		} else {
			$response = ['code'=> 1, 'msg'=>'data can not be blank'];
		}
		
		return $response;
	}
	
	
	public function actionMacauupload()
	{
	
	}
	

	
	
	
}