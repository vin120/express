<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    use app\modules\admin\themes\basic\assets\ThemeAssetUeditor;
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    ThemeAssetUeditor::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "免责声明");
    
?>




<div class="page-content">
	<div class="page-header">
		<h1>
			<?php echo yii::t('app', '权限管理')?>
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				<?php echo yii::t('app', '管理员列表')?>
			</small>
		</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
					<?php
						$form = ActiveForm::begin([
							'id'=>'edit',
							'action'=>'disclaimer',
							'method'=>'post',
							'options' =>['class' => 'disclarimer_form','enctype'=>'multipart/form-data'],
							'enableClientValidation'=>false,
							'enableClientScript'=>false,
							'fieldConfig' => [
									'template' => '<div class="form-group"><label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">{label}</label><div class="col-xs-8 col-sm-8 col-md-7">{input}</div></div>{error}',
							],
						]);
					?>
					
					
					<?php echo $form->field($model, 'disclaimer_content')->textarea(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'disclaimer_content','name'=>'disclaimer_content','style'=>'display: inline-block; width: 50%; vertical-align: top;margin-bottom:50px','placeholder'=>Yii::t('app','免责声明内容')]);?>
					
					<?php echo Html::submitButton(Yii::t('app','提交'),['class'=>'btn btn-primary','id'=>'submit','style'=>'margin-left: 45%'])?>
					<?php ActiveForm::end();?>
                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

													
<script type="text/javascript">
<?php $this->beginBlock('js_end') ?>

jQuery(function($) {


	UE.getEditor('disclaimer_content');



	
});

<?php $this->endBlock() ?>
</script>	
	
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_END); ?>
