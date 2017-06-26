<?php

namespace  app\modules\admin\controllers;

use Yii;
use yii\data\Pagination;
use app\modules\admin\models\User;
use app\modules\admin\models\PermissionMenu;
use app\modules\admin\controllers\BaseController;
use yii\helpers\Url;
use app\modules\admin\components\MyFunction;

class UserController extends BaseController 
{
	
	//获取布局
	public $layout = "basicLayout";
	
	
	public function actionUser()
	{
		
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('user');
		//检查权限
		$this->CheckAuth();
		
		
		//主要用于判断添加，编辑和删除的权限
		$can = [];
		if(in_array(Yii::$app->params['u_user']['add'], $this->auth) || $this->auth[0] == '0'){
			$can['add'] = false;
		}  else {
			$can['add'] = false;
		}
		if(in_array(Yii::$app->params['u_user']['edit'], $this->auth) || $this->auth[0] == '0'){
			$can['edit'] = true;
		}  else {
			$can['edit'] = false;
		}
		if(in_array(Yii::$app->params['u_user']['delete'], $this->auth) || $this->auth[0] == '0'){
			$can['delete'] = false;
		}  else {
			$can['delete'] = false;
		}
		
		
		
		
		$model = User::find()->orderBy('user_id desc');
		
		$search = '';
		if(Yii::$app->request->isPost){
			$search = Yii::$app->request->post('search');
			if(!empty($search)){
				$model->andWhere("user_phone like '%$search%' or user_name like '%$search%'");
			}
		}
		
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['user'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$datas =$model->offset($pager->offset)->limit($pager->limit)->all();
		
		
		
		return $this->render('user',['can'=>$can,'user'=>$datas,'pager'=>$pager,'search'=>$search]);
	}
	
	
	public function actionUseredit()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('user');
		//检查权限
		$this->CheckAuth();
		
		
		$post = Yii::$app->request->post();
		$user = new User();
		$edit_id = isset($post['edit_id']) ? $post['edit_id'] : FALSE;
		$edit_id2 = isset($post['edit_id2']) ? $post['edit_id2'] : FALSE;
		$id = $edit_id ? $edit_id : $edit_id2;
		
		if($id) {
			$user = $user::find()->where('user_id = :user_id',[':user_id'=>$id])->one();
		}
		
		if(!$edit_id) {
			if($user->editUser($post)){
				MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/user/user'));
			}
		}
		
		
		return $this->render('useredit',['model'=>$user,'id'=>$id]);
	}
	
	
	
	public function actionRecharge()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('recharge');
		//检查权限
		$this->CheckAuth();
		
		
		//主要用于判断添加，编辑和删除的权限
		$can = [];

		if(in_array(Yii::$app->params['u_recharge']['edit'], $this->auth) || $this->auth[0] == '0'){
			$can['edit'] = true;
		}  else {
			$can['edit'] = false;
		}
	
		
		$model = User::find()->where('user_status=1')->orderBy('user_id desc');
		
		$search = '';
		if(Yii::$app->request->isPost){
			$search = Yii::$app->request->post('search');
			if(!empty($search)){
				$model->andWhere("user_phone like '%$search%' or user_name like '%$search%'");
			}
		}
		
		
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['recharge'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$datas =$model->offset($pager->offset)->limit($pager->limit)->all();
	

		return $this->render('recharge',['can'=>$can,'user'=>$datas,'pager'=>$pager,'search'=>$search]);
	}
	
	
	public function actionRechargeedit()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('recharge');
		//检查权限
		$this->CheckAuth();
		
		
		$post = Yii::$app->request->post();
		$user = new User();
		$edit_id = isset($post['edit_id']) ? $post['edit_id'] : FALSE;
		$edit_id2 = isset($post['edit_id2']) ? $post['edit_id2'] : FALSE;
		$id = $edit_id ? $edit_id : $edit_id2;
		
		if($id) {
			$user = $user::find()->where('user_id = :user_id',[':user_id'=>$id])->one();
		}
		
		if(!$edit_id) {
			if($user->recharge($post)){
				MyFunction::showMessage(Yii::t('app','充值成功'),Url::to('/admin/user/recharge'));
			}
		}
		
		
		return $this->render('rechargeedit',['model'=>$user,'id'=>$id]);
	}
	
	
}