<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\modules\api\models\Ad;
use app\modules\api\components\Components;
use app\modules\api\models\User;
use app\modules\api\models\PhoneCode;
use app\modules\api\models\News;



class AppController extends BaseController
{
	
	/**
	 *  啓動頁面廣告圖片
	 * @return number[]|string[]
	 */
// 	public function actionAdpic()
// 	{
// 		$ad = Ad::find()->where('status=1')->one()['ad_img_url'];
		
// 		if(is_null($ad)){
// 			$ad = "";
// 		}
			
// 		$data['ad'] = $ad;
		
// 		$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
	
// 		return $response;
// 	}
	
	
	/**
	 * 用戶註冊
	 * @return number[]|string[]
	 */
	public function actionRegister()
	{
		
		$user_name = Yii::$app->request->post('user_name');
		$user_phone = Yii::$app->request->post('user_phone');
		$user_password = Yii::$app->request->post('user_password');
		
		
		if(empty($user_name)){
			$response = ['code'=> 2, 'msg'=>'user_name can not blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		if(empty($user_phone)){
			$response = ['code'=> 3, 'msg'=>'user_phone can not blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		if(!Components::isMacauPhone($user_phone)){
			$response = ['code'=> 4, 'msg'=>'user_phone format wrong'];
			return $response;
			Yii::$app->end();
		}
		
		
		$user = User::find()->where('user_phone = :user_phone',[':user_phone'=>$user_phone])->one();
		
		if(!is_null($user)){
			$response = ['code'=> 5, 'msg'=>'user_phone already exists'];
			return $response;
			Yii::$app->end();
		}
		
		
		
		if(empty($user_password)){
			$response = ['code'=> 6, 'msg'=>'user_password can not blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		if(strlen($user_password) != 6){
			$response = ['code'=> 7, 'msg'=>'user_password must be 6 numbers '];
			return $response;
			Yii::$app->end();
		}
		
		$user = new User;
		$user->user_name = $user_name;
		$user->user_phone = $user_phone;
		$user->user_password = md5($user_password);
		$user->reg_time = date("Y-m-d H:i:s",time());
		$user->user_status = 1;
		$user->sign = md5(md5($user_phone).md5($user_password));
		
		if($user->save()){
			$response = ['code'=> 0, 'msg'=>'regist success'];
		} else {
			$response = ['code'=> 1, 'msg'=>'regist fail'];
		}
		
		return $response;
		
	}
	
	
	
	/**
	 * 	用戶登錄
	 * @return number[]|string[]|number[]|string[]|\yii\db\ActiveRecord[]|NULL[]
	 */
	public function actionLogin()
	{
		$user_phone = Yii::$app->request->post('user_phone');
		$user_password = Yii::$app->request->post('user_password');
		
		if(empty($user_phone)){
			$response = ['code'=> 1, 'msg'=>'user_phone can not blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		if(empty($user_password)){
			$response = ['code'=> 2, 'msg'=>'user_password can not blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		$user = User::find()->where('user_phone = :user_phone and user_password =:user_password',[':user_phone'=>$user_phone,':user_password'=>md5($user_password)])->one();
		
		
		if(is_null($user)){
			$response = ['code'=> 3, 'msg'=>'user_phone or user_password wrong'];
			return $response;
			Yii::$app->end();
		}
		
		
		if($user->user_status == 0){
			$response = ['code'=> 4, 'msg'=>'you now forbidden'];
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
	
	
	/**
	 * 獲取驗證碼
	 * @return number[]|string[]
	 */
	public function actionGetcode()
	{
		$user_phone = Yii::$app->request->post('user_phone');
		
		if(empty($user_phone)){
			$response = ['code'=> 2, 'msg'=>'user_phone can not blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		if(!Components::isMacauPhone($user_phone)){
			$response = ['code'=> 3, 'msg'=>'user_phone format wrong'];
			return $response;
			Yii::$app->end();
		}
		
		
		if(!PhoneCode::SendMsn($user_phone)){
			$response = ['code'=> 1, 'msg'=>'try again after 1 minutes '];
			return $response;
			Yii::$app->end();
		} else {
			$response = ['code'=> 0, 'msg'=>'send success'];
		}
		
		
		return $response;
		
	}
	
	
	/**
	 * 忘記密碼，通過短信驗證碼重置
	 * @return number[]|string[]
	 */
	public function actionForgetpassword()
	{
		$user_phone = Yii::$app->request->post('user_phone');
		$code = Yii::$app->request->post('code');
		$user_password =  Yii::$app->request->post('user_password');
		
		
		$phone_code = PhoneCode::find()->where('phone = :phone',[':phone'=>$user_phone])->one();
		
		if (empty($user_phone) || empty($user_password) || empty($code)){
			$response = ['code'=> 2, 'msg'=>'user_phone  , user_password , code can not blank'];
			return $response;
			Yii::$app->end();
		}
		
		if(empty($phone_code)){
			$response = ['code'=> 3, 'msg'=>'code wrong'];
			return $response;
			Yii::$app->end();
		}
		
		
		if($phone_code->time < time()){
			$response = ['code'=> 4, 'msg'=>'code out of date'];
			return $response;
			Yii::$app->end();
		}
		
		if($phone_code->code_num != $code){
			$response = ['code'=> 3, 'msg'=>'code wrong'];
			return $response;
			Yii::$app->end();
		}
		
		
		$user = User::find()->where('user_phone = :user_phone',[':user_phone'=>$user_phone])->one();
		
		
		if(empty($user)){
			$response = ['code'=> 5, 'msg'=>'user_phone does not exist'];
			return $response;
			Yii::$app->end();
		}
		
		
		if(strlen($user_password) != 6){
			$response = ['code'=> 6, 'msg'=>'user_password must be 6 numbers '];
			return $response;
			Yii::$app->end();
		}
		

		$user->user_password = md5($user_password);
		$user->sign = md5(md5($user_phone).md5($user_password));
		
		if($user->save()){
			$response = ['code'=> 0, 'msg'=>'success'];
		} else {
			$response = ['code'=> 1, 'msg'=>'fail'];
		}
		
		return $response;
		
	}
	
	/**
	 * 獲取公告信息
	 * @return number[]|string[]|array[]|\yii\db\ActiveRecord[][]
	 */
	public function actionNews()
	{
		$page = Yii::$app->request->post('page');
		$size = Yii::$app->request->post('size');
		
		if(empty($page)){
			$page = 0;
		}
		
		if(empty($size)){
			$size = 3;
		}
		
		
		$news = News::find()->where('news_status=1')->orderBy('news_id desc')->offset($page)->limit($size)->all();
		
		foreach ($news as $key => $row){
			unset($news[$key]['news_status']);
		}
		
		$data = $news;
	
		
		$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
		return $response;
		
	}
	
	
	
	
}