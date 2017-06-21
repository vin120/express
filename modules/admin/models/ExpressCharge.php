<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\admin\models\AdminRole;
use app\modules\admin\components\MyFunction;
use yii\web\UploadedFile;

class ExpressCharge extends ActiveRecord
{
	
	public static function tableName()
	{
		return "{{%express_charge}}";
	}
	
	
	public function rules()
	{
		return [
			[['img_url'],'required','message'=>Yii::t('app', 'img_url不能为空'),'on'=>['express']],
		];
	}
	
	
	public function ChangeUrl($post)
	{
		$this->scenario = "express";
		
		if($post['img_url'] == ""){
			$post['img_url'] = $this->img_url;
		}
		
		
		$data['ExpressCharge'] = $post;
		
		
		if($this->load($data) && $this->save()){
			return true;
		}
		
		return false;
	}
	
	
	
	
}