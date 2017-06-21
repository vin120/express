<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\modules\admin\themes\basic\assets\ThemeAsset;
    use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
    ThemeAsset::register($this);
    ThemeAssetExtra::register($this);
    $baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';   
    $this->title = Yii::t("app", "用户列表");
    
?>



<div class="page-content">
	<div class="page-header">
		<h1>
			<?php echo yii::t('app', '用户管理')?>
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				<?php echo yii::t('app', '用户列表')?>
			</small>
		</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<style>
					.nav-search{position:relative;margin-top:15px;margin-left:25px;margin-bottom:20px;}
				</style>
				<div class="col-xs-12">
					<div class="table-responsive">
						<div class="nav-search" id="nav-search">
						<?php
							$form = ActiveForm::begin([
								'method'=>'post',
								'enableClientValidation'=>false,
								'enableClientScript'=>false
							]); 
						?>
							<div class="form-search">
								<span class="input-icon">
									<input type="text" name="search" placeholder="姓名或手机..." style="height:30px" class="nav-search-input" id="nav-search-input" autocomplete="off"  value="<?php echo $search?>"/>
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
								<input type="submit" class="btn btn-white btn-primary" style="margin-left: 20px" value="搜索">
							</div>
						<?php ActiveForm::end();?>
						</div><!-- /.nav-search -->
					<?php 
						$form = ActiveForm::begin([
							'method'=>'post',
							'options' =>['name'=> 'del'],
							'enableClientValidation'=>false,
							'enableClientScript'=>false,
						]);
                    ?>
						<table id="sample-table-1" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th style="width: 5%"><?php echo yii::t('app', '序号')?></th>
									<th><?php echo yii::t('app', '用户姓名')?></th>
									<th><?php echo yii::t('app', '用户手机')?></th>
									<th><?php echo yii::t('app', '注册时间')?></th>
									<th style="width: 5%"><?php echo yii::t('app', '状态')?></th>
									<th style="width: 7%"><?php echo yii::t('app', '操作')?></th>
								</tr>
							</thead>
                            <tbody>
                                <?php foreach ($user as $key=>$row) : ?>
                                <tr>
                                    <td><?php echo ++$key;?></td>
                                    <td><?php echo $row['user_name'];?></td>
                                    <td><?php echo $row['user_phone'];?></td>
                                    <td><?php echo $row['reg_time'];?></td>
                                    <td><?php echo $row['user_status']? yii::t('app', '启用'): yii::t('app', '禁用');?></td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                        
                                            <?php if($can['edit']):?>
                                            <a href="#" id="<?php echo $row['user_id'];?>" class="edit btn btn-xs btn-info" title="<?php echo yii::t('app', '编辑');?>">
                                                <i class="ace-icon fa fa-pencil bigger-120"></i>
                                            </a>
                                            <?php endif; ?>
                                            
                                            
                                            <?php if($can['delete']):?>
                                            <a href="#" class="btn btn-xs btn-warning delete" id="<?php echo $row['user_id'];?>" title="<?php echo yii::t('app', '删除');?>">
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
                                                        <a href="#" id="<?php echo $row['user_id'];?>" class="edit tooltip-info" data-rel="tooltip" title="<?php echo yii::t('app', '编辑');?>">
                                                            <span class="green">
                                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <?php endif; ?>
                                                    
                                                    
                                                    <?php if($can['delete']):?>
                                                    <li>
                                                        <a href="#" class="tooltip-info delete" id="<?php echo $row['user_id'];?>" data-rel="tooltip" title="<?php echo yii::t('app', '删除');?>">
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
                            <a href="<?php echo Url::to('/admin/user/useradd');?>" class="btn btn-xs">
                                <i class="icon-pencil align-top bigger-125"></i>
                                <span class="bigger-110 no-text-shadow"><?php echo yii::t('app', yii::t('app', '添加'))?></span>
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


<!-- 编辑 -->
 <?php 
	$form = ActiveForm::begin([
		'action'=> Url::to('/admin/user/useredit'),
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
	
});

<?php $this->endBlock() ?>
</script>	
	
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_END); ?>

