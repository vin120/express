<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "编辑管理员");
?>

<div class="page-content">
        <div class="page-header">
            <h1>
                <?php echo yii::t('app', '权限管理')?>
                <small style="cursor:pointer">
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <a href="<?php echo Url::to("/admin/auth/admin")?>"><?php echo yii::t('app', '管理员列表')?></a>
                </small>
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php echo yii::t('app', '编辑管理员')?>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-11">
	            <?php
					$form = ActiveForm::begin([
						'id'=>'edit',
						'action'=>'adminedit',
						'method'=>'post',
						'options' =>['class'=> 'form-horizontal','role'=>'form','autocomplete'=>'off'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false,
						'fieldConfig' => [
							'template' => '<div class="form-group"><label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">{label}</label><div class="col-xs-8 col-sm-8 col-md-7">{input}{error}</div></div>',
						],
					]);
				?>
				<?php echo $form->field($model, 'admin_name')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'admin_name','name'=>'admin_name','maxlength'=>'80','placeholder'=>Yii::t('app','管理员账号')]);?>
	 			<?php echo $form->field($model, 'admin_real_name')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'admin_real_name','name'=>'admin_real_name','maxlength'=>'80','placeholder'=>Yii::t('app','管理员昵称')]);?>
				<?php echo $form->field($model, 'admin_status')->checkbox([
						'class'=>'ace ace-switch ace-switch-5',
						'name'=>'admin_status','id'=>'id-button-borders',
						'template'=>'<label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">'. Yii::t("app", "状态").'：</label><label style="margin-left: 10px;">{input}<span class="lbl"></span></label>',
					]);
				?>
				<?php echo $form->field($model,'role_id')->dropDownList($role,['class'=>'col-xs-10 col-sm-8 col-md-8" id="form-field-select-1','name'=>'role_id'])?>
				<input type="hidden" value="<?php echo $id?>" name="edit_id2" />
         		<?php echo Html::submitButton(Yii::t('app','提交'),['class'=>'btn btn-primary','id'=>'submit','style'=>'margin-left: 45%'])?>
                <a href="<?php echo Url::to("/admin/auth/resetpassword?id={$id}");?>" class="reset btn btn-warning"><?php echo yii::t('app', '重设密码')?></a>
                <?php ActiveForm::end();?>
            </div><!-- /.col-xs-12 -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div><!-- /.main-content -->