<?php

namespace app\modules\admin\components;

use Yii;


class MyUrl 
{
	
	/**
	 * 记录在登录前的url 
	 */
	public static function SetUrlCookie()
	{
		$reffer_url = isset(Yii::$app->request->headers['Referer']) ? Yii::$app->request->headers['Referer'] :'';
		$server_name = isset(Yii::$app->request->headers['host']) ? Yii::$app->request->headers['host'] :'';

		if(stripos('prefix'.$reffer_url, $server_name) && !stripos($reffer_url, 'login')){
			$cookies = Yii::$app->response->cookies;
			$cookies->add(new \yii\web\Cookie([
					'name' => 'my_reffer_url',
					'value' => $reffer_url,
					'expire' =>time() + 3600,
			]));
		}
	}
	
	
	/**
	 * 跳转的路径
	 */
	public static function RefferUrl()
	{
		$cookies = Yii::$app->request->cookies;
		
		if (isset($cookies['my_reffer_url']) && !empty($cookies['my_reffer_url'])){
			$my_reffer_url = $cookies['my_reffer_url']->value;
			Yii::$app->getResponse()->redirect($my_reffer_url);
		}else{
			Yii::$app->getResponse()->redirect(['/admin/index/index']);
		}
	}
	
	
	
}