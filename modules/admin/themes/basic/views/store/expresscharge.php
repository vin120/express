<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "货运收费");
    
?>



	<div class="page-content">
        <div class="page-header">
            <h1>
                <?php echo yii::t('app', '门店管理')?>
               <small>
					<i class="ace-icon fa fa-angle-double-right"></i>
					<?php echo yii::t('app', '货运收费')?>
				</small>
               
            </h1>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-11">
	            <?php
					$form = ActiveForm::begin([
						'id'=>'edit',
						'action'=>'expresscharge',
						'method'=>'post',
						'options' =>['class'=> 'form-horizontal','autocomplete'=>'off','enctype'=>'multipart/form-data'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false,
						'fieldConfig' => [
							'template' => '<div class="form-group"><label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">{label}</label><div class="col-xs-8 col-sm-8 col-md-7">{input}{error}</div></div>',
						],
					]);
				?>
				
				
				<div class="form-group">
					<label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo Yii::t('app', '收费图')?>：</label>
					<img src="<?php echo Yii::$app->params['img_url'].'/'.$model['img_url'];?>" width="180" height="100"/>
					<div class="col-xs-12 col-sm-4">
						<input type="file" id="img_url" name="img_url" />
					</div>
				</div>
					
         		<?php echo Html::submitButton(Yii::t('app','提交'),['class'=>'btn btn-primary','id'=>'submit','style'=>'margin-left: 45%'])?>
                <?php ActiveForm::end();?>
            </div><!-- /.col-xs-12 -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
    
    													
<script type="text/javascript">
<?php $this->beginBlock('js_end') ?>

jQuery(function($) {

	$('#img_url').ace_file_input({
		style:'well',
		btn_choose:'选择收费图',
		btn_change:null,
		no_icon:'ace-icon fa fa-picture-o',
		thumbnail:'large',
		droppable:true,
		
		allowExt: ['jpg', 'jpeg', 'png', 'gif'],
		allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
	})
});

<?php $this->endBlock() ?>
</script>	
	
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_END); ?>