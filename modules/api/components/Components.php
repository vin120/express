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
		
		/**
		 * 计算出快递价格
		 * @param unknown $length 「长」
		 * @param unknown $width  「宽」
		 * @param unknown $height 「高」
		 * @param unknown $weight  「重」
		 * @return number
		 */
		public static function getPrice($length,$width,$height,$weight)
		{
			$price = 0;
			$arr = [$length,$width,$height];
			$min = $max = $arr[0];
			
			//找出长宽高中的最大和最小
			foreach ($arr as $row){
				if($min > $row){
					$min = $row;
				}
				
				if($max < $row){
					$max = $row;
				}
			}
			
			
			$price1 = 0;
			$price2 = 0;
			$price3 = 0;
			$size_weight = ($length * $width * $height) / 6000;
			
			
			if($max > 50){
				
				$sum = $length + $width + $height;
				
				if($sum <= 90){
					$price1 = 10;
				} else if(91 <= $sum && $sum <= 120){
					$price1 = 11;
				} else if(121 <= $sum && $sum <= 150){
					$price1 = 13;
				} else if(151 <= $sum && $sum <= 180) {
					$price1 = 15;
				} else if(181 <= $sum && $sum <= 210) {
					$price1 = 17;
				} else {
					$price1 = 19;
				}
				
				if($size_weight > $weight) {
					$price2 = ($size_weight - 1) * 2;
				} else {
					$price2 = ($weight - 1) * 2;
				}
				
				if ($size_weight < 3) {
					if($min < $max * 0.2){
						$price3 = 1;
					} else if($min < $max * 0.1) {
						$price3 = 2;
					}
				}
				$price = $price1 + $price2  - $price3;
				
			} else {
				
				$size = $length * $width * $height;
				
				if($size <= 10 * 10 * 10){
					$price1 = 4;
				}else if ($size <= 20 * 20 *20){
					$price1 = 5;
				} else if ($size <= 30 * 30 *30) {
					$price1 = 6;
				} else if ($size <= 40 * 40 * 40) {
					$price1 = 7;
				} else if($size <= 50 * 50 *50){
					$price1 = 8;
				}
				
				if($size_weight > $weight){
					$price2 = ($size_weight - 1) * 2;
				} else {
					$price2 = ($weight - 1) * 2;
				}
				
				if($min > 20 && $max >25) {
					if($size_weight > $weight) {
						$price3 = $size_weight - $weight;
					}
				}
				
				$price = $price1 + $price2 - $price3;
				
			}
			
			return $price;
		}
		
	
	
	
}