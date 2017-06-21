<?php 
	use yii\helpers\Html;
	use app\modules\admin\themes\basic\assets\ThemeAsset;
	$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8">
	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="User login page" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	
	<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo $baseUrl?>css/ace-part2.min.css" />
	<![endif]-->
	
	<!--[if lte IE 9]>
	  <link rel="stylesheet" href="<?php echo $baseUrl?>css/ace-ie.min.css" />
	<![endif]-->
	
	
	<!--[if lte IE 8]>
	<script src="<?php echo $baseUrl?>js/html5shiv.min.js"></script>
	<script src="<?php echo $baseUrl?>js/respond.min.js"></script>
	<![endif]-->
	
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>