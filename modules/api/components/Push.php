<?php
namespace  app\modules\api\components;


use Yii;
require_once dirname(dirname(__FILE__)).'/components/jpush/autoload.php';
 
 

 class Push 
 {
 	
 	public static function push($alias)
 	{
 		$appKey = Yii::$app->params['appKey'];
 		$masterSecret = Yii::$app->params['masterSecret'];
 		$client = new \JPush\Client($appKey, $masterSecret);
 		
 		try {
 			$response = $client->push()
 			->setPlatform(array('ios', 'android'))
 			->addAlias($alias)
  			//->addTag(array('tag1', 'tag2'))
 			// ->addRegistrationId($registration_id)
 			->setNotificationAlert('到貨通知')
 			->iosNotification('到貨通知', array(
 					'sound' => 'sound.caf',
 					// 'badge' => '+1',
 					// 'content-available' => true,
 					// 'mutable-content' => true,
 					'category' => 'jiguang',
 					'extras' => array(
 							'key' => 'value',
 							'jiguang'
 					),
 			))
 			->androidNotification('您的貨物已經到達澳門，請上門取件', array(
 					'title' => '到貨通知',
 					// 'build_id' => 2,
 					'extras' => array(
 							'key' => 'value',
 							'jiguang'
 					),
 			))
 			->message('message content', array(
 					'title' => '您的貨物已經到達澳門，請上門取件',
 					// 'content_type' => 'text',
 					'extras' => array(
 							'key' => 'value',
 							'jiguang'
 					),
 			))
 			->options(array(
 					// sendno: 表示推送序号，纯粹用来作为 API 调用标识，
 					// API 返回时被原样返回，以方便 API 调用方匹配请求与返回
 					// 这里设置为 100 仅作为示例
 					
 					// 'sendno' => 100,
 					
 					// time_to_live: 表示离线消息保留时长(秒)，
 					// 推送当前用户不在线时，为该用户保留多长时间的离线消息，以便其上线时再次推送。
 					// 默认 86400 （1 天），最长 10 天。设置为 0 表示不保留离线消息，只有推送当前在线的用户可以收到
 					// 这里设置为 1 仅作为示例
 					
 					// 'time_to_live' => 1,
 					
 					// apns_production: 表示APNs是否生产环境，
 					// True 表示推送生产环境，False 表示要推送开发环境；如果不指定则默认为推送生产环境
 					
 					'apns_production' => true,
 					
 					// big_push_duration: 表示定速推送时长(分钟)，又名缓慢推送，把原本尽可能快的推送速度，降低下来，
 					// 给定的 n 分钟内，均匀地向这次推送的目标用户推送。最大值为1400.未设置则不是定速推送
 					// 这里设置为 1 仅作为示例
 					
 					// 'big_push_duration' => 1
 			))
 			->send();
//  			print_r($response);
 			
 		} catch (\JPush\Exceptions\APIConnectionException $e) {
 			// try something here
//  			print $e;
 		} catch (\JPush\Exceptions\APIRequestException $e) {
 			// try something here
//  			print $e;
 		}
 		
 		
 	}
 	
 	
 }