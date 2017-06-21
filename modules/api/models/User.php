<?php

namespace app\modules\api\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord	
{
	public static function tableName()
	{
		return "{{%user}}";
	}
	
}