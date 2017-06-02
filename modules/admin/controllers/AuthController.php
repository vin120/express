<?php

namespace  app\modules\admin\controllers;

use Yii;
use app\modules\admin\controllers\BaseController;
use app\modules\admin\models\PermissionMenu;
use app\modules\admin\models\Admin;
use app\modules\admin\components\MyFunction;
use yii\helpers\Url;
use app\modules\admin\models\AdminRole;
use yii\data\Pagination; 
use app\modules\admin\models\PermissionClick;


class AuthController extends BaseController 
{
	//获取布局
	public $layout = "basicLayout";
	
	
	
	/**
	 * 管理员列表
	 * @return string
	 */
	public function actionAdmin()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('admin');
		//检查权限
		$this->CheckAuth();
		
		
		//主要用于判断添加，编辑和删除的权限
		$can = [];
		if(in_array('115', $this->auth) || $this->auth[0] == '0'){
			$can['add'] = true;
		}  else {
			$can['add'] = false;
		}
		if(in_array('116', $this->auth) || $this->auth[0] == '0'){
			$can['edit'] = true;
		}  else {
			$can['edit'] = false;
		}
		if(in_array('117', $this->auth) || $this->auth[0] == '0'){
			$can['delete'] = true;
		}  else {
			$can['delete'] = false;
		}
		
		
		$model = Admin::find()->joinWith('adminrole')->where('admin_id > 1')->orderBy('admin_id desc');
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['admin'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$datas =$model->offset($pager->offset)->limit($pager->limit)->all();
		
		
		return $this->render('admin',['can'=>$can,'admin'=>$datas,'pager'=>$pager]);	
	}
	
	
	
	
	/**
	 * 添加管理员
	 * @return string
	 */
	public function actionAdminadd()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('admin');
		//检查权限
		$this->CheckAuth();
		
		
		
		$model = new Admin();
		
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			if($model->addAdmin($post)){
				MyFunction::showMessage(Yii::t('app','添加成功'),Url::to('/admin/auth/adminadd'));
			}
		}
		
		
		//获取权限下拉列表
		$role = new AdminRole();
		$list = $role->getOptions();
		unset($list[0]);
		
		
		
		$role = AdminRole::find()->where('role_id > 1 and role_status = 1')->orderBy('role_id')->all();
		$model->admin_status = 1;
		
		return $this->render('adminadd',['model'=>$model,'role'=>$list]);
		
	}
	
	
	
	/**
	 * 编辑管理员
	 * @return string
	 */
	public function actionAdminedit()
	{
		
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('admin');
		//检查权限
		$this->CheckAuth();
			
		
		//获取权限下拉列表
		$role = new AdminRole();
		$list = $role->getOptions();
		unset($list[0]);
		
		
		$post = Yii::$app->request->post();
		$admin = new Admin();
		$edit_id = isset($post['edit_id']) ? $post['edit_id'] : FALSE;
		$edit_id2 = isset($post['edit_id2']) ? $post['edit_id2'] : FALSE;
		$id = $edit_id ? $edit_id : $edit_id2;
		
		if($id) {
			$admin = $admin::find()->where('admin_id = :admin_id',[':admin_id'=>$id])->one();
		}
		
		if(!$edit_id) {
			if($admin->editAdmin($post)){
				MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/auth/admin'));
			}
		}
		
		
		return $this->render('adminedit',['model'=>$admin,'role'=>$list,'id'=>$id]);
	}
	
	
	/**
	 *  删除管理员
	 */
	public function actionAdmindelete()
	{
		//检查权限
		$this->CheckAuth();
		
		if(Yii::$app->request->isGet){
			$get = Yii::$app->request->get();
				
			if(Admin::findOne($get['id'])->delete()) {
				MyFunction::showMessage(Yii::t('app','删除成功'),Url::to('/admin/auth/admin'));
			} else{
				MyFunction::showMessage(Yii::t('app','删除失败'),Url::to('/admin/auth/admin'));
			}
		}
	}
	
	
	
	
	
	
	/**
	 * 权限列表
	 * @return string
	 */
	public function actionRole()
	{
		
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('role');
		//检查权限
		$this->CheckAuth();
		
		
		//主要用于判断添加，编辑和删除的权限
		$can = [];
		if(in_array('119', $this->auth) || $this->auth[0] == '0'){
			$can['add'] = true;
		}  else {
			$can['add'] = false;
		}
		if(in_array('120', $this->auth) || $this->auth[0] == '0'){
			$can['edit'] = true;
		}  else {
			$can['edit'] = false;
		}
		if(in_array('121', $this->auth) || $this->auth[0] == '0'){
			$can['delete'] = true;
		}  else {
			$can['delete'] = false;
		}
		
		
		$model = AdminRole::find()->where('role_id > 1')->orderBy('role_id desc');
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['role'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$data = $model->offset($pager->offset)->limit($pager->limit)->all();

		
		return $this->render('role',['can'=>$can,'role'=>$data,'pager'=>$pager]);
	}
	
	
	
	/**
	 * ajax获取菜单权限树状结构 
	 */
	public function actionMenupermission()
	{
		$admin_id = Yii::$app->admin->identity->admin_id;
		$post = Yii::$app->request->post();
		return PermissionMenu::getMenuTree($admin_id,$post);
		
	}
	
	
	
	/**
	 * 添加权限分组
	 * @return string
	 */
	public function actionRoleadd()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('role');
		//检查权限
		$this->CheckAuth();
	
	
		$model = new AdminRole();
		
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			
			
			if($model->addRole($post)){
				MyFunction::showMessage(Yii::t('app','添加成功'),Url::to('/admin/auth/roleadd'));
			}
		}
		
		$model->role_status = '1';
		return $this->render('roleadd',['model'=>$model]);
	}
	
	
	
	
	/**
	 * 编辑权限分组
	 * @return string
	 */
	public function actionRoleedit()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('role');
		//检查权限
		$this->CheckAuth();
			
		
		$post = Yii::$app->request->post();
		$role = new AdminRole();
		$edit_id = isset($post['edit_id']) ? $post['edit_id'] : FALSE;
		$edit_id2 = isset($post['edit_id2']) ? $post['edit_id2'] : FALSE;
		$id = $edit_id ? $edit_id : $edit_id2;
		
		if($id) { 
			$role = $role::find()->where('role_id = :role_id',[':role_id'=>$id])->one();
		}
		
		if(!$edit_id) {
			if($role->editRole($role,$post)){
				MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/auth/role'));
			}
		}
			
		return $this->render('roleedit',['role'=>$role,'id'=>$id]);		
	}
	
	
	
	/**
	 * 删除权限分组 
	 */
	public function actionRoledelete()
	{
		//检查权限
		$this->CheckAuth();
		
		if(Yii::$app->request->isGet){
			$get = Yii::$app->request->get();
			
			if(AdminRole::findOne($get['id'])->delete()) {
				MyFunction::showMessage(Yii::t('app','删除成功'),Url::to('/admin/auth/role'));
			} else{
				MyFunction::showMessage(Yii::t('app','删除失败'),Url::to('/admin/auth/role'));
			}
		}
	}
	
	
	
	/**
	 * 修改密码
	 * @return string
	 */
	public function actionPasswordedit()
	{
	
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('admin');
		//检查权限
		$this->CheckAuth();
		
		
		
		$model = Admin::find()->where('admin_name = :admin_name',[':admin_name'=>Yii::$app->admin->identity->admin_name])->one();
		
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			if($model->changePassword($post)){
				MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/auth/passwordedit'));
			} 
		}
		
		$model->admin_password = '';
		$model->new_password = '';
		$model->re_password = '';
		
		return $this->render('passwordedit',['model'=>$model]);
		
	}
	
	
	
	/**
	 * 重置密码 
	 */
	public function actionResetpassword()
	{
		$id = Yii::$app->request->get('id');
		$admin = Admin::findOne($id);
		
		$admin->admin_password = md5('123456');
		if($admin->save()){
			MyFunction::showMessage(Yii::t('app','重设密码成功,密码为123456'),Url::to('/admin/auth/admin'));
		}else {
			MyFunction::showMessage(Yii::t('app','重设失败'),Url::to('/admin/auth/admin'));
		}
	}
	
	
	

	/**
	 * ajax 查找 权限管理分组里面有没有管理员，如果有就不能 「删除」
	 */
	public function actionCheckadmin()
	{
		$admin = Admin::find()->where("role_id = :role_id",[':role_id'=> Yii::$app->request->post('id')])->count();
		echo $admin;
	}
	
	
	/**
	 * ajax 查找 管理员是不是自己，如果是就不能 「删除」
	 */
	public function actionCheckismyself()
	{
		if(Yii::$app->request->post('id') == Yii::$app->admin->identity->admin_id){
			echo "1";
		}
	}
	
	
	
	
}