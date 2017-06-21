<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\admin\models\AdminRole;
use app\modules\admin\components\MyFunction;


class User extends ActiveRecord 
{
	public $recharge_money;
	
	
	public static function tableName()
	{
		return "{{%user}}";
	}
	
	
	public function attributeLabels()
	{
		return [
			'user_name' => Yii::t('app', '用户姓名：'),
			'user_phone'=>Yii::t('app','手机号码：'),
			'user_password' => Yii::t('app','密码：'),
			'user_address' => Yii::t('app','用户地址：'),
			'money' => Yii::t('app','用户余额：'),
			'reg_time' => Yii::t('app', '注册时间：'),
			'user_status'=> Yii::t('app', '状态：'),
			'sign'=>Yii::t('app', '权限码：'),
			'recharge_money'=>Yii::t('app', '充值金额：'),
		];
	}
	
	
	
	public function rules()
	{
		return [
				[['user_name'],'required','message'=>Yii::t('app', '用户名不能为空'),'on'=>['edituser']],
				[['recharge_money'],'required','message'=>Yii::t('app', '不能为空'),'on'=>['recharge']],
				[['recharge_money'],'integer','message'=>Yii::t('app', '请填写整数'),'on'=>['recharge']],
				[['user_status','sign','money'],'safe'],
		];
	}
	
	
	
	public function editUser($post)
	{
		$this->scenario = "edituser";
	
		$data['User'] = $post;
	
	
		if(empty($post)){
			MyFunction::showMessage(Yii::t('app','修改失败！'),Url::to('/admin/user/user'));
			Yii::$app->end();
		}
		
		if($this->load($data) && $this->save()){
			return true;
		}
	
		return false;
	}
	
	
	public function recharge($post)
	{
		$this->scenario = "recharge";
		
		$data['User'] = $post;
		
		
		if(empty($post)){
			MyFunction::showMessage(Yii::t('app','修改失败！'),Url::to('/admin/user/recharge'));
			Yii::$app->end();
		}
		
		if ($this->load($data) && $this->validate()) {

			$this->money += $this->recharge_money;
			if($this->save()){
				$log = new RechargeLog;
				$log->admin_id = Yii::$app->admin->identity->admin_id;
				$log->user_name = $this->user_name;
				$log->user_phone = $this->user_phone;
				$log->money = $post['recharge_money'];
				$log->recharge_time = date("Y-m-d H:i:s",time());
				$log->save();
				//写入流水
				return true;
			}
		}
		
		return false;
	}
	
	
}