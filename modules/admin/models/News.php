<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;


class News extends ActiveRecord
{
	
	
	public static function tableName()
	{
		return "{{%news}}";
	}
	
	
	
	public function attributeLabels()
	{
		return [
			'news_title' => Yii::t('app', '标题：'),
			'news_content' => Yii::t('app', '内容：'),
			'date' => Yii::t('app', '日期：'),
			'news_status' => Yii::t('app', '状态：'),
		];
	}
	
	
	
	
	public function rules()
	{
		return [
			[['news_title'],'required','message'=>Yii::t('app', '标题不能为空'),'on'=>['newsadd','newsedit']],
			[['news_content'],'required','message'=>Yii::t('app', '内容不能为空'),'on'=>['newsadd','newsedit']],
			[['news_status','date'],'safe'],
		];
	}
	
	
	
	public function addNews($post) {
		
		$this->scenario = "newsadd";
		
		$data['News'] = $post;
		$data['News']['date'] = date("Y-m-d H:i:s",time());
		if($this->load($data) && $this->save()){
			
			return true;
		}
		return false;
	}
	
	
	
	public function editNews($post){
		$this->scenario = "newsedit";
		
		
		if(empty($post)){
			MyFunction::showMessage(Yii::t('app','修改失败！'),Url::to('/admin/store/news'));
			Yii::$app->end();
		}
	
		$data['News'] = $post;
		
		if($this->load($data) && $this->save()){
			return true;
		}
		
		return false;
	
	
	}
	
	
	
	
	
	
	
	
	
}