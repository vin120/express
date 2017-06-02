<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "修改密码");
?>


<div class="page-content">

	<div class="page-header">
		<h1>
			<?php echo Yii::t('app', '修改资料')?>
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				<?php echo Yii::t('app', '修改密码')?>
			</small>
		</h1>
	</div><!-- /.page-header -->
    
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-11">
		
		<?php 
			$form = ActiveForm::begin([
				'id'=>'edit',
				'method'=>'post',
				'options' =>['class'=> 'form-horizontal'],
				'enableClientValidation'=>false,
				'enableClientScript'=>false,
				'fieldConfig' => [
					'template' => '<div class="form-group"><label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">{label}</label><div class="col-xs-8 col-sm-8 col-md-7">{input}{error}</div></div>',
				],
			]);
		?>
		
			<?php echo $form->field($model, 'admin_password')->passwordInput(['class'=>'col-xs-10 col-sm-8 col-md-8','placeholder'=>Yii::t('app','请输入原密码')]);?>
			<?php echo $form->field($model, 'new_password')->passwordInput(['class'=>'col-xs-10 col-sm-8 col-md-8','placeholder'=>Yii::t('app','请输入新密码')]);?>	
			<?php echo $form->field($model, 're_password')->passwordInput(['class'=>'col-xs-10 col-sm-8 col-md-8','placeholder'=>Yii::t('app','请再次输入密码')]);?>		
			<?php echo Html::submitButton(Yii::t('app','提交'),['class'=>'btn btn-primary','id'=>'submit','style'=>'margin-left: 45%'])?>
			
		<?php ActiveForm::end();?>
		
		</div><!-- /.col-xs-12 -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

