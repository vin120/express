<?php

namespace app\modules\admin\components;


class MyFunction {
	
	
	
	/**
	 * 用于显示  更新，删除或插入...显示结果并跳转url
	 * @param unknown $info
	 * @param string $url
	 */
	public static function showMessage($info,$url='')
	{
		header('Content-Type:text/html;charset=utf-8');
		if($url && $url != '#') {
			echo "<script>alert('{$info}');location='{$url}';</script>";
		}else if($url == '#'){
            echo "<script>alert('{$info}');</script>";
        }else{
            echo "<script>alert('{$info}');history.back();</script>";
        }
	}
	
}