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
$this->title = Yii::t("app", "货物管理");

?>

	<div class="page-content">
        <div class="page-header">
            <h1>
                <?php echo yii::t('app', '货物管理')?>
                <small style="cursor:pointer">
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <a href="<?php echo Url::to("/admin/store/news")?>"><?php echo yii::t('app', '公告讯息')?></a>
                </small>
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php echo yii::t('app', '添加公告讯息')?>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-11">
	            <?php
					$form = ActiveForm::begin([
						'id'=>'edit',
						'action'=>'newsadd',
						'method'=>'post',
						'options' =>['class'=> 'form-horizontal','autocomplete'=>'off','enctype'=>'multipart/form-data'],
						'enableClientValidation'=>false,
						'enableClientScript'=>false,
						'fieldConfig' => [
							'template' => '<div class="form-group"><label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">{label}</label><div class="col-xs-8 col-sm-8 col-md-7">{input}{error}</div></div>',
						],
					]);
				?>
				<?php echo $form->field($model, 'news_title')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'news_title','name'=>'news_title','maxlength'=>'80','placeholder'=>Yii::t('app','标题')]);?>
	 			
				<?php echo $form->field($model, 'news_content')->textarea(['class'=>'col-xs-10 col-sm-8 col-md-8','id'=>'news_content','name'=>'news_content','style'=>'display: inline-block; width: 50%; vertical-align: top;margin-bottom:50px','placeholder'=>Yii::t('app','内容')]);?>
				
				<?php echo $form->field($model, 'news_status')->checkbox([
						'class'=>'ace ace-switch ace-switch-5',
						'name'=>'news_status','id'=>'id-button-borders',
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

	UE.getEditor('news_content');
});

<?php $this->endBlock() ?>
</script>	
	
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_END); ?>