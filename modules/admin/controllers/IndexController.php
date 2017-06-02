<?php

namespace  app\modules\admin\controllers;

use Yii;
use app\modules\admin\controllers\BaseController;
use app\modules\admin\models\PermissionMenu;

class IndexController extends BaseController 
{
	
	
	public function actionIndex()
	{
		//设置布局
		$this->layout = "basicLayout";
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('index');
		//检查权限
		$this->CheckAuth();
		

		$admin = Yii::$app->admin->identity;
		return $this->render('index');
	}
	
	
	public function actionAdd()
	{
		//设置布局
		$this->layout = "basicLayout";
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('add');
		//检查权限
		$this->CheckAuth();
		
		
		return $this->render('add');
	}
	
}