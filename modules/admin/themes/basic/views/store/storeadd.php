<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "门店信息");
    
?>

	<div class="page-content">
        <div class="page-header">
            <h1>
                <?php echo yii::t('app', '门店管理')?>
                <small style="cursor:pointer">
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <a href="<?php echo Url::to("/admin/store/store")?>"><?php echo yii::t('app', '门店信息')?></a>
                </small>
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php echo yii::t('app', '添加门店')?>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-11">
	            <?php
					$form = ActiveForm::begin([
						'id'=>'edit',
						'action'=>'storeadd',
						'method'=>'post',
						'options' =>['class'=> 'form-horizontal','autocomplete'=>'off','enctype'=>'multipart/form-data'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false,
						'fieldConfig' => [
							'template' => '<div class="form-group"><label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">{label}</label><div class="col-xs-8 col-sm-8 col-md-7">{input}{error}</div></div>',
						],
					]);
				?>
				<?php echo $form->field($model, 'store_name')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'store_name','name'=>'store_name','maxlength'=>'80','placeholder'=>Yii::t('app','店名')]);?>
	 			<?php echo $form->field($model, 'store_phone')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'store_phone','name'=>'store_phone','maxlength'=>'80','placeholder'=>Yii::t('app','电话')]);?>
				<?php echo $form->field($model, 'store_address')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'store_address','name'=>'store_address','maxlength'=>'80','placeholder'=>Yii::t('app','地址')]);?>
				<?php echo $form->field($model, 'store_work_time')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'store_work_time','name'=>'store_work_time','maxlength'=>'80','placeholder'=>Yii::t('app','营业时间')]);?>
				
				<div class="form-group">
					<label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">logo图：</label>
					<div class="col-xs-12 col-sm-4">
						<input type="file" id="store_logo" name="store_logo" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">logo图：</label>
					<div class="col-xs-12 col-sm-4">
						<input type="file" id="store_map" name="store_map" />
					</div>
				</div>
			
				<div class="form-group">
					<label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">logo图：</label>
					<div class="col-xs-12 col-sm-4">
						<input type="file" id="store_pic" name="store_pic" />
					</div>
				</div>
					
				
				<?php echo $form->field($model, 'store_status')->checkbox([
						'class'=>'ace ace-switch ace-switch-5',
						'name'=>'store_status','id'=>'id-button-borders',
						'template'=>'<label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">'. Yii::t("app", "状态").'：</label><label style="margin-left: 10px;">{input}<span class="lbl"></span></label>',
					]);
				?>
				
         		<?php echo Html::submitButton(Yii::t('app','提交'),['class'=>'btn btn-primary','id'=>'submit','style'=>'margin-left: 45%'])?>
                <?php ActiveForm::end();?>
            </div><!-- /.col-xs-12 -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
    
    													
<script type="text/javascript">
<?php $this->beginBlock('js_end') ?>

jQuery(function($) {

	$('#store_logo').ace_file_input({
		style:'well',
		btn_choose:'选择logo图',
		btn_change:null,
		no_icon:'ace-icon fa fa-picture-o',
		thumbnail:'large',
		droppable:true,
		
		allowExt: ['jpg', 'jpeg', 'png', 'gif'],
		allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
	})


	$('#store_map').ace_file_input({
		style:'well',
		btn_choose:'选择地图',
		btn_change:null,
		no_icon:'ace-icon fa fa-picture-o',
		thumbnail:'large',
		droppable:true,
		
		allowExt: ['jpg', 'jpeg', 'png', 'gif'],
		allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
	})

	$('#store_pic').ace_file_input({
		style:'well',
		btn_choose:'选择布局图',
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