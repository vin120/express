<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\modules\api\models\Ad;
use app\modules\api\components\Components;
use app\modules\api\models\User;
use app\modules\api\models\PhoneCode;



class UserController extends BaseController
{
	public function actionGetinfo()
	{
		$sign = Yii::$app->request->post('sign');
		
		
		if(empty($sign)){
			$response = ['code'=> 1, 'msg'=>'sign can not be blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		$user = User::find()->where('sign = :sign',[':sign'=>$sign])->one();
		
	
		if(is_null($user)){
			$response = ['code'=> 2, 'msg'=>'sign wrong'];
			return $response;
			Yii::$app->end();
		}
		
		unset($user['user_id']);
		unset($user['user_password']);
		unset($user['user_status']);
		unset($user['reg_time']);
		
		if(is_null($user['user_address'])){
			$user['user_address'] = "";
		}
		
		$data = $user;
		
		$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
		
		return $response;
		
	}
}