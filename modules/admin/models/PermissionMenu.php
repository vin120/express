<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;


class PermissionMenu extends ActiveRecord
{

	
	public static function tableName() 
	{
		return "{{%permission_menu}}";
	}
	
	
	
	
	public function rules()
	{
		return [
				
		];
	}

	
	public function getPermissionmenu()
	{
		return $this->hasOne(self::className(),['parent_menu_id'=>'menu_id']);
	}
		

	
	
	
	/**
	 * 获取菜单
	 * @param unknown $menu_type [原封不动返回]
	 * @return unknown[]|NULL[]|\yii\db\ActiveRecord[][]
	 */
	public static function getMenu($menu_type='')
	{
		$temp_array = self::find()->where('permission_status = 1 and is_show = 1')->orderBy('list_order')->asArray()->all();
		
		$_datas = [];
		$open_index = 0;
		$open_index2 = 0;
		$open_index3 = 0;
		
		
		foreach ($temp_array as $val) {
			if($val['parent_menu_id'] == 0) {	//找出所有的顶级父类
				$item1[] = $val; 	//parent_id = 0
			}
		}
		
		foreach ($item1 as $value) {	//循环每个父类，找到2级菜单
			foreach ($temp_array as $item2) {
				if($item2['parent_menu_id'] == $value['menu_id']) {	//将符合条件的子类装到对应的父亲里
					$value['child'][] = $item2;
				}
			}
			$permissions[] = $value; 	//将每个父类装好
		}
		
		
		foreach ($permissions as $key => $row) {	//1,2级的菜单
			foreach ($row['child'] as $k => $rows){	//2级菜单
				foreach ($temp_array as $rowss) {
					if($rowss['parent_menu_id'] == $rows['menu_id']) {	//筛选出3级菜单
						foreach ($temp_array as $rowsss){				//筛选出是否有4级菜单
							if($rowsss['parent_menu_id'] == $rowss['menu_id']) {
								$rowss['childs'][] = $rowsss;
							}
						}
						$rows['child'][] = $rowss;
					}
				}
				$permissions[$key]['child'][$k] = $rows;
			}
		}
		
		foreach ($permissions as $permissions_row) {
			foreach ($permissions_row['child'] as $permissions_item){
				if(!isset($permissions_item['child'])){		//3级以前，如1，2
					if($permissions_item['method_name'] == $menu_type){
						$open_index = $permissions_row['menu_id'];		//存在1，2级
					}
				} else {	//三级以后，如3，4
					foreach ($permissions_item['child'] as $permissions_k => $permissions_val) {
						if(isset($permissions_val['childs'])){
							foreach ($permissions_val['childs'] as $permissions_vall){		//存在四级
								if($permissions_vall['method_name'] == $menu_type){
									$open_index = $permissions_row['menu_id'];
									$open_index2 = $permissions_val['parent_menu_id'];
									$open_index3 = $permissions_vall['parent_menu_id'];
								}
							}
						} else if($permissions_val['method_name'] == $menu_type){	//不存在四级
							$open_index = $permissions_row['menu_id'];
							$open_index2 = $permissions_val['parent_menu_id'];
						}
					}
				}
			}
		}
		
		$_datas['permissions'] = $permissions;
		$_datas['open_index']  = $open_index;
		$_datas['open_index2'] = $open_index2;
		$_datas['open_index3'] = $open_index3;
		$_datas['menu_type'] = $menu_type;
		
		return $_datas;
	}
	
	
	
	/**
	 * 获取菜单栏的树状结构，用于权限分组添加，编辑
	 * @param unknown $admin_id
	 * @param unknown $post
	 */
	public static function getMenuTree($admin_id,$post)
	{
		$roles = [];
		$id = isset($post['id']) ? $post['id'] : 0;
		if(isset($post['role'])) {
			$role = json_decode($post['role']);
			
			foreach ($role as $row) {
				foreach ($row as $val) {
					if(is_array($val)) {
						foreach ($val as $item) {
							$roles[] = $item;
						}
					}
					$roles[] = $val;
				}
			}
			
			
			if(isset(Yii::$app->session[$admin_id.'test'])){
				
				//存入第一个以后的控制器id
				$role_session = Yii::$app->session[$admin_id.'test'];
				
				$sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM ts_permission_menu a, ts_permission_menu b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = $id";
				$result = Yii::$app->db->createCommand($sql)->queryOne();
		
				if($result) {
					if(is_array($role_session[$result['bmenu_id']])){
						$role_session[$result['bmenu_id']][Yii::$app->request->post('id')] = Yii::$app->request->post('id');
					} else {
						$role_session[$result['bmenu_id']] = [];
						$role_session[$result['bmenu_id']][Yii::$app->request->post('id')] = Yii::$app->request->post('id');
					}
				} else {
					
					$role_session[Yii::$app->request->post('id')] = Yii::$app->request->post('id');
				}
				
				Yii::$app->session[$admin_id.'test'] = $role_session;
			} else {
				//存入第一个控制器id
				$role_session = [];
				$role_session[Yii::$app->request->post('id')] = Yii::$app->request->post('id');
				Yii::$app->session[$admin_id.'test'] = $role_session;
				
			}
		}
		
		
		$sql = "SELECT a.* ,(SELECT COUNT(*) FROM ts_permission_menu a2 WHERE a2.parent_menu_id = a.menu_id) as child FROM ts_permission_menu a WHERE a.parent_menu_id =$id AND a.permission_status = 1 AND a.is_systemsetting ='0' ";
		$permission = Yii::$app->db->createCommand($sql)->queryAll();
		
		
		$j=1;
		$a='';
		$i = count($permission);
		foreach ($permission as $row){
			if($row['child']>0){
				if($j<$i){
					$j++;
					$a .= '"'.$row['menu_id'].'":{"text" : "'.yii::t('app',$row['role_name']).'","type" : "folder","additionalParameters":{"id":"'.$row['menu_id'].'","children":true}},';
				}else{
					$a .= '"'.$row['menu_id'].'":{"text" : "'.yii::t('app',$row['role_name']).'","type" : "folder","additionalParameters":{"id":"'.$row['menu_id'].'","children":true}}';
				}
			}  else {
				if($j<$i){
					$j++;
					if(in_array($row['menu_id'],$roles)){
						$a .= '"'.$row['menu_id'].'":{"text" : "'.yii::t('app',$row['role_name']).'","type" : "item","additionalParameters":{"id":"'.$row['menu_id'].'","item-selected":true}},';
					}  else {
						$a .= '"'.$row['menu_id'].'":{"text" : "'.yii::t('app',$row['role_name']).'","type" : "item","additionalParameters":{"id":"'.$row['menu_id'].'"}},';
					}
				}  else {
					if(in_array($row['menu_id'],$roles)){
						$a .= '"'.$row['list_order'].'":{"text" : "'.yii::t('app',$row['role_name']).'","type" : "item","additionalParameters":{"id":"'.$row['menu_id'].'","item-selected":true}}';
					}  else {
						$a .= '"'.$row['list_order'].'":{"text" : "'.yii::t('app',$row['role_name']).'","type" : "item","additionalParameters":{"id":"'.$row['menu_id'].'"}}';
					}
				}
			}
		}
	
		$a = '{"status":"OK","data":{'.$a.'}}';
		echo $a;
	}
}


