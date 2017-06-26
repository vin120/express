<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\modules\api\models\User;
use app\modules\api\models\Goods;
use app\modules\api\models\Admin;


class PayclientController extends BaseController
{
	
	/**
	 * 支付端的登錄
	 * @return array|number[]|string[]|number[]|string[]
	 */
	public function actionLogin()
	{
		
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
			
			
			if(empty($admin_type) || $admin_type != 1){
				$response = ['code'=> 4, 'msg'=>'admin_type can not be blank and admin_type must be 1'];
				return $response;
				Yii::$app->end();
			}
			
			
			$admin = Admin::find()->where("admin_name = :admin_name and admin_type=1",[':admin_name'=>$admin_name])->one();
			
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
			
			if($admin->admin_type != 1){
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
	
	
	public function actionGetorders()
	{
		$user_phone = Yii::$app->request->post('user_phone');
		
		
		if(empty($user_phone)){
			$response = ['code'=> 3, 'msg'=>'user_phone can not be blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		$goods = Goods::find()->where('user_phone = :user_phone and status = 1',[':user_phone'=>$user_phone])->orderBy('goods_id desc')->all();
		
		if(!is_null($goods)){
			foreach ($goods as $key => $value){
				unset($goods[$key]['zh_admin_name']);
				unset($goods[$key]['mo_admin_name']);
				unset($goods[$key]['mo_admin_name2']);
				unset($goods[$key]['pay_way']);
				unset($goods[$key]['status']);
				
				$goods[$key]['update_time'] = strtotime($goods[$key]['update_time']."+ 4 day");
				
			}
		}
		
		
		$data = $goods;
		
		$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
		
		return $response;
		
		
	}
	
	
	
	public function actionPay()
	{
		$goods_id = Yii::$app->request->post('goods_id');
		$pay_way = Yii::$app->request->post('pay_way');
		$sign = Yii::$app->request->post('sign');
		
		
		$admin = Admin::find()->where('sign=:sign',[':sign'=>$sign])->one();
		$goods = Goods::find()->where('goods_id=:goods_id',[':goods_id'=>$goods_id])->one();
		
		
		
		if(empty($goods_id)){
			$response = ['code'=> 1, 'msg'=>'goods_id can not be blank'];
			return $response;
			Yii::$app->end();
		}

		
		if(empty($pay_way)){
			$response = ['code'=> 2, 'msg'=>'pay_way can not be blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		if(empty($sign)){
			$response = ['code'=> 3, 'msg'=>'sign can not be blank'];
			return $response;
			Yii::$app->end();
		}
		
		
		
		
		if(is_null($admin)){
			$response = ['code'=> 4, 'msg'=>'sign wrong'];
			return $response;
			Yii::$app->end();
		}
		
		
		
		if(is_null($goods)){
			$response = ['code'=> 5, 'msg'=>'goods does not exists'];
			return $response;
			Yii::$app->end();
		}
		
		
		
		$user = User::find()->where('user_phone = :user_phone',[':user_phone'=>$goods->user_phone])->one();
		
		
		if(is_null($user)){
			$response = ['code'=> 6, 'msg'=>'can not find user'];
			return $response;
			Yii::$app->end();
		}
		
		
		
		if($pay_way == 2){
			//網上支付
			//判斷用戶餘額是否夠支付
			if($user->money >= $goods->price){
				//足夠錢支付
				$user->money -= $goods->price;
				$user->save();
				
				
			}else{
				//錢不夠
				$response = ['code'=> 7, 'msg'=>'not enough money to pay the order'];
				return $response;
				Yii::$app->end();
			}
		}
		
		
	
		$goods->mo_admin_name2 = $admin->admin_name;
		$goods->pay_way = $pay_way;
		$goods->update_time = date("Y-m-d H:i:s",time());
		$goods->status = 2;
		$goods->save();
		
		
		
		$response = ['code'=> 0, 'msg'=>'success'];
		
		return $response;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}