<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\modules\api\models\Goods;

class GoodsController extends BaseController
{
	
	public function actionZhuhaiupload()
	{
		$data = [];
		
		if(Yii::$app->request->isPost){
			
			$worker_code = Yii::$app->request->post('worker_code');
			$bar_code = Yii::$app->request->post('bar_code');
			$user_code = Yii::$app->request->post('user_code');
			$length = Yii::$app->request->post('length');
			$width = Yii::$app->request->post('width');
			$height = Yii::$app->request->post('height');
			$weight = Yii::$app->request->post('weight');
			
			
			if(empty($worker_code)){
				$response = ['code'=> 2, 'msg'=>'worker code can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			
			if(empty($bar_code)){
				$response = ['code'=> 3, 'msg'=>'bar code can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			if(empty($user_code)){
				$response = ['code'=> 4, 'msg'=>'user code can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			if(empty($length) || empty($width) || empty($height) || empty($weight) ){
				$response = ['code'=> 5, 'msg'=>'length,width,height,weight can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
		
			
			$goods = Goods::find()->where('bar_code = :bar_code',[':bar_code'=>$bar_code])->one();
			
			if(is_null($goods)){
				$goods = new Goods();
			}
			
			$goods->bar_code = $bar_code;
			$goods->user_code = $user_code;
			$goods->zh_worker_code = $worker_code;
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
	
	
	public function actionMacauupload()
	{
		if(Yii::$app->request->isPost){
			$worker_code = Yii::$app->request->post('worker_code');
			$bar_code = Yii::$app->request->post('bar_code');
			$area = Yii::$app->request->post('area');
			
			
			if(empty($worker_code)){
				$response = ['code'=> 2, 'msg'=>'worker code can not be blank'];
				return $response;
				Yii::$app->end();
			}
			
			if(empty($bar_code)){
				$response = ['code'=> 3, 'msg'=>'bar code can not be blank'];
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
			
			
			Goods::updateAll(['area'=>$area,'mo_worker_code'=>$worker_code,'update_time'=>date("Y-m-d H:i:s",time()),'status'=>1],'bar_code = :bar_code',[':bar_code'=>$bar_code]);
			
			$response = ['code'=> 0, 'msg'=>'success'];
			
		} else {
			$response = ['code'=> 1, 'msg'=>'data can not be blank'];
		}
		
		return $response;
	}
	

	
	
	
}