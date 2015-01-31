<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title><?php
		if(is_array($this->breadcrumbs)){
			foreach (array_reverse($this->breadcrumbs) as $key => $value) {
				$title[]=(is_string($key) ? $key :  $value);
			}
		}
		echo $title ? CHtml::encode(implode(' - ',$title)) : Yii::app()->params['siteName'];
	?></title>
	<link rel="stylesheet" href="/css/admin/admin.css" />
	<script type="text/javascript" src="/js/admin.js"></script>
	<style type="text/css">
		.view{
			margin: 10px; padding: 7px;
		}
		.sub {
			padding: 3px 0 3px 30px !important;
		}
		.ui-datepicker-div{
			z-index: 100;
		}
		.checkbox-list label{
			display: inline-block;
		}
	</style>
	<link href="/images/favicon.png" rel="shortcut icon" type="image/x-icon" />
</head>
<body style="padding-top: 5px;">
	<div id="wrapper" class="container">
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
				'brand'=>CHtml::encode(Yii::app()->params['siteName']),
				'fixed' => false,
				//'type'=>'inverse',
				'items'=>array(
					array(
						'class'=>'bootstrap.widgets.TbMenu',
						'htmlOptions'=>array('class'=>'pull-right'),
						'items' => array(
							//array('label'=>'Сайт', 'url'=>'/'),
							array('label'=>'Панель администратора', 'url'=>array('/admin'), 'visible' => !Yii::app()->user->isGuest,'active'=>true),
							array(
								'label' => !Yii::app()->user->isGuest ?
									(isset(Yii::app()->user->login) ? Yii::app()->user->login : (isset(Yii::app()->user->email) ? Yii::app()->user->email : '')) :
									'',
								'visible' => !Yii::app()->user->isGuest,
								'items' => array(
									array('label' => 'Смена пароля', 'url'=>'/admin/admin_users/passchange', 'active' => Yii::app()->controller->id=='users' && Yii::app()->controller->action->id=='passchange'),
									array('label' => 'Выход', 'url' => array('/admin/login/logout'), 'visible' => !Yii::app()->user->isGuest)
								)
							),
							array('label' => 'Вход', 'url' => array('/admin/login'), 'visible' => Yii::app()->user->isGuest && Yii::app()->controller->module->id<>'install'),
						),
					),
				),
		   )); ?>

		<div class="row">
			<div class='span12'>
				 <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
					'homeLink' => CHtml::link(Yii::app()->params['siteName'], '/'),
					'links' => $this->breadcrumbs,
			   ));?>
			</div>

			<?php
						$flashMessages = Yii::app()->user->getFlashes();
						if ($flashMessages) {
							echo '<div class="span9"><div class="flash-messages">';
							foreach ($flashMessages as $key => $message) {
								echo '<div class="alert alert-' . $key . '">' . "
			<a class='close' data-dismiss='alert'>×</a>
			{$message}
			</div>\n";
							}
							echo '</div></div>';
						}
						?>

			<?php echo $content; ?>
			<hr class="span12" />
			<footer class='span12'>
				<div class="row">
					<div class='span8'>
						&copy; 2014
					</div>
				</div>
			</footer>
		</div>
		<!-- row-->

	</div> <!-- wrapper -->
	<div id="confirmDiv"></div>
	<?
	if(isset($_POST['grid_keys']))
		echo CHtml::hiddenField('grid_keys',$_POST['grid_keys']);
	?>
</body>
</html>