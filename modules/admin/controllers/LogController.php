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

	/**
	 * 充值流水
	 * @return string
	 */	
	public function actionRechargelog()
	{
		
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('rechargelog');
		//检查权限
		$this->CheckAuth();
		
		$admin = Admin::find()->where('admin_type = 0')->all();
		
		//充值管理员
		$admin_id = Yii::$app->admin->identity->admin_id;
		
		//非充值管理员
		if(Yii::$app->admin->identity->admin_type != 0){
			$admin_id = 0;
			if(Yii::$app->request->isGet){
				$admin_id = Yii::$app->request->get('admin_id');
			}
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
	
	
	/**
	 * 珠海扫件流水
	 * @return string
	 */
	public function actionZhlog()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('zhlog');
		//检查权限
		$this->CheckAuth();
		
		
		$admin = Admin::find()->where('admin_type = 2')->all();
		
		
		//扫件管理员
		$admin_id = Yii::$app->admin->identity->admin_id;
		
		
		if(Yii::$app->admin->identity->admin_type != 2){
			//非扫件管理员
			$admin_id = 0;
			if(Yii::$app->request->isGet){
				$admin_id = Yii::$app->request->get('admin_id');
			}
		}
		
		//查找状态为用户已领件的快递
		$model = Goods::find()->where('zh_admin_name is not null')->orderBy('goods_id desc')->asArray();
		
		//按条件查询
		$admin_name = Admin::find()->where('admin_id=:admin_id',[':admin_id'=>$admin_id])->one()['admin_name'];
		if($admin_id != 0){
			$model->andWhere('zh_admin_name = :zh_admin_name',[':zh_admin_name'=>$admin_name]);
		}
		
		
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['deliverylog'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$data = $model->offset($pager->offset)->limit($pager->limit)->all();
		
		
		$admin_all = Admin::find()->all();
		
		foreach ($data as $key => $row){
			foreach ($admin_all as $r){
				if($row['zh_admin_name'] == $r['admin_name']){
					$data[$key]['admin_name'] = $r['admin_name'];
				}
			}
		}
		
	
		
		return $this->render('zhlog',['pager'=>$pager,'admin'=>$admin,'admin_id'=>$admin_id,'zhlog'=>$data]);
	}
	
	
	/**
	 * 澳门扫件流水
	 * @return string
	 */
	public function actionMaclog()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('maclog');
		//检查权限
		$this->CheckAuth();
		
		$admin = Admin::find()->where('admin_type = 3')->all();
		
		
		//扫件管理员
		$admin_id = Yii::$app->admin->identity->admin_id;
		
		
		if(Yii::$app->admin->identity->admin_type != 3){
			//非扫件管理员
			$admin_id = 0;
			if(Yii::$app->request->isGet){
				$admin_id = Yii::$app->request->get('admin_id');
			}
		}
		
		//查找状态为用户已领件的快递
		$model = Goods::find()->where('mo_admin_name is not null')->orderBy('goods_id desc')->asArray();
		
		//按条件查询
		$admin_name = Admin::find()->where('admin_id=:admin_id',[':admin_id'=>$admin_id])->one()['admin_name'];
		if($admin_id != 0){
			$model->andWhere('mo_admin_name = :mo_admin_name',[':mo_admin_name'=>$admin_name]);
		}
		
		
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['deliverylog'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$data = $model->offset($pager->offset)->limit($pager->limit)->all();
		
		
		$admin_all = Admin::find()->all();
		
		foreach ($data as $key => $row){
			foreach ($admin_all as $r){
				if($row['mo_admin_name'] == $r['admin_name']){
					$data[$key]['admin_name'] = $r['admin_name'];
				}
			}
		}
		
		
		
		return $this->render('maclog',['pager'=>$pager,'admin'=>$admin,'admin_id'=>$admin_id,'zhlog'=>$data]);
	}
	
	
	/**
	 * 派件流水
	 * @return string
	 */
	public function actionDeliverylog()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('deliverylog');
		//检查权限
		$this->CheckAuth();
		
		
		$admin = Admin::find()->where('admin_type = 1')->all();
		
		
		//充派件理员
		$admin_id = Yii::$app->admin->identity->admin_id;
		
		
		if(Yii::$app->admin->identity->admin_type != 1){
			//非派件管理员
			$admin_id = 0;
			if(Yii::$app->request->isGet){
				$admin_id = Yii::$app->request->get('admin_id');
			}
		}
		
		//查找状态为用户已领件的快递
		$model = Goods::find()->where('mo_admin_name2 is not null')->orderBy('goods_id desc')->asArray();
		
		//按条件查询
		$admin_name = Admin::find()->where('admin_id=:admin_id',[':admin_id'=>$admin_id])->one()['admin_name'];
		if($admin_id != 0){
			$model->andWhere('mo_admin_name2 = :mo_admin_name2',[':mo_admin_name2'=>$admin_name]);
		}
		
		
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['deliverylog'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$data = $model->offset($pager->offset)->limit($pager->limit)->all();
		
		
		$admin_all = Admin::find()->all();
		
		foreach ($data as $key => $row){
			foreach ($admin_all as $r){
				if($row['mo_admin_name2'] == $r['admin_name']){
					$data[$key]['admin_name'] = $r['admin_name'];
				}
			}
		}
		
		
		
		return $this->render('deliverylog',['pager'=>$pager,'admin'=>$admin,'admin_id'=>$admin_id,'deliverylog'=>$data]);
	}
	
	
}