<?php

namespace app\modules\api\models;

use Yii;
use yii\db\ActiveRecord;

class Disclaimer extends ActiveRecord
{
	public static function tableName()
	{
		return "{{%disclaimer}}";
	}
	
	
}