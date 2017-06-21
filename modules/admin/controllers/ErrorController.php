<?php

namespace  app\modules\admin\controllers;

use Yii;
use app\modules\admin\controllers\BaseController;
use app\modules\admin\models\Admin;
use app\modules\admin\models\PermissionMenu;


class ErrorController extends BaseController 
{
	public function actionIndex()
	{
		//设置布局
		$this->layout = "basicLayout";
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('index');
		//检查权限
		$this->CheckAuth();
		
		return $this->render('index');
	}
}