<?php
namespace  app\modules\api\components;
use Yii;
use yii\web\Controller;




class Components extends Controller{
	
	
	/**
	 * 澳門手机号码格式验证
	 * @param unknown $data
	 * @return boolean
	 */
	public static function isMacauPhone($data) {
		$search ='/^6\d{7}$/';
		if (preg_match($search, $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	
		/** 生成不重复的随机数
		 * @param number $start 需要生成的数字开始范围
		 * @param number $end 结束范围
		 * @param number $length 需要生成的随机数个数
		 */
		public static function get_rand_number($start=1,$end=10,$length=4){
			$connt=0;
			$temp=array();
			while($connt<$length){
				$temp[]=rand($start,$end);
				$data=array_unique($temp);
				$connt=count($data);
			}
			sort($data);
			return $data;
		}
		
		
		
		/**
		 * 请求发送
		 * @return string 返回状态报告
		 */
		private function _request($url){
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_HEADER,0);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_URL,$url);
			$result=curl_exec($ch);
			curl_close($ch);
			return $result;
		}
	
		
		/**
		 * 国际短信发送
		 * @param unknown $phone [手機號碼]
		 * @param unknown $content 短信内容
		 * @param number $isreport 是否需要状态报告
		 */
		public  static function sendInternational($phone,$content,$isreport=0){
			$text = '【憶條街】您的驗證碼是'.$content.'，驗證碼 15 分針內有效。請勿將驗證碼轉發他人！';
			$requestData=array(
					'un'=>Yii::$app->params['uns'],
					'pw'=>Yii::$app->params['pws'],
					'sm'=>$text,
					'da'=>$phone,
					'rd'=>$isreport,
					'rf'=>2,
					'tf'=>3,
			);
			$param='un='.Yii::$app->params['uns'].'&pw='.Yii::$app->params['pws'].'&sm='.urlencode($text).'&da='.$phone.'&rd='.$isreport.'&rf=2&tf=3';
			$url='http://222.73.117.140:8044/mt?'.$param;//单发接口
			//$url='http://222.73.117.140:8044/batchmt'.'?'.$param;//群发接口
			return self::_request($url);
		}
	
	
	
}