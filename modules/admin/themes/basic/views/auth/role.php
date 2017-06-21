<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "权限分组列表");
?>


<div class="page-content">

    <div class="page-header">
        <h1>
            <?php echo Yii::t('app', '权限管理')?>
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <?php echo Yii::t('app', '权限分组列表')?>
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
							'id'=>'del',
		                    'method'=>'post',
							'options' =>['name'=> 'del'],
		                    'enableClientValidation'=>false,
		                    'enableClientScript'=>false,
                    	]);
                    ?>
					<table id="sample-table-1" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 5%"><?php echo Yii::t('app', '序号')?></th>
								<th><?php echo Yii::t('app', '分组名')?></th>
								<th><?php echo Yii::t('app', '分组说明')?></th>
								<th style="width: 5%"><?php echo Yii::t('app', '状态')?></th>
								<th style="width: 7%"><?php echo Yii::t('app', '操作')?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($role as $key=>$row) : ?>
							<tr>
								<td><?php echo ++$key;?></td>
								<td><?php echo $row['role_name'];?></td>
								<td><?php echo $row['role_desc'];?></td>
								<td><?php echo $row['role_status']? Yii::t('app', '启用'): Yii::t('app', '禁用');?></td>
								<td>
									<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                        
										<?php if($can['edit']):?>
											<a href="#" id="<?php echo $row['role_id'];?>" class="edit btn btn-xs btn-info" title="<?php echo Yii::t('app', '编辑');?>">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</a>
											<?php endif; ?>
                                            
											<?php if($can['delete']):?>
												<a href="#" class="btn btn-xs btn-warning delete" id="<?php echo $row['role_id'];?>" title="<?php echo Yii::t('app', '删除');?>">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
											<?php endif; ?>
										</div>
                                        
                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="inline position-relative">
                                                <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                                    <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                
                                                    <?php if($can['edit']):?>
	                                                    <li>
	                                                        <a href="#" id="<?php echo $row['role_id'];?>" class="edit tooltip-info" data-rel="tooltip" title="<?php echo Yii::t('app', '编辑');?>">
	                                                            <span class="green">
	                                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
	                                                            </span>
	                                                        </a>
	                                                    </li>
                                                    <?php endif; ?>
                                                    
                                                    
                                                    <?php if($can['delete']):?>
	                                                    <li>
	                                                        <a href="#" class="tooltip-info delete" id="<?php echo $row['role_id'];?>" data-rel="tooltip" title="<?php echo Yii::t('app', '删除');?>">
	                                                            <span class="red">
	                                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
	                                                            </span>
	                                                        </a>
	                                                    </li>
                                                    <?php endif; ?>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                      
                        <?php ActiveForm::end();?>
                        
                        <div class="center">
                            <?php if($can['add']):?>
                            <a href="<?php echo Url::to('/admin/auth/roleadd');?>" class="btn btn-xs">
                                <i class="icon-pencil align-top bigger-125"></i>
                                <span class="bigger-110 no-text-shadow"><?php echo Yii::t('app', Yii::t('app', '添加'))?></span>
                            </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="center">
                        <?php echo yii\widgets\LinkPager::widget([
	                        'pagination' => $pager,
                        	'firstPageLabel' => Yii::t('app', '首页'),
                        	'lastPageLabel'  => Yii::t('app', '尾页'),
                        	'prevPageLabel'  => '«',
                        	'nextPageLabel'  => '»',
	                   
	                    ]);?>
                        </div>
                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->


<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110" id="dialog-confirm-content">
		<?php echo yii::t('app', '这条记录将被永久删除，并且无法恢复.')?>
	</div>
	<div class="space-6"></div>
	<p class="bigger-110 bolder center grey" id="confirm">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		<?php echo yii::t('app', '确定吗?')?>
	</p>
</div><!-- #dialog-confirm -->


<!-- 编辑 -->
 <?php 
	$form = ActiveForm::begin([
		'action'=> Url::to('/admin/auth/roleedit'),
		'method'=>'post',
		'enableClientValidation'=>false,
		'enableClientScript'=>false,
	]);
?>
<input type="hidden" name="edit_id" value="" id="sendtoedit"/>
<?php ActiveForm::end();?>

											
													
<script type="text/javascript">
<?php $this->beginBlock('js_end') ?>

jQuery(function($) {
		
	$(".edit").click(function(){
		var $b = $(this).attr("id");
		$("#sendtoedit").val($b);
		jQuery("form").last().submit();
	});
		


	$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
		_title: function(title) {
			var $title = this.options.title || '&nbsp;'
			if( ("title_html" in this.options) && this.options.title_html == true )
				title.html($title);
			else title.text($title);
		}
	}));

	
	$(".delete" ).on("click", function(e) {
		var $a = $(this).attr("id");
		var $_csrf = '<?php echo Yii::$app->request->csrfToken?>';
		e.preventDefault();
		$.post("checkadmin",{id:$a,_csrf:$_csrf},function(data){
			if(data > 0){
				$('#danger').hide();
				$('.widget-header h4').html("<i class='ace-icon fa fa-exclamation-triangle red'></i><?php echo Yii::t('app', '不能删除！')?>");
				$('#dialog-confirm-content').html("<?php echo yii::t('app', '这个权限分组有管理员正在使用，不能删除。')?>");
				$('#confirm').hide();
			}
		});


		$("#dialog-confirm" ).removeClass('hide').dialog({
			closeOnEscape:false, 
			resizable: false,
			modal: true,
			open:function(event,ui){$(".ui-dialog-titlebar-close").hide();} ,
			title:"<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i><?php echo Yii::t('app', '删除这条记录？')?></h4></div>",
			title_html: true,
			buttons: [{
				html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; <?php echo Yii::t('app', '删除？')?>",
				"class" : "btn btn-danger btn-minier ",
				"id" : "danger",
				click: function() {
					location.href="<?php echo Url::to("/admin/auth/roledelete");?>"+"?id="+$a;
					$( this ).dialog( "close" );
				}},
				{
					html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; <?php echo Yii::t('app', '取消？')?>",
					"class" : "btn btn-minier ",
					click: function() {
						$( this ).dialog( "close" );
					}
				}]
		});
		
		$('.widget-header h4').html("<i class='ace-icon fa fa-exclamation-triangle red'></i><?php echo Yii::t('app', '删除这条记录？')?>");
		$('#dialog-confirm-content').html("<?php echo Yii::t('app', '这条记录将被永久删除，并且无法恢复。')?>");
		$('#confirm').show();
	});

		
});
		

	
<?php $this->endBlock() ?>
</script>
	
	
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_END); ?>
