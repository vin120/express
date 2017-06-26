<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\admin\models\AdminRole;
use app\modules\admin\components\MyFunction;
use yii\web\UploadedFile;

class Store extends ActiveRecord 
{
	
	public static function tableName()
	{
		return "{{%store}}";
	}
	
	
	public function attributeLabels()
	{
		return [
			'store_name' => Yii::t('app', '店名：'),
			'store_phone' => Yii::t('app', '电话：'),
			'store_work_time' => Yii::t('app', '营业时间：'),
			'store_address' => Yii::t('app', '地址：'),
			'store_logo' => Yii::t('app', 'logo：'),
			'store_map' => Yii::t('app', '地图：'),
			'store_status' => Yii::t('app', '状态：'),
			
		];
	}
	
	
	
	public function rules()
	{
		return [
			[['store_name'],'required','message'=>Yii::t('app', '店名不能为空'),'on'=>['storeadd','storeedit']],
			[['store_phone'],'required','message'=>Yii::t('app', '电话不能为空'),'on'=>['storeadd','storeedit']],
			[['store_work_time'],'required','message'=>Yii::t('app', '工作时间不能为空'),'on'=>['storeadd','storeedit']],
			[['store_address'],'required','message'=>Yii::t('app', '地址不能为空'),'on'=>['storeadd','storeedit']],
			[['store_logo'],'required','message'=>Yii::t('app', 'logo不能为空'),'on'=>['storeadd','storeedit']],
			[['store_map'],'required','message'=>Yii::t('app', '地图不能为空'),'on'=>['storeadd','storeedit']],
			[['store_status'],'safe'],
		];
	}
	
	
	
	
	public function addStore($post)
	{
		$this->scenario = "storeadd";
		
		$data['Store'] = $post;
		if($this->load($data) && $this->save()){
			
			return true;
		}
		return false;
	}
	
	
	public function editStore($post){
		$this->scenario = "storeedit";
		
		
		if(empty($post)){
			MyFunction::showMessage(Yii::t('app','修改失败！'),Url::to('/admin/store/store'));
			Yii::$app->end();
		}
		
		
		if($post['store_logo'] == ""){
			$post['store_logo'] = $this->store_logo;
		}
		
		if($post['store_map'] == ""){
			$post['store_map'] = $this->store_map;
		}
		
		
		$data['Store'] = $post;
		
		
		if($this->load($data) && $this->save()){
			return true;
		}
		
		return false;
		
		
	}
	
}