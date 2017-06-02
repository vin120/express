<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\admin\models\AdminRole;

class Admin extends ActiveRecord implements IdentityInterface
{
	
	public $new_password;
	public $re_password;
	public $rememberMe = false;
	
	
	private $_user = false;
	
	public static function tableName()
	{
		return "{{%admin}}";
	}
	
	
	public function attributeLabels()
	{
		return [
			'admin_name' => Yii::t('app', '用户名：'),
			'admin_real_name'=>Yii::t('app','昵称：'),
			'admin_password' => Yii::t('app','密码：'),
			'new_password' => Yii::t('app','新密码：'),
			'role_id' => Yii::t('app','管理员分组：'),
			're_password' => Yii::t('app', '确认密码：'),
			'rememberMe'=> Yii::t('app', '记住密码：'),
		];
	}
	
	
	public function rules()
	{	
		return [
			[['admin_name'],'required','message'=>Yii::t('app', '用户名不能为空'),'on'=>['login','addadmin']],
			[['admin_name'],'unique','message'=>Yii::t('app', '用户名已占用'),'on'=>['addadmin']],
			[['admin_name'],'validateAdminName','on'=>['editadmin']],
			[['admin_password'],'required','message'=>Yii::t('app', '密码不能为空'),'on'=>['login','changepassword','addadmin']],
			[['new_password'],'required','message'=>Yii::t('app','新密码不能为空'),'on'=>['changepassword']],
			[['re_password'],'required','message'=>Yii::t('app', '确认密码不能为空'),'on'=>['addadmin','changepassword','addadmin']],
			[['new_password'],'compare','compareAttribute'=>'admin_password','operator'=>'!==','message'=>Yii::t('app','原密码与新密码不能相同') ,'on'=>['changepassword']],
			[['rememberMe'],'boolean','on'=>['login']],
			[['re_password'],'compare','compareAttribute'=>'new_password','message'=>Yii::t('app', '两次密码不一致'),'on'=>['changepassword']],
			[['re_password'],'compare','compareAttribute'=>'admin_password','message'=>Yii::t('app','两次密码不一致'),'on'=>['addadmin']],
			[['admin_password'],'validatePassword','on'=>['login','changepassword']],
			[['new_password'],'string','length'=>[6,12],'tooLong'=>Yii::t('app', '密碼最多爲12位'),'tooShort'=>Yii::t('app', '密碼最少爲6位'),'on'=>['changepassword']],
			[['admin_name','admin_password','re_password'],'string','length'=>[6,12],'tooLong'=>Yii::t('app', '最多爲12位'),'tooShort'=>Yii::t('app', '最少爲6位'),'on'=>['addadmin']],
			[['admin_real_name','login_ip','login_time','role_id','admin_status'],'safe'],
		];
	}
	
	
	/**
	 * 与adminRole表关联
	 * @return ActiveQuery
	 */
	public function getAdminrole()
	{
		return $this->hasOne(AdminRole::className(),['role_id'=>'role_id']);
	}
	
	
	/**
	 * 验证密码 
	 */
	public function validatePassword()
	{
		if(!$this->hasErrors()){
			$data = self::find()->where('admin_name = :admin_name and admin_password = :admin_password',[':admin_name' =>$this->admin_name,':admin_password'=>md5($this->admin_password)])->one();
			if(is_null($data)) {
				$this->addError("admin_password",Yii::t('app','密码错误'));
			}
		}
	}
	
	/**
	 * 验证用户名是否存在 
	 */
	public function validateAdminName()
	{
		$admin_name = self::find()->where('admin_id = :admin_id',[':admin_id'=>$this->admin_id])->one()['admin_name'];
		
		if(!$this->hasErrors()){
			
			$data = self::find()->where('admin_name = :admin_name',[':admin_name'=>$this->admin_name])->one();
			
			if(!is_null($data) && $admin_name != $data['admin_name']){
				$this->addError("admin_name",Yii::t('app','用户名已占用'));
			}
		}
	}
	
	
	/**
	 * 登录函数
	 * 登录成功时会通过Yii::$app->admin->login()函数记录admin的信息
	 * @param unknown $data
	 * @return boolean
	 */
	public function login($data)
	{
		$this->scenario = "login";
		
		if($this->load($data) && $this->validate()) {
			
			$lifetime = $this->rememberMe ? 24 * 3600 : 0;
		
			//更新数据库中的内容
			$this->updateAll(['login_time'=>date("Y-m-d H:i:s",time()),'login_ip'=>ip2long(Yii::$app->request->userIP)],'admin_name = :admin_name',[':admin_name'=>$this->admin_name]);
			//Yii::$app->admin->login()返回成功时，会把用户信息保存起来，使用Yii::$app->admin->identity->xxx(xxx代表数据库中的字段)即可获取相关字段的值
			return Yii::$app->admin->login($this->getUser(),$lifetime);
		}
		return false;
	}
	
	
	
	public function addAdmin($post)
	{
		$this->scenario = "addadmin";

		
		$data['Admin'] = $post;
		//$this->load($data)  $data必须封装成一个数组,而且数组必须以$data['xxx'][] 存在，其中xxx必须以model名字相同
		if ($this->load($data) && $this->save()) {
			return true;
		}
		return false;
		
	}
	
	
	public function editAdmin($post)
	{
		$this->scenario = "editadmin";
		
		$data['Admin'] = $post;
		
		if($this->load($data) && $this->save()){
			return true;
		}
		
		return false;
	}
	
	
	
	/**
	 * 	更新密码
	 * @param unknown $data
	 * @return boolean
	 */
	public  function changePassword($data)
	{
		$this->scenario = "changepassword";

		if($this->load($data) && $this->validate()) {
			return (bool) $this->updateAll(['admin_password' => md5($this->new_password)],'admin_name = :admin_name',[':admin_name'=>$this->admin_name]);
		}
		
		return false;
		
	}
	
	
	
	
	/**
	 * 通过传来的数据，改变数据结构
	 * @param unknown $datas
	 * @return unknown[]
	 */
// 	public static function getRoleStructure($datas)
// 	{
	
// 		$value = [];
// 		$admin = [];
// 		foreach ($datas as $k => $data) {
// 			foreach ($data['adminrole'] as $row) {
// 				$value[] = $row;
// 			}
// 			foreach ( array_keys($data['adminrole']) as $key=> $row){
// 				$data[$row] = $value[$key];
// 			}
// 			unset($data['adminrole']);
// 			$admin[] = $datas;
// 		}
// 		return $admin;
// 	}
	
	
	
	/**
	 * 如果想通过Yii::$app->admin->identity->xxxxx 获取相关的属性信息，必须要使用Yii::$app->admin->login()函数，就必须要实现IdentityInterface这个接口
	 * 
	 *  IdentityInterface 接口的方法，规定要重写
	 * @param unknown $id
	 * @return \app\modules\admin\models\Admin
	 */
	public static function findIdentity($id)
    {
        return static::findOne(['admin_id' => $id]);
    }
    
    
    /**
	 * 如果想通过Yii::$app->admin->identity->xxxxx 获取相关的属性信息，必须要使用Yii::$app->admin->login()函数，就必须要实现IdentityInterface这个接口
	 * 
	 *  IdentityInterface 接口的方法，规定要重写
	 * @param unknown $id
	 * @return \app\modules\admin\models\Admin
	 */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    /**
     * 如果想通过Yii::$app->admin->identity->xxxxx 获取相关的属性信息，必须要使用Yii::$app->admin->login()函数，就必须要实现IdentityInterface这个接口
     *
     *  IdentityInterface 接口的方法，规定要重写
     * @param unknown $id
     * @return \app\modules\admin\models\Admin
     */
    public function getId()
    {
    	return $this->admin_id;
    }
    
    /**
     * 如果想通过Yii::$app->admin->identity->xxxxx 获取相关的属性信息，必须要使用Yii::$app->admin->login()函数，就必须要实现IdentityInterface这个接口
     *
     *  IdentityInterface 接口的方法，规定要重写
     * @param unknown $id
     * @return \app\modules\admin\models\Admin
     */
    public function getAuthKey()
    {
    	return "admin";
    }
    
    /**
     * 如果想通过Yii::$app->admin->identity->xxxxx 获取相关的属性信息，必须要使用Yii::$app->admin->login()函数，就必须要实现IdentityInterface这个接口
     *
     *  IdentityInterface 接口的方法，规定要重写
     * @param unknown $id
     * @return \app\modules\admin\models\Admin
     */
    public function validateAuthKey($authKey)
    {
    	return $authKey == "admin";
    }
    
    
   	/**
   	 * find  by [admin_name]
   	 * @param unknown $username
   	 * @return \app\modules\admin\models\Admin
   	 */
   	protected static function findByUsername($username)
   	{
   		return static::findOne(['admin_name' => $username]);
   	}
	
   	
   	/**
   	 * 通过admin_name找到相关admin
   	 * @return \app\modules\admin\models\Admin
   	 */
   	protected function getUser()
   	{
   		if ($this->_user === false) {
   			$this->_user = Admin::findByUsername($this->admin_name);
   		}
   	
   		return $this->_user;
   	}
	
   	
   	
   	
	
	
	
}
