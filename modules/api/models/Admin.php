<?php

namespace app\modules\api\models;

use Yii;
use yii\db\ActiveRecord;

class Admin extends ActiveRecord	
{
	public static function tableName()
	{
		return "{{%admin}}";
	}

}