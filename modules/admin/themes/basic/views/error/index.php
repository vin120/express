<?php
	use yii\helpers\Url;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "错误");
 	

?>

<div class="page-content">

	<div class="page-header">
		<h1>
            <?php echo Yii::t('app', '错误')?>
            <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    <?php echo Yii::t('app', '禁止访问')?>
            </small>
        </h1>
    </div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<div class="error-container">
				<div class="well">
					<h1 class="grey lighter smaller">
						<span class="blue bigger-125">
							<i class="icon-sitemap"></i>
							<?php echo yii::t('app', '禁止访问')?>
						</span>
					</h1>
					<hr />
 					<div>
						<div class="space"></div>
						<ul class="list-unstyled spaced inline bigger-110 margin-15">
							<li>
								<?php echo yii::t('app', '服务器拒绝了你的请求')?>
							</li>
                          	<li>
                               	<?php echo yii::t('app', '请确认你拥有所需的访问权限')?>
							</li>
						</ul>
                    </div>
                     <hr />
                     <div class="space"></div>
					<div class="center">
						<a href="<?php echo Yii::$app->urlManager->createUrl('admin/index/index');?>" class="btn btn-primary">
							<i class="icon-dashboard"></i>
							<?php echo yii::t('app', '返回首页')?>
						</a>
					</div>
               	</div>
			</div><!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->


<?php 
$this->registerJs('

		
', \yii\web\View::POS_END);
?>

