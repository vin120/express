<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\admin\models\AdminRole;
use app\modules\admin\components\MyFunction;


class Disclaimer extends ActiveRecord 
{

	
	public static function tableName()
	{
		return "{{%disclaimer}}";
	}
	
	
	public function attributeLabels()
	{
		return [
			'disclaimer_content' => Yii::t('app', '免责声明内容：'),
		];
	}
	
	
	public function rules()
	{
		return [
			[['disclaimer_content'],'required','message'=>Yii::t('app', '免责声明不能空'),'on'=>['disclaimer']],
		];
	}
	
	
	
	public function ChangeDisclaimer($post)
	{
		$this->scenario = "disclaimer";
		
		$data['Disclaimer'] = $post;
		
		if($this->load($data) && $this->save()){
			return true;
		}
		
		return false;
		
		
	}
	
	
}