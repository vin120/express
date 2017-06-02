<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\modules\api\models\Worker;
use app\modules\api\models\User;

class AuthController extends BaseController
{
	public function actionZhuhailogin()
	{
		
		/*
		 *		code : 0 , msg : "success",
				code : 1 , msg : "password wrong",
				code : 2 , msg : "worker code not exist",
				code : 3 , msg : "worker code or password can not be blank "
				code : 4 , msg : "city can not be blank and city must be zhuhai" 
				code : 5 , msg : "you now forbidden"
		 * 
		 * 
		 * reuqest :
		 		worker_code=zhuhai001
		 		password=123456
		 		city=zhuhai
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
		            "city": "zhuhai",
		            "worker_code": "zhuhai001"
		        }
		    }


		 */
		
		
		$response = [];
		if(Yii::$app->request->isPost){
			$worker_code = Yii::$app->request->post('worker_code');
			$password = Yii::$app->request->post('password');
			$city = Yii::$app->request->post('city');
			
			
			if(empty($worker_code) || empty($password)){
				$response = ['code'=> 3, 'msg'=>'worker code or password can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
		
			if(empty($city) || $city != "zhuhai"){
				$response = ['code'=> 4, 'msg'=>'city can not be blank and city must be zhuhai'];
				return $response;
				Yii::$app->end();
			}
			
			
			$worker = Worker::find()->where("worker_code = :worker_code and city='zhuhai'",[':worker_code'=>$worker_code])->one();
			
			if(is_null($worker)) {
				$response = ['code'=> 2, 'msg'=>'worker code not exist'];
				return $response;
				Yii::$app->end();
			}
			
			
			if($worker->password != md5($password)){
				$response = ['code'=> 1, 'msg'=>'password wrong'];
				return $response;
				Yii::$app->end();
			}
			
			if($worker->status != 1){
				$response = ['code'=> 5, 'msg'=>'you now forbidden'];
				return $response;
				Yii::$app->end();
			}
			
			
			
			$data['name'] = $worker->name;
			$data['city'] = $worker->city;
			$data['worker_code'] = $worker->worker_code;
			
			$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
			
			
			
		} else {
			$response = ['code'=> 3, 'msg'=>'worker code or password can not be blank'];
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


			reuqest :
		 		worker_code=macau001
		 		password=123456
		 		city=macau



			response :

		    {
		        "code": 0,
		        "msg": "success",
		        "data":
		        {
		            "name": "江奕銘",
		            "city": "macau",
		            "worker_code": "macau001"
		        }
		    }

*/
		
		$response = [];
		$data = [];
		if(Yii::$app->request->isPost){
			$worker_code = Yii::$app->request->post('worker_code');
			$password = Yii::$app->request->post('password');
			$city = Yii::$app->request->post('city');
				
				
			if(empty($worker_code) || empty($password)){
				$response = ['code'=> 3, 'msg'=>'worker code or password can not be blank'];
				return $response;
				Yii::$app->end();
			}
				
		
			if(empty($city) || $city != "macau"){
				$response = ['code'=> 4, 'msg'=>'city can not be blank and city must be macau'];
				return $response;
				Yii::$app->end();
			}
				
				
			$worker = Worker::find()->where("worker_code = :worker_code and city='macau'",[':worker_code'=>$worker_code])->one();
				
			if(is_null($worker)) {
				$response = ['code'=> 2, 'msg'=>'worker code not exist'];
				return $response;
				Yii::$app->end();
			}
				
				
			if($worker->password != md5($password)){
				$response = ['code'=> 1, 'msg'=>'password wrong'];
				return $response;
				Yii::$app->end();
			}
				
			if($worker->status != 1){
				$response = ['code'=> 5, 'msg'=>'you now forbidden'];
				return $response;
				Yii::$app->end();
			}
				
			
			$data['name'] = $worker->name;
			$data['city'] = $worker->city;
			$data['worker_code'] = $worker->worker_code;
				
			$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
				
			
		} else {
			$response = ['code'=> 3, 'msg'=>'worker code or password can not be blank'];
		}
		
		return $response;
			
	}
	
	
	public function actionCheckusercode()
	{
		/*
		 * request : 
		 	user_code=ytj001
		 		
		 		
		 	response :
	
		    {
		        "code": 0,
		        "msg": "success",
		        "data":
		        {
		            "user_code": "ytj001",
		            "phone": "13710320761",
		            "real_name": "羅偉栓",
		            "address": "廣東香洲紫荊路323號大學生創業孵化園"
		        }
		    }

		 * */
		
		
		$response = [];
		$data = [];
		
		if(Yii::$app->request->isPost){
			$user_code = Yii::$app->request->post('user_code');
			
			if(empty($user_code)) {
				$response = ['code'=> 1, 'msg'=>'user_code can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			
			$user = User::find()->where('user_code = :user_code and status = 1',[':user_code'=>$user_code])->one();
			
			if(is_null($user)){
				$response = ['code'=> 2, 'msg'=>'user does not exists'];
				return $response;
				Yii::$app->end();
			}
			
			if($user->status != 1){
				$response = ['code'=> 3, 'msg'=>'user now forbidden'];
				return $response;
				Yii::$app->end();
			}
			
			
			$data['user_code'] = $user->user_code;
			$data['phone'] = $user->phone;
			$data['real_name'] = $user->real_name;
			$data['address'] = $user->address;
			
			$response = ['code' => 0, 'msg'=>'success','data'=>$data];
			
		} else {
			$response = ['code'=> 1, 'msg'=>'user_code can not be blank'];
		}
		return $response;
		
	}
	
	
	
}