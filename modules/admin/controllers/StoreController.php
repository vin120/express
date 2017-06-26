<?php

namespace  app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\PermissionMenu;
use app\modules\admin\controllers\BaseController;
use app\modules\admin\models\Disclaimer;
use app\modules\admin\components\MyFunction;
use yii\helpers\Url;
use app\modules\admin\models\Store;
use yii\data\Pagination; 
use app\modules\admin\models\ExpressCharge;


class StoreController extends BaseController 
{
	//获取布局
	public $layout = "basicLayout";
	
	/**
	 * 门店列表
	 * @return string
	 */
	public function actionStore()
	{
		
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('store');
		//检查权限
		$this->CheckAuth();
		
		
		//主要用于判断添加，编辑和删除的权限
		$can = [];
		if(in_array(Yii::$app->params['s_store']['add'], $this->auth) || $this->auth[0] == '0'){
			$can['add'] = true;
		}  else {
			$can['add'] = false;
		}
		if(in_array(Yii::$app->params['s_store']['edit'], $this->auth) || $this->auth[0] == '0'){
			$can['edit'] = true;
		}  else {
			$can['edit'] = false;
		}
		if(in_array(Yii::$app->params['s_store']['delete'], $this->auth) || $this->auth[0] == '0'){
			$can['delete'] = false;
		}  else {
			$can['delete'] = false;
		}
		

		$model = Store::find()->orderBy('store_id desc');
		$count = $model->count();
		$pageSize = Yii::$app->params['pageSize']['store'];
		$pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
		$datas =$model->offset($pager->offset)->limit($pager->limit)->all();
		
		
		$store = Store::find()->all();
		
		return $this->render('store',['store'=>$datas,'can'=>$can,'pager'=>$pager]);
	}
	
	
	/**
	 *  添加门店
	 * @return string
	 */
	public function actionStoreadd()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('store');
		//检查权限
		$this->CheckAuth();
		
		
		
		$model = new Store();
		$model->store_status=1;
		
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			
			
			$allow_size = 3;
			
			if($_FILES['store_logo']['error']!=4){
				$result=MyFunction::upload_file('store_logo',"./".Yii::$app->params['img_url_prefix'].date('Ymd',time()), 'image', $allow_size);
				$store_logo=date('Ymd',time()).'/'.$result['filename'];
			}
			
			
			if($_FILES['store_map']['error']!=4){
				$result=MyFunction::upload_file('store_map',"./".Yii::$app->params['img_url_prefix'].date('Ymd',time()), 'image', $allow_size);
				$store_map=date('Ymd',time()).'/'.$result['filename'];
			}
			
			
			
			
			$post['store_logo'] = isset($store_logo) ? $store_logo : "";
			$post['store_map'] = isset($store_map) ? $store_map : "";
			
			if($model->addStore($post)){
				MyFunction::showMessage(Yii::t('app','添加成功'),Url::to('/admin/store/store'));
			}
		}
		
		
		return $this->render('storeadd',['model'=>$model]);
	}
	
	
	/**
	 * 编辑门店
	 * @return string
	 */
	public function actionStoreedit()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('store');
		//检查权限
		$this->CheckAuth();
		
		
		$post = Yii::$app->request->post();
		$store= new Store();
		$edit_id = isset($post['edit_id']) ? $post['edit_id'] : FALSE;
		$edit_id2 = isset($post['edit_id2']) ? $post['edit_id2'] : FALSE;
		$id = $edit_id ? $edit_id : $edit_id2;
		
		if($id) {
			$store = $store::find()->where('store_id = :store_id',[':store_id'=>$id])->one();
		}
		
		if(!$edit_id) {
			
			$allow_size = 3;
			
			if($_FILES['store_logo']['error']!=4){
				$result=MyFunction::upload_file('store_logo',"./".Yii::$app->params['img_url_prefix'].date('Ymd',time()), 'image', $allow_size);
				$store_logo=date('Ymd',time()).'/'.$result['filename'];
			}
			
			
			if($_FILES['store_map']['error']!=4){
				$result=MyFunction::upload_file('store_map',"./".Yii::$app->params['img_url_prefix'].date('Ymd',time()), 'image', $allow_size);
				$store_map=date('Ymd',time()).'/'.$result['filename'];
			}
			
			
			
			$post['store_logo'] = isset($store_logo) ? $store_logo : "";
			$post['store_map'] = isset($store_map) ? $store_map : "";
			
			if($store->editStore($post)){
				MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/store/store'));
			}
		}
		
		
		
		return $this->render('storeedit',['model'=>$store,'id'=>$id]);
	}
	
	
	/**
	 * 免责声明
	 * @return string
	 */
	public function actionDisclaimer()
	{
		
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('disclaimer');
		//检查权限
		$this->CheckAuth();
		
		
		$disclaimer = Disclaimer::find()->where('disclaimer_id=1')->one();
		
		
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			if($disclaimer->ChangeDisclaimer($post)){
				MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/store/disclaimer'));
			}
		}
		
		
		return $this->render('disclaimer',['model'=>$disclaimer]);
	}
	
	
	/**
	 * 收费图
	 * @return string
	 */
	public function actionExpresscharge()
	{
		//获取菜单
		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('expresscharge');
		//检查权限
		$this->CheckAuth();
		
		$charge = ExpressCharge::find()->where('charge_id=1')->one();
		
		
		if(Yii::$app->request->isPost){
			$allow_size = 3;
			if($_FILES['img_url']['error']!=4){
				$result=MyFunction::upload_file('img_url',"./".Yii::$app->params['img_url_prefix'].date('Ymd',time()), 'image', $allow_size);
				$img_url=date('Ymd',time()).'/'.$result['filename'];
			}
			
			$post['img_url'] = isset($img_url) ? $img_url: "";
			
			if($charge->ChangeUrl($post)){
				MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/store/expresscharge'));
			}
		}
		
		return $this->render('expresscharge',['model'=>$charge]);
	}
	
	
}