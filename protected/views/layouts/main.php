<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="description" content="<?=CHtml::encode($this->metaDescription);?>">
	<meta name="keywords" content="<?=CHtml::encode($this->metaKeywords);?>" />

	<link rel="stylesheet" href="/css/own.css?v=1">
	<link rel="stylesheet" href="/css/style.css?v=1">
	<link title="Лента RSS" type="application/rss+xml" rel="alternate" href="<?=Yii::app()->getBaseUrl(true);?>/feed"/>
	<link href="/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<!--	<script type="text/javascript" src="/js/script.js"></script>
	<script type="text/javascript" src="/js/my.js"></script>-->

<?
$cs = Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
//$cs->registerCoreScript('jquery');
/*$cs = Yii::app()->clientScript;
$cs->coreScriptPosition=CClientScript::POS_END;
Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
Yii::app()->clientScript->scriptMap['jquery.js'] = false;*/
//$cs->registerCoreScript('jquery');
//$cs->registerScriptFile('/js/jquery-ui-1.9.2.custom.min.js', CClientScript::POS_HEAD);
//$cs->registerScriptFile('/js/buttons.js', CClientScript::POS_HEAD);
//$cs->registerScript('fancybox','stLight.options({publisher: "ur-df0de05-fe3b-b0a4-6936-e77e1e7cda93", doNotHash: false, doNotCopy: false, hashAddressBar: false});',CClientScript::POS_HEAD);
?>
</head>

<body class="common">
	<!-- HEADER -->
	<header class="page-header">
		<div class="page-header__wrapper">
			<div class="container page-header__margin-top">
				<div class="row">


					<div class="col-wide"> <!-- left column -->

						<div class="page-header__lead"> <!-- logo and organisation name -->

							<a href="/" class="page-header__logo">
								<img src="/img/rashi-logo.png" alt="РАСХИ логотип. Ссылка на главную страницу" title="РАСХИ">
							</a>

							<div class="page-header__orgname">
								<p class="page-header__orgname--big">Российская Ассоциация</p>
								<p class="page-header__orgname--small">Специалистов по Хирургическим Инфекциям</p>
							</div>
						</div>

						<nav class="page-header__menu"> <!-- menu-->
							<ul class="page-header__links">
								<li class="page-header__item<? if(isset($this->module) && $this->module->getName()=='index') echo ' page-header__item--active' ?>"><a href="/" class="page-header__link<? if(isset($this->module) && $this->module->getName()=='index') echo ' page-header__link--active' ?>">Главная</a></li>
								<li class="page-header__item<? if(isset($this->module) && $this->module->getName()=='journal') echo ' page-header__item--active' ?>"><a href="/journal" class="page-header__link<? if(isset($this->module) && $this->module->getName()=='journal') echo ' page-header__link--active' ?>">Журнал</a></li>
								<li class="page-header__item<? if(isset($this->module) && $this->module->getName()=='library') echo ' page-header__item--active' ?>"><a href="/library" class="page-header__link<? if(isset($this->module) && $this->module->getName()=='library') echo ' page-header__link--active' ?>">Библиотека</a></li>
								<li class="page-header__item<? if(isset($this->module) && $this->module->getName()=='conferences') echo ' page-header__item--active' ?>"><a href="/konferencii" class="page-header__link<? if(isset($this->module) && $this->module->getName()=='conferences') echo ' page-header__link--active' ?>">Конференции</a></li>
								<li class="page-header__item<? if(isset($this->module) && $this->module->getName()=='contacts') echo ' page-header__item--active' ?>"><a href="/contacts" class="page-header__link<? if(isset($this->module) && $this->module->getName()=='contacts') echo ' page-header__link--active' ?>">Контакты</a></li>
							</ul>
						</nav>

					</div>

					<div class="col-narrow"> <!-- right column -->
						<? if(Yii::app()->user->isGuest): ?>
							<div class="page-header__loginform-wrapper">
								<div class="page-header__loginform"> <!-- Login/Registration form -->

									<a href="/request-an-account" class="page-header__loginform-registration">Регистрация в РАСХИ</a>

									<?
									Yii::import('users.models.LoginForm');
									$model= new LoginForm();
									$form = $this->beginWidget('CActiveForm', array(
										'id'=>'login-form',
										'action'=>'/users/login',
										'enableClientValidation'=>true,
										'clientOptions'=>array(
											'validateOnSubmit'=>true,
										),
									)); ?>

										<?php echo $form->textField($model,'username', array('class'=>'page-header__input', 'placeholder'=>'Email или логин', 'required'=>'required')); ?>
										<?php echo $form->passwordField($model,'password', array('class'=>'page-header__input', 'placeholder'=>'Пароль', 'required'=>'required')); ?>

										<label class="page-header__label">Запомнить меня <?php echo $form->checkBox($model,'rememberMe'); ?></label>


										<?php echo CHtml::ajaxSubmitButton(
										'Войти',
										'/users/login',
										array(
											'type' => 'post',
											'dataType' => 'json',
											'success' => 'function(data){
											$(".error").removeClass("error");

											if(data.authenticated)
											{
												window.location = data.redirectUrl;
											} else {
												$.each(data, function(key, value) {
													var div = "#"+key;
													$(div).addClass("error");
												});
											}
										}'
										),
										array('class' => 'page-header__submit')
									); ?>
										<input type="hidden" name="ajax" value="login-form">
									<?php $this->endWidget(); ?>

								</div>

								<div class="page-header__pass-recover"> <!-- Recover password link -->
									<a href="/remind" class="link-dark-bg link-dark-bg--lh12">Забыли пароль?</a>
								</div>
							</div>
						<? else: ?>
							<div class="page-header__loginform-wrapper page-header__loginform-wrapper--pt">

								<p class="text-dark-bg">Здравствуйте,</p>
								<p class="text-dark-bg text-dark-bg--bold"><?=Yii::app()->user->name;?></p>
								<a href="/profile" class="link-dark-bg">Ваши личные данные</a>
								<span class="link-dark-bg link-dark-bg--w-o-hover">|</span>
								<a href="/logout" class="link-dark-bg">Выйти</a>

							</div>
						<? endif; ?>

						<div class="page-header__search">
							<form id="ajaxSearch_form" action="/search"> <!-- Search form -->
								<div class="page-header__search-input-wrapper">
									<input id="ajaxSearch_input" required class="page-header__search-input" type="text" placeholder="Запрос для поиска..." name="search">
								</div>
								<input id="ajaxSearch_submit" type="submit" class="page-header__search-submit" value="Найти">
								<input type="hidden" value="oneword" name="advSearch">
							</form>
						</div>

					</div>


				</div>
			</div>
		</div>
	</header>
	<!-- / HEADER -->

	<div class="container">
		<div class="row row__wrapper-bg">

			<!-- PAGE CONTENT -->
			<main class="col-wide main">
				<div id="ajaxSearch_output" style="display: none;"></div>

				<?php echo $content; ?>
			</main>
			<!-- / PAGE CONTENT -->

			<!-- SIDEBAR -->
			<aside class="page-aside col-narrow">

				<? $this->widget('conferences.widgets.LastConfWidget', array('limit'=>Yii::app()->params['conferences_count_left_block'])); ?>

				<? if(!Yii::app()->user->isGuest): ?>
				<div class="send-thesises">
					<a title="Отправка тезисов" href="/thesises">Отправка тезисов</a>
				</div>
				<? endif; ?>

				<? $this->widget('banners.widgets.BannersWidget', array('limit'=>20, 'place'=>0)); ?>
			</aside>
			<!-- / SIDEBAR -->
		</div>
	</div>

	<!-- FOOTER -->
	<footer class="page-footer">
		<div class="page-footer__wrapper">
			<div class="container page-footer__bgc">
				<div class="row">

					<nav class="page-footer__menu"> <!-- menu-->
						<ul class="page-footer__links">
							<li class="page-footer__item"><a href="/" class="page-footer__link">Главная</a></li>
							<li class="page-footer__item"><a href="/journal" class="page-footer__link">Журнал</a></li>
							<li class="page-footer__item"><a href="/library" class="page-footer__link">Библиотека</a></li>
							<li class="page-footer__item"><a href="/konferencii" class="page-footer__link">Конференции</a></li>
							<li class="page-footer__item"><a href="/contacts" class="page-footer__link">Контакты</a></li>
						</ul>
					</nav>

					<span class="page-footer__links--right">
						<a href="#" class="page-footer__link">Вебмастерам</a>
						<span class="page-footer__link--white">| &copy; РАСХИ 2003-2014 |</span>
						<a href="/feed" class="page-footer__link">Лента RSS</a>
					</span>

				</div>
			</div>
		</div>
	</footer>
	<!-- / FOOTER -->

	<!-- JavaScript -->
	<script src="/js/show-hide.js"></script>
	<script src="/js/ajaxSearch.js?v=1"></script>
	<!-- / JavaScript -->
	<?=Yii::app()->params['google_analitika'];?>
</body>
</html>
