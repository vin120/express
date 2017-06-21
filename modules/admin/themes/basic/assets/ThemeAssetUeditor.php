<?php
namespace app\modules\admin\themes\basic\assets;

use yii\web\AssetBundle;

class ThemeAssetUeditor extends AssetBundle
{

	public $sourcePath = "@app/modules/admin/themes/basic/static";
	public $css = [
		
	];

	public $js = [
		'js/ueditor/ueditor.config.js',
		'js/ueditor/ueditor.all.js',
	];
	

	
	
	public $depends = [
		'app\modules\admin\themes\basic\assets\ThemeAsset',
	];
}