<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    ThemeAsset::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
    $this->title = Yii::t("app", "登录");
?>

	<body class="login-layout" style="background-size:cover;background:url('<?php echo $baseUrl; ?>img/background.jpeg') repeat scroll 0 0 / cover  rgba(0, 0, 0, 0)">
		<div class="main-container" style="margin-top:30px;">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h2>
									<span class="black"><?php echo Yii::t('app', '后台管理系统'); ?></span>
								</h2>
							</div>
							
							<div class="space-6"></div>
							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<div class="lang" style="display: block; height: 100%; line-height: 100%; float: right">
												<a href="<?= Url::toRoute(['login/login','language'=>'en-US'])?>">En</a>
												<label>&nbsp;|&nbsp;</label>
												<a href="<?= Url::toRoute(['login/login','language'=>'zh-CN'])?>">中文</a>
											</div>
										
											<h4 class="header blue lighter bigger" style="margin-top: 9%">
												<i class="ace-icon fa fa-coffee green"></i>
												<?php echo Yii::t('app', '请输入你的用户名密码'); ?>
											</h4>

											<div class="space-6"></div>

											<?php
												$form = ActiveForm::begin([
													'id'=>'login-form',
													'action'=>'login',
													'method'=>'post',
										            'options' =>['class'=> 'login-form'],
													'enableClientValidation'=>false,
													'enableClientScript'=>false,
													'fieldConfig' => [
														'template' => '{input}{error}',		
													],
												]); 
											?>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
														<?php echo $form->field($model,'admin_name')->textInput(["class"=>"form-control","placeholder"=> Yii::t('app', '用户名')])?>
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<?php echo $form->field($model,'admin_password')->passwordInput(["class"=>"form-control","placeholder"=> Yii::t('app', '密码')])?>
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
														<?php echo $form->field($model, 'rememberMe')->checkbox(['class'=>'ace','template'=>'{input}<span class="lbl">'.Yii::t("app", "记住密码").'</span>'])?>															
														</label>
														<?php echo Html::submitButton('<i class="ace-icon fa fa-key"></i><span class="bigger-110">'.Yii::t("app", "登录").'</span>',["class"=>"width-35 pull-right btn btn-sm btn-primary"])?>														
													</div>
													
													<div class="space-4"></div>
													
												</fieldset>
											<?php ActiveForm::end();?>
										</div><!-- /.widget-main -->
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->
							</div><!-- /.position-relative -->
						
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->
	</body>
	
	
	<?php 
	$this->registerJs('
		$("#login-btn").on("click",function(){
			$("#login-form").submit();
		});
			
	', \yii\web\View::POS_END);
	?>
