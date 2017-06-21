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
	
	
	
	/**文件上传**/
	public static function upload_file($input_name, $file_path='./', $type='image', $allow_size=2){
		// 上传的文件
		$file=$_FILES[$input_name];
		
		// 错误信息
		$error='';
		
		// 允许上传的文件类型数组
		$allow_type=array(
				'image'=>array(
						'jpg'=>'image/jpeg',
						'png'=>'image/png',
						'gif'=>'image/gif',
				),
				'pdf'=>array(
						'pdf'=>'application/pdf',
				),
				// 这里可以继续添加文件类型
		);
		
		// 检查上传文件的类型是否在允许的文件类型数组里
		if( !in_array($file['type'], $allow_type[$type]) ){
			$error="Please upload".implode('、', array_keys($allow_type[$type]) )."Format of the file";
			//Helper::show_message($error);die;
		}
		
		// 检查上传文件的大小是否超过指定大小
		$size=$allow_size*1024*1024;
		if( $file['size'] > $size ){
			$error="You upload the file size please don't over{$allow_size}MB";
			//Helper::show_message($error);die;
		}
		
		// 错误状态
		switch($file['error']){
			case 1:
				$error='You have uploaded file size is more than the size of the server configuration';
				//Helper::show_message($error);die;
			case 2:
				$error='You uploaded file size is more than the size of the form setting';
				//Helper::show_message($error);die;
			case 3:
				$error='Network problems, please check your Internet connection?';
				//Helper::show_message($error);die;
			case 4:
				$error='Please select you want to upload files';
				//Helper::show_message($error);die;
		}
		
		// 自动生成目录
		if ( !file_exists($file_path) ) {
			mkdir($file_path, 0777, true);
		}
		
		if($error){
			return array(
					'error'=>1,
					'warning'=>$error,
			);
		}
		
		// 生成保存到服务器的文件名
		$filename=date('YmdHis').mt_rand(1000,9999).".".array_search($file['type'], $allow_type[$type]);
		// 保存上传文件到本地目录
		if( move_uploaded_file($file['tmp_name'], $file_path."/".$filename) ){
			return array(
					'error'=>0,
					'filename'=>$filename,
			);
		}
	}
	
	
	
}