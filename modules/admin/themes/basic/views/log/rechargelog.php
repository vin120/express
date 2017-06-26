<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\modules\admin\themes\basic\assets\ThemeAsset;
use app\modules\admin\themes\basic\assets\ThemeAssetExtra;
ThemeAsset::register($this);
ThemeAssetExtra::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
$this->title = Yii::t("app", "充值流水");

?>



<div class="page-content">
	<div class="page-header">
		<h1>
			<?php echo yii::t('app', '流水管理')?>
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				<?php echo yii::t('app', '充值流水')?>
			</small>
		</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
				<style>
					.list_select_option{margin-bottom:10px;}
					.admin_select{margin-left:20px;width:100px;}
				</style>
					<div class="table-responsive">
					
					<?php if(Yii::$app->admin->identity->admin_type != 0):?>
						<div class="list_select_option">
							 <label><?php echo yii::t('app', '请选择管理员')?>:</label>
							 <select class='admin_select' name='admin_select'>
							 	<?php $path_url = Url::to(['/admin/log/rechargelog','admin_id'=>0]);?>
							 	<option value="<?php echo $path_url;?>" <?php if($admin_id == 0) echo "selected";?>><?php echo yii::t('app', '全部')?></option>
							 	<?php foreach($admin as $row):?>
							 		<?php $path_url = Url::to(['/admin/log/rechargelog','admin_id'=>$row['admin_id']]);?>
							 		<option value="<?php echo $path_url;?>" <?php if($row['admin_id'] == $admin_id) echo "selected";?>><?php echo $row['admin_name']?></option>
							 	<?php endforeach;?>
							 </select>
						</div>
					<?php endif;?>
						<table id="sample-table-1" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th style="width: 5%"><?php echo yii::t('app', '序号')?></th>
									<th><?php echo yii::t('app', '管理员')?></th>
									<th><?php echo yii::t('app', '用户姓名')?></th>
									<th><?php echo yii::t('app', '用户手机')?></th>
									<th><?php echo yii::t('app', '充值额度')?></th>
									<th><?php echo yii::t('app', '充值时间')?></th>
								</tr>
							</thead>
                            <tbody>
							<?php foreach ($rechargelog as $key => $row):?>
                                <tr>
                                	<td><?php echo ++$key?></td>
                                	<td><?php echo $row['admin_name']?></td>
                                	<td><?php echo $row['user_name']?></td>
                                	<td><?php echo $row['user_phone']?></td>
                                	<td><?php echo $row['money']?></td>
                                	<td><?php echo $row['recharge_time']?></td>
                                </tr>
							<?php endforeach;?>
                            </tbody>
                        </table>
                        
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

	
														
<script type="text/javascript">
<?php $this->beginBlock('js_end') ?>

jQuery(function($) {


	$(".list_select_option select[name='admin_select']").change(function(){
    	var path = $(this).val();
		window.location.href=path;
	});






	
});

<?php $this->endBlock() ?>
</script>	
	
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_END); ?>

	