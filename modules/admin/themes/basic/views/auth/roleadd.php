<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "添加权限分组");
?>


<div class="page-content">
	<div class="page-header">
		<h1>
			<?php echo yii::t('app', '权限管理')?>
			<small style="cursor:pointer">
				<i class="ace-icon fa fa-angle-double-right"></i>
				<a href="<?php echo Url::to("/admin/auth/role")?>"><?php echo yii::t('app', '权限分组列表')?></a>
			</small>
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				<?php echo yii::t('app', '添加权限分组')?>
			</small>
		</h1>
	</div><!-- /.page-header -->
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-11">
		<?php
			$form = ActiveForm::begin([
				'id'=>'add',
				'action'=>'roleadd',
				'method'=>'post',
				'options' =>['class'=> 'form-horizontal','role'=>'form'],
				'enableClientValidation'=>false,
				'enableClientScript'=>false,
				'fieldConfig' => [
					'template' => '<div class="form-group"><label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">{label}</label><div class="col-xs-8 col-sm-8 col-md-7">{input}{error}</div></div>',
				],
			]);
		?>
	     
		<?php echo $form->field($model, 'role_name')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','name'=>'role_name','id'=>'role','maxlength'=>'80','placeholder'=>Yii::t('app','分组名')]);?>
		
		<?php echo $form->field($model, 'role_status')->checkbox([
				'class'=>'ace ace-switch ace-switch-5',
				'name'=>'role_status','value'=>'1','id'=>'id-button-borders',
				'template'=>'<label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right">'. Yii::t("app", "状态").'：</label><label style="margin-left: 10px;">{input}<span class="lbl"></span></label>',
			]);
		?>
		<?php echo $form->field($model, 'role_desc')->textInput(['class'=>'col-xs-10 col-sm-8 col-md-8','name'=>'role_desc','id'=>'describe','maxlength'=>'80','placeholder'=>Yii::t('app','分组说明')]);?>
		

            <div class="form-group">
                <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('app', '分配权限')?>：</label>
                <div class="widget-box transparent col-xs-8 col-sm-8 col-md-8">
                    <div class="widget-body">
                        <div class="widget-main padding-8">
                            <div id="treeview" class="tree"></div>
                             <div class="hr"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $form->field($model, 'hidden')->textInput()->hiddenInput(['id'=>'hidden','name'=>'hidden'])->label(false);?>
         	<?php echo Html::submitButton(Yii::t('app','提交'),['class'=>'btn btn-primary','id'=>'submit','style'=>'margin-left: 45%'])?>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>

<script type="text/javascript">
<?php $this->beginBlock('js_end') ?>

	jQuery(function($){
		
		var remoteUrl = "menupermission";
		var csrfToken = '<?php echo Yii::$app->request->csrfToken?>';
		var remoteDataSource = function(options, callback){
			var parent_id = null
			if(!("text" in options) && !("type" in options)){
				parent_id = 0;//load first level data
			}
			else if("type" in options && options.type == "folder") {	//it has children
				if("additionalParameters" in options && "children" in options.additionalParameters)
					parent_id = options.additionalParameters["id"]
				else $data = {}//no data
			}
			if(parent_id != null) {
				$.ajax({
					url : remoteUrl,
					data: {id:parent_id,_csrf:csrfToken},
					type : "post",
					dataType : "json",
					success : function(response) {
						if(response.status == "OK"){
							callback({data : response.data});
						}
					},
					error : function(response) {
						console.log(response);
					}
				});
			}
		}
			
			
		$("#treeview").ace_tree({
			dataSource : remoteDataSource ,
			multiSelect : true,
			loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div> ',
			"open-icon" : "ace-icon tree-minus",
			"close-icon" : "ace-icon tree-plus",
			"selectable" : true,
			"selected-icon" : "ace-icon fa fa-check",
			"unselected-icon" : "ace-icon fa fa-times",
			cacheItems: true,
			folderSelect: false,
		});	
			
			
		$("#submit").on("click" , function(){
			var output = "";
			var show = "";
			var items = $("#treeview").tree("selectedItems");
			for(var i in items) if(items.hasOwnProperty(i)) {
				var item = items[i];
				output += item.additionalParameters["id"]+",";
				show += item.additionalParameters["id"]+":"+item.text+"\n";
			}
			$("#hidden").val(output);
	        $("#modal-tree-items").modal("show");
	        $("#tree-value").css({"width":"98%", "height":"200px"}).val(show);
			
		});
		if(location.protocol == 'file:') alert("For retrieving data from server, you should access this page using a webserver.");
	});	
		
	
<?php $this->endBlock() ?>
</script>
	
	
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_END); ?>






