<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\modules\api\models\User;
use app\modules\api\models\Disclaimer;
use app\modules\api\models\Goods;


class UserController extends BaseController
{
	
	/**
	 * 獲取用戶信息
	 * @return number[]|string[]|number[]|string[]|\yii\db\ActiveRecord[]|array[]|NULL[]
	 */
	public function actionGetuserinfo()
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
	
	/**	後期要廢棄掉
	 * 免責聲明
	 * @return number[]|string[]|\yii\db\ActiveRecord[]|array[]|NULL[]
	 */
	public function actionDisclaimer()
	{
		$disclaimer = Disclaimer::find()->where('disclaimer_id=1')->one();
		
		if(!is_null($disclaimer)){
			unset($disclaimer['disclaimer_id']);
		}
		
		$data['disclaimer'] = $disclaimer->disclaimer_content;
		
		$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
		
		return $response;
	}
	
	
	/**
	 *  查詢取貨記錄
	 * @return number[]|string[]|number[]|string[]|array[]|\yii\db\ActiveRecord[][]
	 */
	public function actionDelivery()
	{
		$sign = Yii::$app->request->post('sign');
		$done = Yii::$app->request->post('done');
		
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
		
		
		$user_phone = $user->user_phone;
		
		if(empty($done)){
			$andwhere = "status = 0 or status = 1";
		} else {
			$andwhere= "status = 2";
		}
		
		
		$goods = Goods::find()->where('user_phone=:user_phone',[':user_phone'=>$user_phone])->andWhere($andwhere)->orderBy('goods_id desc')->all();
		
		
		if(!is_null($goods)){
			foreach ($goods as $key => $row){
				unset($goods[$key]['zh_admin_name']);
				unset($goods[$key]['mo_admin_name']);
				unset($goods[$key]['mo_admin_name2']);
			
				if(is_null($goods[$key]['area'])){
					$goods[$key]['area'] = "";
				}
				
				if(is_null($goods[$key]['pay_way'])){
					$goods[$key]['pay_way'] = "";
				}
				
				$goods[$key]['update_time'] = strtotime($goods[$key]['update_time']."+ 4 day");
			}
		}
		
		$data = $goods;
		$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
		
		return $response;
		
	}
	
	
	
	
	
	
	
	
	
	
}