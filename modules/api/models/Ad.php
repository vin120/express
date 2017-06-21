<?php

namespace app\modules\api\models;

use Yii;
use yii\db\ActiveRecord;

class Ad extends ActiveRecord	
{
	public static function tableName()
	{
		return "{{%ad}}";
	}

}