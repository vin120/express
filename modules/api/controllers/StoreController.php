<?php

namespace  app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\modules\api\models\Store;
use app\modules\api\models\ZhStore;


class StoreController extends BaseController
{
	
	/**
	 * 澳門取貨店鋪
	 * @return number[]|string[]|array[]|\yii\db\ActiveRecord[][]
	 */
	public function actionStores()
	{
		$stores = Store::find()->where('store_status=1')->all();
		
		if(!is_null($stores)){
			foreach ($stores as $key => $row){
				unset($stores[$key]['store_status']);
			}
		}
		
		
		$data = $stores;
		$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
		return $response;
		
		
	}
	
	/**
	 * 珠海收貨店鋪
	 * @return number[]|string[]|array[]|\yii\db\ActiveRecord[][]
	 */
	public function actionZhstores()
	{
		$zhstore = ZhStore::find()->where('zhstore_status=1')->all();
		
		if(!is_null($zhstore)){
			foreach ($zhstore as $key => $row){
				unset($zhstore[$key]['zhstore_status']);
			}
		}
		
		
		$data = $zhstore;
		$response = ['code'=> 0, 'msg'=>'success','data'=>$data];
		return $response;
		
	}
	
	
}