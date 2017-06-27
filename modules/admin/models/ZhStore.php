<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\admin\models\AdminRole;
use app\modules\admin\components\MyFunction;
use yii\web\UploadedFile;

class ZhStore extends ActiveRecord
{
	
	public static function tableName()
	{
		return "{{%zhstore}}";
	}
	
	
	public function attributeLabels()
	{
		return [
			'zhstore_name' => Yii::t('app', '店名：'),
			'zhstore_phone' => Yii::t('app', '电话：'),
			'zhstore_area' => Yii::t('app', '所在区域：'),
			'zhstore_street' => Yii::t('app', '街道：'),
			'zhstore_address' => Yii::t('app', '详细地址：'),
			'zhstore_status' => Yii::t('app', '状态：'),
		];
	}
	
	
	
	
	public function rules()
	{
		return [
			[['zhstore_name'],'required','message'=>Yii::t('app', '店名不能为空'),'on'=>['zhstoreadd','zhstoreedit']],
			[['zhstore_phone'],'required','message'=>Yii::t('app', '电话不能为空'),'on'=>['zhstoreadd','zhstoreedit']],
			[['zhstore_area'],'required','message'=>Yii::t('app', '所在区域不能为空'),'on'=>['zhstoreadd','zhstoreedit']],
			[['zhstore_street'],'required','message'=>Yii::t('app', '街道不能为空'),'on'=>['zhstoreadd','zhstoreedit']],
			[['zhstore_address'],'required','message'=>Yii::t('app', '地址不能为空'),'on'=>['zhstoreadd','zhstoreedit']],
			[['zhstore_logo'],'required','message'=>Yii::t('app', 'logo不能为空'),'on'=>['zhstoreadd','zhstoreedit']],
			[['zhstore_status'],'safe'],
		];
	}
	
	
	
	
	public function addZhStore($post)
	{
		$this->scenario = "zhstoreadd";
		
		$data['ZhStore'] = $post;
		if($this->load($data) && $this->save()){
			
			return true;
		}
		return false;
		
	}
	
	
	
	public function editZhStore($post)
	{
		$this->scenario = "zhstoreedit";
		
		
		if(empty($post)){
			MyFunction::showMessage(Yii::t('app','修改失败！'),Url::to('/admin/store/zhstore'));
			Yii::$app->end();
		}
		
		
		if($post['zhstore_logo'] == ""){
			$post['zhstore_logo'] = $this->zhstore_logo;
		}
		

		
		$data['ZhStore'] = $post;
		
		
		if($this->load($data) && $this->save()){
			return true;
		}
		
		return false;
	}
	
}