<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\admin\models\AdminRole;
use app\modules\admin\models\PermissionMenu;
use app\modules\admin\components\MyLanguage;

class BaseController extends Controller 
{	
	public $auth = 0;
	
	public function init()
	{
		//设置语言
		MyLanguage::setLanguage();
		
		//判断是否登录，如果没有，则跳回login/login
		if(empty(Yii::$app->admin->identity)) {
			$this->redirect(Url::toRoute(['/admin/login/login']));
			Yii::$app->end();
		}
		
		//获取layout中用到的数据[auth]
		Yii::$app->view->params['auth'] = AdminRole::getAuth();
		
	}
	
	
	/**
	 * 获取 action id 
	 */
	protected function getMethodId()
	{
		$action = Yii::$app->controller->action->id; 
		$controller = Yii::$app->controller->id;
		return PermissionMenu::find('menu_id')->where('method_name = :method_name',[':method_name'=>$action])->one()['menu_id'];
	}
	
	
	
	/**
	 * 检查用户权限，如果没权限，则跳到error/index 
	 */
	public function CheckAuth()
	{
		//获取菜单权限
		$this->auth = AdminRole::getAuth();
		
		if(!in_array($this->getMethodId(), $this->auth) && $this->auth[0] != '0'){
			$this->redirect(Url::to(['/admin/error/index']));
		}
	}
	
}