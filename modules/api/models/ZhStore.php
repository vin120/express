<?php

namespace app\modules\api\models;

use Yii;
use yii\db\ActiveRecord;
use app\modules\api\components\Components;

class ZhStore extends ActiveRecord
{
	public static function tableName()
	{
		return "{{%zhstore}}";
	}
	
	
	
	
}