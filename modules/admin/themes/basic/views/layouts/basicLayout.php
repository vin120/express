<?php 
	use yii\helpers\Html;
	use yii\helpers\Url;
	use app\modules\admin\themes\basic\assets\ThemeAsset;
	$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
	
	
	$permissions = Yii::$app->view->params['menu']['permissions'];
	$open_index = Yii::$app->view->params['menu']['open_index'];
	$open_index2 = Yii::$app->view->params['menu']['open_index2'];
	$open_index3 = Yii::$app->view->params['menu']['open_index3'];
	$menu_type = Yii::$app->view->params['menu']['menu_type'];	//目前的菜单(如：打开的是index)
	
	$auth = Yii::$app->view->params['auth'];	//菜单权限

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8">
	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="Basic " />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	
	<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo $baseUrl?>css/ace-part2.min.css" class="ace-main-stylesheet" />
	<![endif]-->
	
	<!--[if lte IE 9]>
	  <link rel="stylesheet" href="<?php echo $baseUrl?>css/ace-ie.min.css" />
	<![endif]-->
	
	
	<!--[if lte IE 8]>
	<script src="<?php echo $baseUrl?>js/html5shiv.min.js"></script>
	<script src="<?php echo $baseUrl?>js/respond.min.js"></script>
	<![endif]-->
	
	
    <?php $this->head() ?>
</head>
<body class="no-skin">
<?php $this->beginBody() ?>
<div id="navbar" class="navbar navbar-default ace-save-state">
	<div class="navbar-container ace-save-state" id="navbar-container">
	<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
		<span class="sr-only"><?php echo Yii::t('app','Toggle SideBar');?></span>
		
		<span class="icon-bar"></span>
		
		<span class="icon-bar"></span>
		
		<span class="icon-bar"></span>
	</button>
	
		<div class="navbar-header pull-left">
			<a href="#" class="navbar-brand">
				<small>
					<i class="fa fa-leaf"></i>
					<?php echo Yii::t("app", "后台管理系统")?>
				</small>
			</a>
		</div>

		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
	
				<li class="light-blue dropdown-modal">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<img class="nav-user-photo" src="<?php echo $baseUrl?>img/avatars/user.jpg" alt="Photo" />
						<span class="user-info">
							<small><?php echo Yii::t('app','欢迎您')?> ,</small>
							<?php echo Yii::$app->admin->identity ? Yii::$app->admin->identity->admin_name :'' ?>
						</span>

						<i class="ace-icon fa fa-caret-down"></i>
					</a>

					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
					
						<li>
							<a href="<?php echo Url::to('/admin/auth/passwordedit')?>">
								<i class="ace-icon fa fa-user"></i>
								<?php echo Yii::t('app','修改密码')?>
							</a>
						</li>

						<li class="divider"></li>
						
						<li>
							<a href="<?php echo Url::toRoute(['login/logout'])?>">
								<i class="ace-icon fa fa-power-off"></i>
								<?php echo Yii::t('app','登出')?>
							</a>
						</li>
						
					</ul>
					
				</li>
			</ul>
		</div>
	</div><!-- /.navbar-container -->
</div>




<div class="main-container ace-save-state" id="main-container">
	<script type="text/javascript">
		try{ace.settings.loadState('main-container')}catch(e){}
	</script>
	
	
	<div id="sidebar" class="sidebar responsive ace-save-state">
		<script type="text/javascript">
			try{ace.settings.loadState('sidebar')}catch(e){}
		</script>
		
		
		<div class="sidebar-shortcuts" id="sidebar-shortcuts">
			<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
				<button class="btn btn-success">
					<i class="ace-icon fa fa-signal"></i>
				</button>

				<button class="btn btn-info">
					<i class="ace-icon fa fa-pencil"></i>
				</button>

				<button class="btn btn-warning">
					<i class="ace-icon fa fa-users"></i>
				</button>

				<button class="btn btn-danger">
					<i class="ace-icon fa fa-cogs"></i>
				</button>
			</div>

			<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
				<span class="btn btn-success"></span>

				<span class="btn btn-info"></span>

				<span class="btn btn-warning"></span>

				<span class="btn btn-danger"></span>
			</div>
		</div><!-- /.sidebar-shortcuts -->
	

		<ul class="nav nav-list">
			<?php foreach ($permissions as $item):?>
				<?php if(in_array( $item['menu_id'], $auth ) || $auth[0] == '0'):?>
				<li <?php echo ($item['menu_id'] == $open_index) ? ' class="active open"' : ''; ?>>
					<a href="" class="dropdown-toggle">
						<i class="menu-icon fa fa-<?php echo $item['icon']?>"></i>
						<span class="menu-text"> <?php echo Yii::t('app', $item['role_name'])?> </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<?php foreach( $item['child'] as $res):?>
							<?php if(!isset($res['child'])): // 1?>
								<?php if(in_array( $res['menu_id'],$auth) || $auth[0] == '0'): ?>
								<li<?php echo ($res['method_name'] == $menu_type) ? ' class="active"' : ''; ?>>
									<a href="<?php echo Url::toRoute($res['controller_name'].'/'.$res['method_name'])?>">
										<i class="menu-icon fa fa-caret-right"></i>
										<?php echo Yii::t('app', $res['role_name'])?>
									</a>
									<b class="arrow"></b>
								</li>
								<?php endif;?>
							<?php else: ?>
								<?php if(in_array($res['menu_id'],$auth) || $auth[0] == '0'): //2?>
									<li <?php echo ($res['menu_id'] == $open_index2) ? ' class="active open"' : ''; ?>>
										<a href="" class="dropdown-toggle">
											<i class="menu-icon fa fa-caret-right"></i>
											<?php echo Yii::t('app', $res['role_name'])?>
											<b class="arrow fa fa-angle-down"></b>
										</a>
										<b class="arrow"></b>
										<ul class="submenu">
											<?php foreach($res['child'] as $row): ?>
												<?php if(!isset($row['childs'])):?>
													<?php if(in_array($row['menu_id'],$auth) || $auth[0] == '0'): //3?>
														<li <?php echo ($row['method_name'] == $menu_type) ? ' class="active"' : ''; ?> >
															<a href="<?php echo Url::toRoute($row['controller_name'].'/'.$row['method_name']); ?>">
																<i class="menu-icon fa fa-caret-right"></i>
																<?php echo Yii::t('app', $row['role_name'])?>
															</a>
															<b class="arrow"></b>
														</li>
													<?php endif;?>
	                                        	<?php else:?>
	                                        		<li <?php echo ($row['menu_id'] == $open_index3) ? ' class="active open"' : '';//2 ?>>
			                                    		<a href="" class="dropdown-toggle">
			                                        		<i class="menu-icon fa fa-caret-right"></i>
			                                        		<?php echo Yii::t('app', $row['role_name'])?>
			                                        		<b class="arrow fa fa-angle-down"></b>
			                                    		</a>
			                                    		<b class="arrow"></b>
			                                    		<ul class="submenu">
					                                        <?php foreach($row['childs'] as $vall): ?>
					                                        	<?php if(in_array($vall['menu_id'],$auth) || $auth[0] == '0'): //3?>
						                                        <li <?php echo ($vall['method_name'] == $menu_type) ? ' class="active open"' : ''; ?> >
						                                            <a href="<?php echo Url::toRoute($vall['controller_name'].'/'.$vall['method_name']); ?>">
						                                                <i class="menu-icon fa fa-caret-right"></i>
						                                                <?php echo Yii::t('app', $vall['role_name'])?>
						                                            </a>
						                                            <b class="arrow"></b>
						                                        </li>
					                                        	<?php endif;?>
					                                        <?php endforeach;?>
		                                        		</ul>
	                               					</li>
		                                        <?php endif;?>
	                                        <?php endforeach;?>
	                                    </ul>
	                                </li>
	                            <?php endif;?> 
	                        <?php endif;?>             
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endif;?>
			<?php endforeach;?>
		</ul><!-- /.nav-list -->
	
	
	
		<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
			<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
		</div>
	
	</div><!-- .sidebar end -->
	
	
	<div class="main-content">
		<div class="main-content-inner">
			<div class="breadcrumbs ace-save-state" id="breadcrumbs">
				<ul class="breadcrumb">
					<li>
						<i class="ace-icon fa fa-home home-icon"></i>
						<a href="<?php echo Url::to('/admin/index/index')?>"><?php echo Yii::t('app','首页')?></a>
					</li>
					
				</ul><!-- /.breadcrumb -->
			</div>
			
			
			<div class="page-content">
				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="ace-icon fa fa-cog bigger-130"></i>
					</div>
					
					<div class="ace-settings-box clearfix" id="ace-settings-box">
						<div class="pull-left width-50">
							<div class="ace-settings-item">
								<div class="pull-left">
									<select id="skin-colorpicker" class="hide">
										<option data-skin="no-skin" value="#438EB9">#438EB9</option>
										<option data-skin="skin-1" value="#222A2D">#222A2D</option>
										<option data-skin="skin-2" value="#C6487E">#C6487E</option>
										<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
									</select>
								</div>
								<span>&nbsp; Choose Skin</span>
							</div>
	
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
								<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
							</div>
	
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
								<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
							</div>
	
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
								<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
							</div>
	
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
								<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
							</div>
	
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
								<label class="lbl" for="ace-settings-add-container">
									Inside
									<b>.container</b>
								</label>
							</div>
						</div><!-- /.pull-left -->
						
						<div class="pull-left width-50">
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
								<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
							</div>

							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
								<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
							</div>

							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
								<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
							</div>
						</div><!-- /.pull-left -->
					</div><!-- /.ace-settings-box -->
				</div> <!-- ace-settings-container end -->
				
				<div class="row">
					<div class="col-xs-12">	
					<!-- PAGE CONTENT BEGINS -->
					
					
						<?= $content ?>
					
					
					
					<!-- PAGE CONTENT ENDS -->
					</div><!-- col -->
				</div><!-- row -->
			</div> <!-- page-content end-->
		</div><!-- .main-content-inner end -->
	</div><!-- .main-content end -->
	
	
	
	<div class="footer">
		<div class="footer-inner">
			<div class="footer-content">
				<span class="bigger-120">
					<span class="blue bolder">www.timestorm.cn</span>
					 &copy; 2016-2017
				</span>
			</div>
		</div>
	</div>
	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
	</a>
</div>


<?php $this->endBody() ?>
</body>
<!--[if IE]>
<script src="<?php echo $baseUrl?>js/jquery-1.11.3.min.js"></script>
<![endif]-->
<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo $baseUrl?>js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!--[if lte IE 8]>
  <script src="assets/js/excanvas.min.js"></script>
<![endif]-->


</html>

<?php 
$this->registerJs('
	
		
', \yii\web\View::POS_END);
?>


<?php $this->endPage() ?>