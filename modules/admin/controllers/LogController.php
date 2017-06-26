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
use app\modules\admin\models\RechargeLog;
use app\modules\admin\models\Goods;


class LogController extends BaseController
{
	//获取布局
	public $layout = "basicLayout";

	
	public function actionRechargelog()
	{
		
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('rechargelog');
		//检查权限
		$this->CheckAuth();
		
		
		$admin = Admin::find()->where('admin_type = 0')->all();
		
		
		if(Yii::$app->admin->identity->admin_type != 0){
			//非充值管理员
			$admin_id = 0;
			if(Yii::$app->request->isGet){
				$admin_id = Yii::$app->request->get('admin_id');
			}
		} else {
			//充值管理员
			$admin_id = Yii::$app->admin->identity->admin_id;
		}
		
		
		
		$model = RechargeLog::find()->orderBy('recharge_id desc')->asArray();
		
		if($admin_id != 0){
			$model->andWhere('admin_id = :admin_id',[':admin_id'=>$admin_id]);
		}
		
		
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['rechargelog'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$data = $model->offset($pager->offset)->limit($pager->limit)->all();
		
		
		$admin_all = Admin::find()->all();
		
		foreach ($data as $key => $row){
			foreach ($admin_all as $r){
				if($row['admin_id'] == $r['admin_id']){
					$data[$key]['admin_name'] = $r['admin_name'];
				}
			}
		}
		
		
		return $this->render('rechargelog',['pager'=>$pager,'admin'=>$admin,'admin_id'=>$admin_id,'rechargelog'=>$data]);
	}
	
	
	//TODO
	public function actionZhlog()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('zhlog');
		//检查权限
		$this->CheckAuth();
		
		
		$admin = Admin::find()->where('admin_type = 2')->all();
		
		
		if(Yii::$app->admin->identity->admin_type != 0){
			//非充值管理员
			$admin_id = 0;
			if(Yii::$app->request->isGet){
				$admin_id = Yii::$app->request->get('admin_id');
			}
		} else {
			//充值管理员
			$admin_id = Yii::$app->admin->identity->admin_id;
		}
		
		
		$admin_name = Admin::find()->where('admin_id=:admin_id',[':admin_id'=>$admin_id])->one();
		
		$model = Goods::find()->orderBy('goods_id desc')->asArray();
		
		if($admin_id != 0){
			$model->andWhere('zh_admin_name = :zh_admin_name',[':zh_admin_name'=>$admin_name]);
		}
		
		
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['rechargelog'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$data = $model->offset($pager->offset)->limit($pager->limit)->all();
		
		
		$admin_all = Admin::find()->all();
		
		foreach ($data as $key => $row){
			foreach ($admin_all as $r){
				if($row['admin_id'] == $r['admin_id']){
					$data[$key]['admin_name'] = $r['admin_name'];
				}
			}
		}
		
	
		
		return $this->render('zhlog',['pager'=>$pager,'admin_name'=>$admin_name]);
	}
	
	
	
	public function actionMaclog()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('maclog');
		//检查权限
		$this->CheckAuth();
		
		
		return $this->render('maclog');
	}
	
	
	public function actionDeliverylog()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('deliverylog');
		//检查权限
		$this->CheckAuth();
		
		return $this->render('deliverylog');
	}
	
	
}