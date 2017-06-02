<?php

namespace app\modules\api\models;

use Yii;
use yii\db\ActiveRecord;

class Goods extends ActiveRecord	
{
	public static function tableName()
	{
		return "{{%goods}}";
	}
	
}