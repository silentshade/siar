<?php $this->beginContent('admin.views.layouts.admin'); ?>
<? if(!Yii::app()->user->isGuest): ?>
<button class="not-menu-active pull-left btn btn-mini" style="<? if(!isset($_COOKIE['admin_menu_hide'])) echo 'display: none;'; ?>">></button>
<div class="span3"></div><div class="span9"></div>
<div id="sidebar" class="span3 sidebar-block" <? if(isset($_COOKIE['admin_menu_hide'])) echo 'style="display: none;"'; ?>>
	<div class="well sidebar-nav">
		<button class="not-menu pull-right btn"><</button>
		<?php
		$menu=AdminHelper::returnMenuArray();
		$this->widget('bootstrap.widgets.TbMenu', array(
		'type' => 'list',
		'encodeLabel' => false,
		'items' => array_merge($menu,
			array(
			/*array('label' => 'Товары'),
			array('label' => 'Товары', 'icon' => 'icon-gift', 'url' => '/admin/items', 'active' => Yii::app()->controller->id=='items' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить товар', 'icon' => 'icon-plus-sign', 'url' => '/admin/items/create', 'active' => Yii::app()->controller->id=='items' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
*/
/*			array('label' => 'Обратная связь'),
			array('label' => 'Обратная связь', 'icon' => 'icon-envelope', 'url' => '/admin/feedback', 'active' => Yii::app()->controller->id=='feedback' && Yii::app()->controller->action->id=='index'),

			array('label' => 'Услуги'),
			array('label' => 'Услуги', 'icon' => 'icon-gift', 'url' => '/admin/services', 'active' => Yii::app()->controller->id=='services' && Yii::app()->controller->action->id=='index'),
			//array('label' => 'Статьи'),
			//array('label' => 'Статьи', 'icon' => 'icon-gift', 'url' => '/admin/articles', 'active' => Yii::app()->controller->id=='articles' && Yii::app()->controller->action->id=='index'),
			//array('label' => 'Добавить статью', 'icon' => 'icon-plus-sign', 'url' => '/admin/articles/create', 'active' => Yii::app()->controller->id=='articles' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),

			//array('label' => 'Категории'),
			//array('label' => 'Категории', 'icon' => 'icon-gift', 'url' => '/admin/categories', 'active' => Yii::app()->controller->id=='categories' && Yii::app()->controller->action->id=='index'),
			//array('label' => 'Добавить категорию', 'icon' => 'icon-plus-sign', 'url' => '/admin/categories/create', 'active' => Yii::app()->controller->id=='categories' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
*/

/*
			array('label' => 'Альбомы'),
			array('label' => 'Альбомы', 'icon' => 'icon-gift', 'url' => '/admin/albums', 'active' => Yii::app()->controller->id=='albums' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить альбом', 'icon' => 'icon-plus-sign', 'url' => '/admin/albums/create', 'active' => Yii::app()->controller->id=='albums' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
			array('label' => 'Фото', 'icon' => 'icon-gift', 'url' => '/admin/albumsphoto', 'active' => Yii::app()->controller->id=='albumsphoto' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить фото', 'icon' => 'icon-plus-sign', 'url' => '/admin/albumsphoto/create', 'active' => Yii::app()->controller->id=='albumsphoto' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),

			array('label' => 'Отзывы'),
			array('label' => 'Отзывы', 'icon' => 'icon-file', 'url' => '/admin/response', 'active' => Yii::app()->controller->id=='response' && Yii::app()->controller->action->id=='index'),

			array('label' => 'Мастера'),
			array('label' => 'Мастера', 'icon' => 'icon-file', 'url' => '/admin/masters', 'active' => Yii::app()->controller->id=='masters' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить мастера', 'icon' => 'icon-plus-sign', 'url' => '/admin/masters/create', 'active' => Yii::app()->controller->id=='masters' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),

			array('label' => 'Слайдер'),
			array('label' => 'Слайдер', 'icon' => 'icon-picture', 'url' => '/admin/slider', 'active' => Yii::app()->controller->id=='slider' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить изображение', 'icon' => 'icon-plus-sign', 'url' => '/admin/slider/create', 'active' => Yii::app()->controller->id=='slider' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),

			array('label' => 'Страницы сайта'),
			array('label' => 'Страницы сайта', 'icon' => 'icon-list-alt', 'url' => '/admin/pages', 'active' => Yii::app()->controller->id=='pages' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить страницу', 'icon' => 'icon-plus-sign', 'url' => '/admin/pages/create', 'active' => Yii::app()->controller->id=='pages' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
			array('label' => 'Seo других страниц', 'icon' => 'icon-list-alt', 'url' => '/admin/seopages', 'active' => Yii::app()->controller->id=='seopages' && Yii::app()->controller->action->id=='index'),

			//array('label' => 'Заказы'),
			//array('label' => 'Заказы', 'icon' => 'icon-shopping-cart', 'url' => '/admin/orders', 'active' => Yii::app()->controller->id=='orders' && Yii::app()->controller->action->id=='index'),

			array('label' => 'Настройки'),
			array('label' => 'Смена пароля', 'icon' => 'icon-wrench', 'url' => '/admin/users/passchange', 'active' => Yii::app()->controller->id=='users' && Yii::app()->controller->action->id=='passchange'),
*/
			array('label' => 'Модули'),
			array('label' => 'Модули', 'icon' => 'icon-file', 'url' => '/admin/modules', 'active' => Yii::app()->controller->id=='modules'),

			array('label' => 'Страницы сайта'),
			array('label' => 'Страницы сайта', 'icon' => 'icon-list-alt', 'url' => '/admin/pages', 'active' => Yii::app()->controller->id=='pages' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить страницу', 'icon' => 'icon-plus-sign', 'url' => '/admin/pages/create', 'active' => Yii::app()->controller->id=='pages' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
			array('label' => 'Seo других страниц', 'icon' => 'icon-list-alt', 'url' => '/admin/seopages', 'active' => Yii::app()->controller->id=='seopages' && Yii::app()->controller->action->id=='index'),

			/*array('label' => 'Пользователи'),
			array('label' => 'Пользователи', 'icon' => 'icon-picture', 'url' => '/admin/users', 'active' => Yii::app()->controller->id=='users' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить пользователя', 'icon' => 'icon-plus-sign', 'url' => '/admin/users/create', 'active' => Yii::app()->controller->id=='users' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),*/

			array('label' => 'Настройки сайта'),
			array('label' => 'Настройки сайта', 'icon' => 'icon-wrench', 'url' => '/admin/config', 'active' => Yii::app()->controller->id=='config' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить параметр', 'icon' => 'icon-plus-sign', 'url' => '/admin/config/create', 'active' => Yii::app()->controller->id=='config' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
				array('label' => 'Бекапы бд сайта', 'icon' => 'icon-wrench', 'url' => '/admin/database', 'active' => Yii::app()->controller->id=='database' && Yii::app()->controller->action->id=='index'),
		))
	)); ?>
	</div>
</div>
<? endif; ?>
<div id="main" class="<? if(isset($_COOKIE['admin_menu_hide'])) echo 'span12'; else echo 'span9'; ?>" role="main">
	<?php
		$flashMessages = Yii::app()->user->getFlashes();
		if ($flashMessages) {
			echo '<div class="flash-messages">';
			foreach ($flashMessages as $key => $message) {
				echo '<div class="alert alert-' . $key . '">' . "
<a class='close' data-dismiss='alert'>×</a>
{$message}
\n";
			}
			echo '</div></div>';
		}
		?>

	<?php echo $content; ?>
</div>
<?php $this->endContent(); ?>