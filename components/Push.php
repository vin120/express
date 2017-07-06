<?php
 namespace app\components;
 
 require_once dirname(dirname(__FILE__)).'/components/jpush/autoload.php';
 
 
 
 
 
 class Push 
 {
 	
 	public static function push()
 	{
 		$appKey = Yii::$app->params['appKey'];
 		$masterSecret = Yii::$app->params['masterSecret'];
 		$client = new \JPush\Client($appKey, $masterSecret);
 		
 		
 		$push->setPlatform(['ios', 'android']);
 	}
 	
 	
 }