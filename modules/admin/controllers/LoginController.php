<?php

namespace  app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\modules\admin\models\Admin;
use app\modules\admin\components\MyUrl;
use app\modules\admin\components\MyLanguage;


class LoginController extends Controller 
{
	public $layout = "loginLayout";
	
	
	public function  init()
	{
		//设置多语言
		MyLanguage::setLanguage();
	}
	
	
	/**
	 * 登录
	 * @return string
	 */
	public function actionLogin()
	{
// 		if(!empty(Yii::$app->admin->identity)){
// 			$this->redirect(['index/index']);
// 		}

		if (!Yii::$app->admin->isGuest) {
			$this->redirect(['index/index']);
		}
		
		
		//记录登录前打开的页面
		MyUrl::SetUrlCookie();
		
		$model = new Admin();
		if(Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if($model->login($post)) {
				//登录后跳转到登录前打开的页面
				MyUrl::RefferUrl();
				Yii::$app->end();
			}
		}
		return $this->render('login',['model'=>$model]);
	}
	
	
	/**
	 *  登出
	 */
	public function actionLogout()
	{
		Yii::$app->admin->logout();
		$this->redirect(['login/login']);	
	}
	
	
	
	
}