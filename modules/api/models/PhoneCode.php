<?php

namespace app\modules\api\models;

use Yii;
use yii\db\ActiveRecord;
use app\modules\api\components\Components;

class PhoneCode extends ActiveRecord	
{
	public static function tableName()
	{
		return "{{%phone_code}}";
	}
	
	
	
	public static function SendMsn($user_phone)
	{
		$phone_code = self::find()->where('phone = :phone',[':phone'=>$user_phone])->one();
	
	
		if(!is_null($phone_code)){
			if(time() < $phone_code->time - 840 ){
				//請一分鐘後再獲取
				return false;
			}
		}
					
		$code = Components::get_rand_number('100000','999999',1)[0];
			
		$phones = "853".$user_phone;
		$ch = Components::sendInternational($phones, $code);
	
		//保存驗證碼到數據庫中
		self::saveCode($user_phone,$code);
		
		return true;
		
	}
	
	
	
	
	/**保存驗證碼到數據庫中
	 * @param unknown $user_phone 手機號碼
	 * @param unknown $code 驗證碼
	 */
	public static function saveCode($user_phone,$code)
	{
		//入庫
		$time = time()+900;
		$phone_code = self::find()->where('phone = :phone',[':phone'=>$user_phone])->one();
	
		
		//如果數據沒有數據，就插入
		if(!$phone_code) {
			$phone_code  = new PhoneCode();
			$phone_code->phone = $user_phone;
		}
			
		//否則就修改
		$phone_code->code_num = $code;
		$phone_code->time = $time;
		$phone_code->save();
		
		return true;
	}
	
	
	
	
	
	
	//TODO
	public function validateCode()
	{
		if(!$this->hasErrors()){
			$user_phone = Yii::$app->session->get('regist_phone');
	
			$data = self::find()->where('c_phone = :c_phone',[':c_phone' =>$user_phone])->one();
			if(is_null($data)){
				$this->addError("c_code","驗證碼錯誤");
			}
				
			if($data->c_code != $this->c_code){
				$this->addError("c_code","驗證碼錯誤");
			}
				
			if($data->c_time < time()){
				$this->addError("c_code","驗證碼已過期,請重新獲取");
			}
		}
	}
	
	

}