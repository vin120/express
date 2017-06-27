<?php

return [
    'adminEmail' => 'admin@example.com',
		
	//分页
	'pageSize' => [
		'admin' => 10,
		'role' => 10,	
		'user'=>10,
		'recharge'=>10,
		'store'=>10,
		'rechargelog'=>10,
		'zhstore'=>10,
		'news'=>10,
		'deliverylog'=>10,
	],	
	
	//管理員的權限id
	'a_admin' => [
		'add' => '5',
		'edit' => '6',
		'delete' => '7',
	],
		
	//權限分配的id
	'a_role' => [
		'add' => '9',
		'edit' => '10',
		'delete' => '11',
	],
		
	//用户操作
	'u_user' => [
		'add'=>'',
		'edit'=>'14',
		'delete'=>'15',
	],
		
	//充值
	'u_recharge' => [
		'edit'=>'17',
	],
	
	//澳门取货地址
	's_store' => [
		'add'=>'28',
		'edit'=>'29',
		'delete'=>'30',
	],		
		
	//珠海收货地址
	's_zhstore' => [
		'add' =>'32',
		'edit'=>'33',
		'delete'=>'34',
	],
		
		
	//公告讯息
	's_news' => [
		'add' =>'36',
		'edit'=>'37',
		'delete'=>'38',
	],
		
		
		
		
	'img_url_prefix' =>'../upload/',	//上传路径
	'img_url' => 'http://localhost/express/upload',	//访问路径

	//啓動頁面圖片路徑
// 	'ad_img_url' => '127.0.0.1',

	// ============== 国际接口 ==================
	'uns' => 'I8289053',
	'pws' => 'OiC4LzTA2m4563',		
		
];
