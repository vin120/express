<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\admin\themes\basic\assets\ThemeAsset;
use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
ThemeAsset::register($this);
ThemeAssetExtra::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
$this->title = Yii::t("app", "货物信息");

?>

	<div class="page-content">
        <div class="page-header">
            <h1>
                <?php echo yii::t('app', '货物管理')?>
                <small style="cursor:pointer">
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <a href="<?php echo Url::to("/admin/store/zhstore")?>"><?php echo yii::t('app', '珠海收货地址')?></a>
                </small>
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php echo yii::t('app', '编辑收货地址')?>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-11">
	            <?php
					$form = ActiveForm::begin([
						'id'=>'edit',
						'action'=>'zhstoreedit',
						'method'=>'post',
						'options' =>['class'=> 'form-horizontal','autocomplete'=>'off','enctype'=>'multipart/form-data'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false,
						'fieldConfig' => [
							'template' => '<div class="form-group"><label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">{label}</label><div class="col-xs-8 col-sm-8 col-md-7">{input}{error}</div></div>',
						],
					]);
				?>
				
				<?php echo $form->field($model, 'zhstore_name')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'zhstore_name','name'=>'zhstore_name','maxlength'=>'80','placeholder'=>Yii::t('app','店名')]);?>
	 			<?php echo $form->field($model, 'zhstore_phone')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'zhstore_phone','name'=>'zhstore_phone','maxlength'=>'80','placeholder'=>Yii::t('app','电话')]);?>
	 			<?php echo $form->field($model, 'zhstore_area')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'zhstore_area','name'=>'zhstore_area','maxlength'=>'80','placeholder'=>Yii::t('app','所在区域')]);?>
	 			<?php echo $form->field($model, 'zhstore_street')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'zhstore_street','name'=>'zhstore_street','maxlength'=>'80','placeholder'=>Yii::t('app','街道')]);?>
				<?php echo $form->field($model, 'zhstore_address')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'zhstore_address','name'=>'zhstore_address','maxlength'=>'80','placeholder'=>Yii::t('app','详细地址')]);?>
				
				<div class="form-group">
					<label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo Yii::t('app', 'logo图')?>：</label>
					<img src="<?php echo Yii::$app->params['img_url'].'/'.$model['zhstore_logo'];?>" width="180" height="100"/>
					<div class="col-xs-12 col-sm-4">
						<input type="file" id="zhstore_logo" name="zhstore_logo" />
					</div>
				</div>
				
					
				
				<?php echo $form->field($model, 'zhstore_status')->checkbox([
						'class'=>'ace ace-switch ace-switch-5',
						'name'=>'zhstore_status','id'=>'id-button-borders',
						'template'=>'<label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">'. Yii::t("app", "状态").'：</label><label style="margin-left: 10px;">{input}<span class="lbl"></span></label>',
					]);
				?>
				<input type="hidden" value="<?php echo $id?>" name="edit_id2" />
         		<?php echo Html::submitButton(Yii::t('app','提交'),['class'=>'btn btn-primary','id'=>'submit','style'=>'margin-left: 45%'])?>
                <?php ActiveForm::end();?>
            </div><!-- /.col-xs-12 -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
    
    													
<script type="text/javascript">
<?php $this->beginBlock('js_end') ?>

jQuery(function($) {

	$('#zhstore_logo').ace_file_input({
		style:'well',
		btn_choose:'选择logo图',
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