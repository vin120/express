<?php

namespace app\modules\admin\themes\basic\assets;
use yii\web\AssetBundle;

class ThemeAssetExtra extends AssetBundle
{
	public $sourcePath = "@app/modules/admin/themes/basic/static";
	
	public $css = [
		//<!-- ace styles -->
		'css/ace-skins.min.css',
		'css/jquery-ui.min.css',	
		
	];
	
	
	public $js = [
		//<!-- ace settings handler -->
		'js/ace-extra.min.js',
			
			
		'js/bootstrap.min.js',
			
			
		'js/jquery-ui.min.js',
		'js/jquery.ui.touch-punch.min.js',
		'js/jquery.easypiechart.min.js',
		'js/jquery.sparkline.index.min.js',
		'js/jquery.flot.min.js',
		'js/jquery.flot.pie.min.js',
		'js/jquery.flot.resize.min.js',
			
		//<!-- ace scripts -->
		'js/ace-elements.min.js',
		'js/ace.min.js',
			
// 		<!-- page specific plugin scripts -->
		'js/tree.min.js',
	];
	
	
}