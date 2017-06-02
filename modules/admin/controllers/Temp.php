<?php

function actionRoleedit()
{
	//获取菜单
	Yii::$app->view->params['menu'] = PermissionMenu::getMenu('role');
	//检查权限
	$this->CheckAuth();
		
	$post = Yii::$app->request->post();

	$edit_id = isset($post['edit_id']) ? $post['edit_id'] : FALSE;
	$edit_id2 = isset($post['edit_id2']) ? $post['edit_id2'] : FALSE;
	$id = $edit_id ? $edit_id : $edit_id2;

	$role = new AdminRole();

	if($id) {
		$role = $role::find()->where('role_id = :role_id',[':role_id'=>$id])->one();
	}

	$permission = $role['permission_menu'];
	$permission = json_decode($permission,true);
	$admin_id = Yii::$app->admin->identity->admin_id;

	if( Yii::$app->request->isPost ) {

		if(!$edit_id) {

			$a = explode(',', $post['hidden']);
			$num = count($a);
			unset($a[$num-1]);
			$new_permission = [];
			foreach ($a as $row){
				$sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM ts_permission_menu a, ts_permission_menu b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$row}";
				$b = Yii::$app->db->createCommand($sql)->queryOne();//跟住自id查找父目录的id，


				if($b['bparent_menu_id']!='0'){//当父目录不为顶级目录时继续查找父目录
					$sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM ts_permission_menu a, ts_permission_menu b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$b['bmenu_id']}";
					$c = Yii::$app->db->createCommand($sql)->queryOne();//跟住自id查找父目录的id，

					$new_permission[$c['bmenu_id']][$c['amenu_id']][] = $row;//封装第三级目录数组
				} else {
					$new_permission[$b['bmenu_id']][] = $row;//封装第二级目录数组
				}
			}

			$n_permission = Yii::$app->session[$admin_id.'test'];
			unset($n_permission[0]);



			foreach ($n_permission as $key=>$row){
				if(is_array($row)){//判断是否是3级目录
					foreach($row as $k=>$item){
						$n_permission[$key][$k] = [];//将点击过的权限组封装成空数组
					}
				}else{
					$n_permission[$key] = [];
				}
			}

			foreach($new_permission as $key=>$row){
				if(is_array($row)){//判断是否是3级目录
					foreach($row as $k=>$item){
						$n_permission[$key][$k] = $item;
					}
				}else {
					$n_permission[$key] = $row;
				}
			}

			foreach ($n_permission as $key=>$row){
				if(is_array($row)){//判断是否是3级目录
					foreach ($row as $k=>$item){
						if(empty($item)){
							unset($permission[$key][$k]);
						}
					}
				}else{
					if(empty($row)){
						unset($permission[$key]);
					}
				}
			}

			foreach($new_permission as $key=>$row){
				if(is_array($row)){//判断是否是3级目录
					foreach ($row as $k=>$item){
						$permission[$key][$k] = $item;
					}
				}  else {
					$permission[$key] = $row;
				}
			}



			if(empty($permission)){
				MyFunction::showMessage(Yii::t('app','该分组不能没有权限！'),Url::to('/admin/auth/role'));
				Yii::$app->end();
			}

			$permission = json_encode($permission);
			$status = isset($post['status']) ? $post['status'] : '0';

			if(isset($post['role']) && isset($post['describe'])) {
					
				//判断若hidden值为空，代表打开分类为全部不选中状态，
				if(empty($post['hidden']) && !empty($post['hidden_parent'])){
					$del_json = $post['hidden_parent'];
					$del_id = explode(',',$del_json);
					foreach($del_id as $v){
						$reg = "/\"".$v."\"\:\[(.*?)\](,?)/";
						$permission = preg_replace($reg,"", $permission);
					}
				}elseif(!empty($post['hidden']) && !empty($post['hidden_parent'])){
					//查询子类的父级键名，将hidden_parent中去除该父级键名
					$hidden = trim($post['hidden'],',');
					$hidden_parent = $post['hidden_parent'];
					$hidden_parent = explode(',',$hidden_parent);
				}

				//将最外层{...,}的最后一个逗号去除，有时有有时无
				$permission = substr($permission , 1 , -1);
				$permission = trim($permission,",");
				$permission = '{'.$permission.'}';
				 
					
				$data = [];
				$data['AdminRole']['role_name'] = $post['role'];
				$data['AdminRole']['role_desc'] = $post['describe'];
				$data['AdminRole']['permission_menu'] = $permission;
				$data['AdminRole']['status'] =  $status;

				if($role->mod($data)){
					unset(Yii::$app->session[$admin_id.'test']);
					MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/auth/role'));
				}else {
					unset(Yii::$app->session[$admin_id.'test']);
				}
					
			} else {
				unset(Yii::$app->session[$admin_id.'test']);
				MyFunction::showMessage(Yii::t('app','修改失败'),Url::to('/admin/auth/role'));
			}
		}
		$permission_click = PermissionClick::find()->all();
		return $this->render('roleedit',['permission_click'=>$permission_click,'role'=>$role,'id'=>$id]);
	}
}




// 	function actionRoleedit()
// 	{
// 		//获取菜单
// 		Yii::$app->view->params['menu'] = PermissionMenu::getMenu('role');
// 		//检查权限
// 		$this->CheckAuth();
	


// 		$post = Yii::$app->request->post();

// 		$edit_id = isset($post['edit_id']) ? $post['edit_id'] : FALSE;
// 		$edit_id2 = isset($post['edit_id2']) ? $post['edit_id2'] : FALSE;
// 		$id = $edit_id ? $edit_id : $edit_id2;


// 		$role = new AdminRole();

// 		if($id){
// 			$role = $role::find()->where('role_id = :role_id',[':role_id'=>$id])->one();
// 		}



// 		$permission = $role['permission_menu'];
// 		$permission = json_decode($permission,true);
// 		$admin_id = Yii::$app->admin->identity->admin_id;


// 		if(Yii::$app->request->isPost){
	
// 			if(!$edit_id) {
// 				$a = explode(',', $post['hidden']);
// 				$num = count($a);
// 				unset($a[$num-1]);
// 				$new_permission = [];
// 				foreach ($a as $row){

// 					$sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM ts_permission_menu a, ts_permission_menu b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$row}";
// 					$b = Yii::$app->db->createCommand($sql)->queryOne();//跟住自id查找父目录的id，

	
// 					if($b['bparent_menu_id']!='0'){//当父目录不为顶级目录时继续查找父目录
// 						$sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM ts_permission_menu a, ts_permission_menu b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$b['bmenu_id']}";
// 						$c = Yii::$app->db->createCommand($sql)->queryOne();//跟住自id查找父目录的id，

// 						$permission[$c['bmenu_id']][$c['amenu_id']][] = $row;//封装第三级目录数组
// 					} else {
// 						$permission[$b['bmenu_id']][] = $row;//封装第二级目录数组
// 					}
// 				}

// // 				var_dump(json_encode($permission));exit;

// 				$n_permission = Yii::$app->session[$admin_id.'test'];

// 				unset($n_permission[0]);




// 				foreach ($n_permission as $key=>$row){
// 					if(is_array($row)){//判断是否是3级目录
// 						foreach($row as $k=>$item){
// 							$n_permission[$key][$k] = [];//将点击过的权限组封装成空数组
// 						}
// 					}else{
// 						$n_permission[$key] = [];
// 					}
// 				}

// 				foreach($new_permission as $key=>$row){
// 					if(is_array($row)){//判断是否是3级目录
// 						foreach($row as $k=>$item){
// 							$n_permission[$key][$k] = $item;
// 						}
// 					}else {
// 						$n_permission[$key] = $row;
// 					}
// 				}

// 				foreach ($n_permission as $key=>$row){
// 					if(is_array($row)){//判断是否是3级目录
// 						foreach ($row as $k=>$item){
// 							if(empty($item)){
// 								unset($permission[$key][$k]);
// 							}
// 						}
// 					}else{
// 						if(empty($row)){
// 							unset($permission[$key]);
// 						}
// 					}
// 				}

// 				foreach($new_permission as $key=>$row){
// 					if(is_array($row)){//判断是否是3级目录
// 						foreach ($row as $k=>$item){
// 							$permission[$key][$k] = $item;
// 						}
// 					}  else {
// 						$permission[$key] = $row;
// 					}
// 				}

// 				if(empty($permission)){
// 					MyFunction::showMessage(Yii::t('app','该分组不能没有权限！'),Url::to('/admin/auth/role'));
// 					Yii::$app->end();
// 				}

// 				$permission = json_encode($permission);

// 				$status = isset($post['status']) ? $post['status'] : '0';


// 				if(isset($post['role']) && isset($post['describe'])){
	
// 					//判断若hidden值为空，代表打开分类为全部不选中状态，
// 					if(empty($post['hidden']) && !empty($post['hidden_parent'])) {
// 						$del_json = $post['hidden_parent'];
// 						$del_id = explode(',',$del_json);

// 						foreach($del_id as $v){
// 							$reg = "/\"".$v."\"\:\[(.*?)\](,?)/";
// 							$permission = preg_replace($reg,"", $permission);
// 						}
// 					} else if(!empty($post['hidden']) && !empty($post['hidden_parent'])){

// 						//查询子类的父级键名，将hidden_parent中去除该父级键名
// 						$hidden = trim($post['hidden'],',');
// 						$hidden_parent = $post['hidden_parent'];
// 						$hidden_parent = explode(',',$hidden_parent);



// 						$result = PermissionMenu::find()->select('parent_menu_id')->where('menu_id in(:menu_id)',[':menu_id'=>$hidden])->groupBy('parent_menu_id')->all();


// 						foreach ($result as $val) {
// 							if(in_array($val['parent_menu_id'], $hidden_parent)){
// 								unset($hidden_parent[array_search($val['parent_menu_id'],$hidden_parent)]);
// 							}
// 						}

// 						foreach($hidden_parent as $v){
// 							$reg = "/\"".$v."\"\:\[(.*?)\](,?)/";
// 							$permission = preg_replace($reg,"", $permission);
// 						}


// 					}
	
	
// 					//将最外层{...,}的最后一个逗号去除，有时有有时无
// 					$permission = substr($permission , 1 , -1);
// 					$permission = trim($permission,",");
// 					$permission = '{'.$permission.'}';
	
// // 					var_dump($permission);exit;
	
// // 					$role->role_name = $post['role'];
// // 					$role->role_desc = $post['describe'];
// // 					$role->permission_menu = $permission;
// // 					$role->role_status =  $status;
// // 					if($role->save()){
// // 						MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/auth/role'));
// // 					} else {
// // 						MyFunction::showMessage(Yii::t('app','修改失败'),Url::to('/admin/auth/role'));
// // 					}

	
// // 					$sql = "UPDATE `ts_admin_role` SET `role_name` = '".$post['role']."', `role_desc` = '".$post['describe']."',permission_menu = '$permission',`role_status`='$status' WHERE `role_id` = {$id}";
// // 					$count = Yii::$app->db->createCommand($sql)->execute();
// // 					if($count > 0){
// // 						MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/auth/role'));
// // 					} else  {
// // 						MyFunction::showMessage(Yii::t('app','修改失败'),Url::to('/admin/auth/role'));
// // 					}
	
	
	
// // 					if($role->updateAll(['role_name'=>$post['role'],'role_desc'=>$post['describe'],'permission_menu'=>$permission,'role_status'=>$status],'role_id = :role_id',[':role_id'=>$id])){
// // 						MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/auth/role'));
// // 					} else  {
// // 						MyFunction::showMessage(Yii::t('app','修改失败'),Url::to('/admin/auth/role'));
// // 					}
	

	
// 					$data = [];
// 					$data['AdminRole']['role_name'] = $post['role'];
// 					$data['AdminRole']['role_desc'] = $post['describe'];
// 					$data['AdminRole']['permission_menu'] = $permission;
// 					$data['AdminRole']['status'] =  $status;
	
	
// 					if($role->mod($data)){
// 						MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/auth/role'));
// 					}
	
	
// // 					if($role->load($data) && $role->save()){
// // 						MyFunction::showMessage(Yii::t('app','修改成功'),Url::to('/admin/auth/role'));
// // 					} else{
// // 						MyFunction::showMessage(Yii::t('app','修改失败'),Url::to('/admin/auth/role'));
// // 					}
	
// 					unset(Yii::$app->session[$admin_id.'test']);
	
// 				} else {
// 					unset(Yii::$app->session[$admin_id.'test']);
// 					MyFunction::showMessage(Yii::t('app','修改失败'),Url::to('/admin/auth/role'));
// 				}

// 			}

// 		}


// 		$permission_click = PermissionClick::find()->all();
// 		return $this->render('roleedit',['permission_click'=>$permission_click,'role'=>$role,'id'=>$id]);
// 	}