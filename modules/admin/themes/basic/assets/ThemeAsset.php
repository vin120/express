<?php

namespace app\modules\admin\themes\basic\assets;
use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
	public $sourcePath = "@app/modules/admin/themes/basic/static";
	
	public $css = [
		//<!-- bootstrap & fontawesome -->
		'css/bootstrap.min.css',
		'css/font-awesome.min.css',
			
			
		//<!-- ace styles -->
		'css/ace.min.css',
		'css/ace-rtl.min.css',	
			
		//<!-- text fonts -->
		'css/fonts.googleapis.com.css',
			
	
			
	];
	
	
	public $js = [
		'js/jquery-2.1.4.min.js',
	];
	
	
}