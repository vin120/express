<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use app\modules\admin\models\Admin;
use app\modules\admin\components\MyFunction;


class AdminRole extends ActiveRecord
{
	public $hidden;
	public $hidden_parent;
	
	
	public static function tableName()
	{
		return "{{%admin_role}}";
	}
	
	
	public function attributeLabels()
	{
		return [
			'role_name' => Yii::t('app', '分组名：'),
			'role_desc' => Yii::t('app', '分组说明：'),
			'role_status' => Yii::t('app','状态：'),
		];
	}
	
	
	
	public function rules()
	{
		return [
			[['role_name'],'required','message'=>Yii::t('app','请输入分组名'),'on'=>['addrole','editrole']],
			[['role_name'],'unique','message'=>Yii::t('app','此分组名已被使用'),'on'=>['addrole',]],
			[['role_desc'],'required','message'=>Yii::t('app','请正确输入分组描述'),'on'=>['addrole','editrole']],
			[['role_name'],'validateRolename','on'=>['editrole']],
			[['hidden'],'required','message'=>Yii::t('app','请分配权限'),'on'=>['addrole']],
			[['role_status'], 'integer'],
			[['permission_menu'],'safe'],
		];
	}
	

	
	/**
	 *  编辑时检查分组名是否重复[检查除了本身的名字外，编辑时是否存在相同的名字] 
	 */
	public function validateRolename()
	{
		
		$role_name = self::find()->where('role_id = :role_id',[':role_id'=>$this->role_id])->one()['role_name'];
		
		if(!$this->hasErrors()){
			$data = self::find()->where('role_name = :role_name',[':role_name'=>$this->role_name])->one();
			
			if(!is_null($data) && $role_name != $data['role_name']){
				
				$this->addError("role_name",Yii::t('app','权限名重复'));
			}
		}
	}
	
	
	
	
	/**
	 * 通过role_id与admin表关联
	 * @return ActiveQuery
	 */
	public function getAdmin()
	{
		return $this->hasMany(Admin::className(),['role_id'=>'role_id']);
	}
	
	
	
	
	protected function getData()
	{
		$roles = self::find()->where('role_id > 1')->asArray()->all();
		return $roles;
	}
	
	public function getOptions()
	{
		$data = $this->getData();
		$options = [Yii::t('app','添加管家管理员分组')];
	
		foreach ($data as $role){
			$options[$role['role_id']] = $role['role_name'];
		}
		
		return $options;
	}
	
	
	
	/**
	 * 保存「添加分组权限」时传过来的数据
	 * @param unknown $post
	 * @return boolean
	 */
	public function addRole($post)
	{
		$this->scenario = "addrole";
	
		
		$permission = json_encode($this->getPermissionmenuInDB($post));
		$data['AdminRole'] = $post;
		$data['AdminRole']['permission_menu'] = $permission;
		
		//$this->load($data)  $data必须封装成一个数组,而且数组必须以$data['xxx'][] 存在，其中xxx必须以model名字相同
		if ($this->load($data) && $this->save()) {
			return true;
		}
		return false;
	
	}
	
	
	
	/**
	 * 保存「编辑分组权限」时传过来的数据
	 * @param unknown $role
	 * @param unknown $post
	 * @return boolean
	 */
	public function editRole($role,$post)
	{
		$permission = $role['permission_menu'];
		$permission = json_decode($permission,true);
		$admin_id = Yii::$app->admin->identity->admin_id;
		$new_permission = $this->getPermissionmenuInDB($post);
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
			MyFunction::showMessage(Yii::t('app','修改失败,该分组不能没有权限！'),Url::to('/admin/auth/role'));
			Yii::$app->end();
		}
		
		$permission = json_encode($permission);
		$status = isset($post['status']) ? $post['status'] : 0;
		
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
			 
			if(empty($permission) || $permission == '{}'){
				MyFunction::showMessage(Yii::t('app','修改失败,该分组不能没有权限！'),Url::to('/admin/auth/role'));
				Yii::$app->end();
			}
			
			$data = [];
			$data['AdminRole']['role_name'] = $post['role'];
			$data['AdminRole']['role_desc'] = $post['describe'];
			$data['AdminRole']['permission_menu'] = $permission;
			$data['AdminRole']['role_status'] =  $status;
		
			if($role->mod($data)){
				unset(Yii::$app->session[$admin_id.'test']);
				return true;
			}else {
				unset(Yii::$app->session[$admin_id.'test']);
				return false;
			}
				
		} else {
			unset(Yii::$app->session[$admin_id.'test']);
			return false;
		}
	}
	
	
	
	/**
	 * 根据传来的数据查询
	 * @param unknown $post
	 * @return unknown
	 */
	protected function getPermissionmenuInDB($post)
	{
		$permission = [];
		$a = explode(',',$post['hidden']);
		
		$num = count($a);
		unset($a[$num-1]);
			
		foreach ($a as $row) {
		
			$sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM ts_permission_menu a, ts_permission_menu b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$row}";
			$b = Yii::$app->db->createCommand($sql)->queryOne();//跟住自id查找父目录的id，
		
				
			if($b['bparent_menu_id']!='0'){//当父目录不为顶级目录时继续查找父目录
				$sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM ts_permission_menu a, ts_permission_menu b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$b['bmenu_id']}";
				$c = Yii::$app->db->createCommand($sql)->queryOne();//跟住自id查找父目录的id，
		
		
				$permission[$c['bmenu_id']][$c['amenu_id']][] = $row;//封装第三级目录数组
			} else {
				$permission[$b['bmenu_id']][] = $row;//封装第二级目录数组
			}
		}
		return $permission;
	}
	
	
	/**
	 * 保存「编辑」时传过来的数据
	 * @param unknown $data
	 * @return boolean
	 */
	protected function mod($data) 
	{
		$this->scenario = "editrole";
		if($this->load($data) && $this->save()){
			return true;
		}
		return false;
	}
	
	
	
	
	/**
	 * 获取 action 菜单栏权限
	 * @return unknown[]|mixed[]|\yii\db\ActiveRecord[]|NULL[]
	 */
	public static function getAuth()
	{
		$admin_id = Yii::$app->admin->identity->admin_id;
		$permission = self::find()->joinWith('admin')->where('admin_id = :admin_id',[':admin_id' =>$admin_id])->one();
		
		if($permission['permission_menu'] != '0'){
			$permission = json_decode($permission['permission_menu'],true);
			$_auth = [];
			foreach($permission as $key => $row) {
				$_auth[] = $key;
		
				foreach ($row as $k => $val ){
					if(is_array($val)){
						$_auth[] = $k;
						foreach ( $val as $kk => $item){
							if(is_array($item)) {
								$_auth[] = $kk;
							} else {
								$_auth[] = $item;
							}
						}
					} else {
						$_auth[] = $val;
					}
				}
			}
		} else {
			$_auth['0'] = $permission['permission_menu'];
		}
		
		return $_auth;
	}
	
}


