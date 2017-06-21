<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "用户充值");
    
?>



	<div class="page-content">
        <div class="page-header">
            <h1>
                <?php echo yii::t('app', '用户管理')?>
                <small style="cursor:pointer">
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <a href="<?php echo Url::to("/admin/user/recharge")?>"><?php echo yii::t('app', '用户列表列表')?></a>
                </small>
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php echo yii::t('app', '用户充值')?>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-11">
	            <?php
					$form = ActiveForm::begin([
						'id'=>'edit',
						'action'=>'rechargeedit',
						'method'=>'post',
						'options' =>['class'=> 'form-horizontal','role'=>'form','autocomplete'=>'off'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false,
						'fieldConfig' => [
							'template' => '<div class="form-group"><label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">{label}</label><div class="col-xs-8 col-sm-8 col-md-7">{input}{error}</div></div>',
						],
					]);
				?>
				<?php echo $form->field($model, 'user_name')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'user_name','readonly'=>'readonly','name'=>'user_name','maxlength'=>'80','placeholder'=>Yii::t('app','用户姓名')]);?>
	 			<?php echo $form->field($model, 'user_phone')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'user_phone','name'=>'user_phone','readonly'=>'readonly','maxlength'=>'80','placeholder'=>Yii::t('app','用户手机')]);?>
				<?php echo $form->field($model, 'user_address')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'user_address','name'=>'user_address','readonly'=>'readonly','maxlength'=>'80','placeholder'=>Yii::t('app','用户地址')]);?>
				<?php echo $form->field($model, 'reg_time')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'reg_time','name'=>'reg_time','readonly'=>'readonly','maxlength'=>'80','placeholder'=>Yii::t('app','注册时间')]);?>
				<?php echo $form->field($model, 'money')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'money','name'=>'money','readonly'=>'readonly','maxlength'=>'80','placeholder'=>Yii::t('app','用户余额')]);?>
				<?php echo $form->field($model, 'recharge_money')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'recharge_money','name'=>'recharge_money','maxlength'=>'80','onKeypress'=>"return (/[\d.]/.test(String.fromCharCode(event.keyCode)))" ,'style'=>"ime-mode:Disabled",'placeholder'=>Yii::t('app','充值金额')]);?>
				
				<input type="hidden" value="<?php echo $id?>" name="edit_id2" />
         		<?php echo Html::submitButton(Yii::t('app','提交'),['class'=>'btn btn-primary','id'=>'submit','style'=>'margin-left: 45%'])?>
                <?php ActiveForm::end();?>
            </div><!-- /.col-xs-12 -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->