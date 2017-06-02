<?php

namespace app\modules\api\models;

use Yii;
use yii\db\ActiveRecord;

class Worker extends ActiveRecord	
{
	public static function tableName()
	{
		return "{{%worker}}";
	}

}