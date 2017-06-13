<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\modules\api\models\Admin;
use app\modules\api\models\User;

class AuthController extends BaseController
{
	public function actionZhuhailogin()
	{
		
		/*
		 *		code : 0 , msg : "success",
				code : 1 , msg : "password wrong",
				code : 2 , msg : "worker code not exist",
				code : 3 , msg : "admin_name or admin_password can not be blank "
				code : 4 , msg : "admin_type can not be blank and admin_type must be 2" 
				code : 5 , msg : "you now forbidden"
				code : 6 , msg : "you not belong zhuhai"
		 * 
		 * 
		 * 
		 		admin_type :  	0 充值管理員，
		 						1 派件管理員 ，
		 						2 珠海掃描管理員，
		 						3 澳門掃描管理員
		 
		 * 
		 * 
		 * reuqest :
		 		admin_name=zhuhai001
		 		admin_password=123456
		 		admin_type=2
		 * 
		 * 
		 * response : 
		 * 

		    {
		        "code": 0,
		        "msg": "success",
		        "data":
		        {
		            "name": "羅偉栓",
		            "admin_type": 2,
		            "sign": "6d7e44f2283c78a7de71641fc467764e"
		        }
		    }
		    

		 */
		
		
		$response = [];
		if(Yii::$app->request->isPost){
			$admin_name = Yii::$app->request->post('admin_name');
			$admin_password = Yii::$app->request->post('admin_password');
			$admin_type = Yii::$app->request->post('admin_type');
			
			
			if(empty($admin_name) || empty($admin_password)){
				$response = ['code'=> 3, 'msg'=>'admin_name or admin_password can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
		
			if(empty($admin_type) || $admin_type != 2){
				$response = ['code'=> 4, 'msg'=>'admin_type can not be blank and admin_type must be 2'];
				return $response;
				Yii::$app->end();
			}
			
			
			$admin = Admin::find()->where("admin_name = :admin_name and admin_type=2",[':admin_name'=>$admin_name])->one();
			
			if(is_null($admin)) {
				$response = ['code'=> 2, 'msg'=>'admin not exist'];
				return $response;
				Yii::$app->end();
			}
			
			
			if($admin->admin_password != md5($admin_password)){
				$response = ['code'=> 1, 'msg'=>'password wrong'];
				return $response;
				Yii::$app->end();
			}
			
			if($admin->admin_status != 1){
				$response = ['code'=> 5, 'msg'=>'you now forbidden'];
				return $response;
				Yii::$app->end();
			}
			
			
			if($admin->admin_type != 2){
				$response = ['code'=> 6, 'msg'=>'you not belong zhuhai'];
				return $response;
				Yii::$app->end();
			}
				
			
			
			$data['name'] = $admin->admin_real_name;
			$data['admin_type'] = $admin->admin_type;
			$data['sign'] = $admin->sign;
			
			$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
			
			
			
		} else {
			$response = ['code'=> 3, 'msg'=>'admin_name or admin_password can not be blank'];
		}
		
		return $response;
	}
	
	
	public function actionMacaulogin()
	{
		
		/*
		 * 
		 * 
		 * 		code : 0 , msg : "success",
				code : 1 , msg : "password wrong",
				code : 2 , msg : "worker code not exist",
				code : 3 , msg : "worker code or password can not be blank"
				code : 4 , msg : "city can not be blank and city must be macau" 
				code : 5 , msg : "you now forbidden"
				code : 6 , msg : "you not belong macau"


			reuqest :
		 		admin_name=macau001
		 		admin_password=123456
		 		admin_type=3



			response :

		    {
		        "code": 0,
		        "msg": "success",
		        "data":
		        {
					"name": "江奕銘",
			        "admin_type": 3,
			        "sign": "25ac5a8b29312118cff6fd0070e72ade"
		        }
		    }

*/
		
	$response = [];
		if(Yii::$app->request->isPost){
			$admin_name = Yii::$app->request->post('admin_name');
			$admin_password = Yii::$app->request->post('admin_password');
			$admin_type = Yii::$app->request->post('admin_type');
			
			
			if(empty($admin_name) || empty($admin_password)){
				$response = ['code'=> 3, 'msg'=>'admin_name or admin_password can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
		
			if(empty($admin_type) || $admin_type != 3){
				$response = ['code'=> 4, 'msg'=>'admin_type can not be blank and admin_type must be 3'];
				return $response;
				Yii::$app->end();
			}
			
			
			$admin = Admin::find()->where("admin_name = :admin_name and admin_type=3",[':admin_name'=>$admin_name])->one();
			
			if(is_null($admin)) {
				$response = ['code'=> 2, 'msg'=>'admin not exist'];
				return $response;
				Yii::$app->end();
			}
			
			
			if($admin->admin_password != md5($admin_password)){
				$response = ['code'=> 1, 'msg'=>'password wrong'];
				return $response;
				Yii::$app->end();
			}
			
			if($admin->admin_status != 1){
				$response = ['code'=> 5, 'msg'=>'you now forbidden'];
				return $response;
				Yii::$app->end();
			}
			
			if($admin->admin_type != 3){
				$response = ['code'=> 6, 'msg'=>'you not belong macau'];
				return $response;
				Yii::$app->end();
			}
			
			$data['name'] = $admin->admin_real_name;
			$data['admin_type'] = $admin->admin_type;
			$data['sign'] = $admin->sign;
			
			$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
			
			
			
		} else {
			$response = ['code'=> 3, 'msg'=>'admin_name or admin_password can not be blank'];
		}
		
		return $response;
	}
	
	
	public function actionGetuserinfo()
	{
		/*
		 * request : 
		 	user_phone=13710320761
		 		
		 		
		 	response :
	
		    {
		        "code": 0,
		        "msg": "success",
		        "data":
		        {
					"phone": "13710320761",
			        "real_name": "羅偉栓",
			        "address": "廣東香洲紫荊路323號大學生創業孵化園"
		        }
		    }

		 * */
		
		
		$response = [];
		$data = [];
		
		if(Yii::$app->request->isPost){
			$user_phone = Yii::$app->request->post('user_phone');
			
			if(empty($user_phone)) {
				$response = ['code'=> 1, 'msg'=>'user_phone can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			
			$user = User::find()->where('user_phone = :user_phone ',[':user_phone'=>$user_phone])->one();
			
			if(is_null($user)){
				$response = ['code'=> 2, 'msg'=>'user does not exists'];
				return $response;
				Yii::$app->end();
			}
			
			if($user->user_status != 1){
				$response = ['code'=> 3, 'msg'=>'user now forbidden'];
				return $response;
				Yii::$app->end();
			}
			
			
			$data['phone'] = $user->user_phone;
			$data['real_name'] = $user->user_real_name;
			$data['address'] = $user->user_address;
			
			
			$response = ['code' => 0, 'msg'=>'success','data'=>$data];
			
		} else {
			$response = ['code'=> 1, 'msg'=>'user_phone can not be blank'];
		}
		return $response;
		
	}
	
	
	
}