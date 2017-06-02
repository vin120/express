<?php

namespace app\modules\admin\components;

use Yii;

class MyLanguage 
{
	
	
	/**
	 *  设置语言
	 */
	public static function setLanguage()
	{
		$cookies = Yii::$app->request->cookies;
		
		if(Yii::$app->request->get('language')){
			Yii::$app->language = Yii::$app->request->get('language');
			
			$cookies = Yii::$app->response->cookies;
			$cookies->add(new \yii\web\Cookie([
				'name'=>'mylanguage',
				'value'=>Yii::$app->request->get('language'),
				'expire' =>time() + 3600 * 6,
			]));
			
		} else if(isset($cookies['mylanguage'])){
			YIi::$app->language = $cookies['mylanguage']->value;
		} else {
			Yii::$app->language = Yii::$app->request->headers['accept-language'];
		}
	}
}