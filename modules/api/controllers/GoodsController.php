<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\modules\api\models\Goods;
use app\modules\api\models\Admin;

class GoodsController extends BaseController
{
	/**
	 * 掃描槍接口(珠海上傳)
	 * @return number[]|string[]
	 */
	public function actionZhuhaiupload()
	{
		$data = [];
		
		if(Yii::$app->request->isPost){
			
			$sign = Yii::$app->request->post('sign');
			$bar_code = Yii::$app->request->post('bar_code');
			$user_phone = Yii::$app->request->post('user_phone');
			$length = Yii::$app->request->post('length');
			$width = Yii::$app->request->post('width');
			$height = Yii::$app->request->post('height');
			$weight = Yii::$app->request->post('weight');
			
			
			if(empty($sign)){
				$response = ['code'=> 2, 'msg'=>'sign code can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			
			if(empty($bar_code)){
				$response = ['code'=> 3, 'msg'=>'bar_code can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			if(empty($user_phone)){
				$response = ['code'=> 4, 'msg'=>'user_phone can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			if(empty($length) || empty($width) || empty($height) || empty($weight) ){
				$response = ['code'=> 5, 'msg'=>'length,width,height,weight can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
		
			$admin = Admin::find()->where('sign=:sign',[':sign'=>$sign])->one();
			
			if(is_null($admin)){
				$response = ['code'=> 6, 'msg'=>'sign wrong'];
				return $response;
				Yii::$app->end();
			}
				
			
			$goods = Goods::find()->where('bar_code = :bar_code',[':bar_code'=>$bar_code])->one();
			
			if(is_null($goods)){
				$goods = new Goods();
			}
			
			$goods->bar_code = $bar_code;
			$goods->user_phone = $user_phone;
			$goods->zh_admin_name = $admin->admin_name;
			$goods->length = $length;
			$goods->width = $width;
			$goods->height = $height;
			$goods->weight = $weight;
			$goods->update_time = date("Y-m-d H:i:s",time());
			$goods->status = 0;
			$goods->save();
			
			$response = ['code'=> 0, 'msg'=>'success'];
		} else {
			$response = ['code'=> 1, 'msg'=>'data can not be blank'];
		}
		
		return $response;
	}
	
	
	/**
	 * 掃描槍(澳門上傳)
	 * @return number[]|string[]
	 */
	public function actionMacauupload()
	{
		if(Yii::$app->request->isPost){
			$sign = Yii::$app->request->post('sign');
			$bar_code = Yii::$app->request->post('bar_code');
			$area = Yii::$app->request->post('area');
			
			
			if(empty($sign)){
				$response = ['code'=> 2, 'msg'=>'sign can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			if(empty($bar_code)){
				$response = ['code'=> 3, 'msg'=>'bar_code can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			$goods = Goods::find()->where('bar_code = :bar_code',[':bar_code'=>$bar_code])->one();
			if(is_null($goods)){
				$response = ['code'=> 4, 'msg'=>'bar code wrong'];
				return $response;
				Yii::$app->end();
			}
			
			
			if(empty($area)){
				$response = ['code'=> 5, 'msg'=>'area can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			
			$admin = Admin::find()->where('sign = :sign',[':sign'=>$sign])->one();
			
			if(is_null($admin)){
				$response = ['code'=> 6, 'msg'=>'sign wrong'];
				return $response;
				Yii::$app->end();
			}
			
			
			
			Goods::updateAll(['area'=>$area,'mo_admin_name'=>$admin->admin_name,'update_time'=>date("Y-m-d H:i:s",time()),'status'=>1],'bar_code = :bar_code',[':bar_code'=>$bar_code]);
			
			$response = ['code'=> 0, 'msg'=>'success'];
			
		} else {
			$response = ['code'=> 1, 'msg'=>'data can not be blank'];
		}
		
		return $response;
	}
	

	
	
	
}