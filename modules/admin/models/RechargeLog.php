<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\admin\models\AdminRole;
use app\modules\admin\components\MyFunction;


class RechargeLog extends ActiveRecord 
{

	
	public static function tableName()
	{
		return "{{%recharge_log}}";
	}
	
}