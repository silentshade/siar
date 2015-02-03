<?php
$dirs = scandir(dirname(__FILE__).'/../modules');

// строим массив
$modules = array();
foreach ($dirs as $name){
    if ($name[0] != '.' && $name<>'admin')
        $modules[$name] = array('class'=>'application.modules.' . $name . '.' . ucfirst($name) . 'Module');
}

// строка вида 'news|page|user|...|socials'
// пригодится для подстановки в регулярные выражения общих правил маршрутизации
define('MODULES_MATCHES', implode('|', array_keys($modules)));

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'',
	'sourceLanguage' => 'ru',
	'language' => 'ru',

	// preloading 'log' component
	'preload'=>array('log','config'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		//'ext.shoppingCart.*',
	),

	'modules'=>array_replace($modules, array(
			// uncomment the following to enable the Gii tool
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'123789',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('213.151.6.241','213.179.252.89','::1'),
			),
			'admin',
		)
	),

	// application components
	'components'=>array(
		'config'=>array(
			'class'=>'MyConfig',
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/?login'),
		),
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
			'responsiveCss' => true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'class'=>'MUrlManager',
			'urlFormat'=>'path',
			'showScriptName' => false,
			//'useStrictParsing'=>true,
			'rules'=>array(
				//'<page:(about)>'=>'pages/view',
				'<page:.*?>-s<id:\d+>'=>'pages/view',
/*
				'<item:.*?>-p<id:\d+>'=>'items/view',
				'gallery/<id:\d+>'=>'gallery/index',
				'<item:.*?>-a<id:\d+>'=>'articles/view',
				'<page:.*?>-s<id:\d+>'=>'pages/view_dynamic',
				'<news:.*?>-n<id:\d+>'=>'news/view',
				'<news:.*?>-c<id:\d+>'=>'catalog/index',
				'<news:.*?>-k<id:\d+>'=>'articles/index',*/

				'admin/<controller:(modules|database|config|login|pages|seopages)>'=>'admin/<controller>/index',
				'admin/<controller:(modules|database|config|login|pages|seopages)>/<action:\w+>/<id:\w+>'=>'admin/<controller>/<action>',
				'admin/<controller:(modules|database|config|login|pages|seopages)>/<action:\w+>'=>'admin/<controller>/<action>',


				'admin/<controller:\w+>'=>'<controller>/backend/main/index',
				'admin/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/backend/main/<action>',
				'admin/<controller:\w+>/<action:\w+>'=>'<controller>/backend/main/<action>',

				'admin/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/backend/<controller>/<action>',


				/*'admin/<controller:\w+>/<id:\d+>'=>'admin/<controller>/view',
				'admin/<controller:\w+>/<action:\w+>/<id:\d+>'=>'admin/<controller>/<action>',
				'admin/<controller:\w+>/<action:\w+>'=>'admin/<controller>/<action>',*/

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'image' => array(
				'class' => 'application.extensions.image.CImageComponent',
				// GD or ImageMagick
				'driver' => 'GD',
				// ImageMagick setup path
				'params' => array('directory' => '/opt/local/bin'),
		),
		/*'cache'=>array(
            'class'=>'CDbCache',
        ),*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(),
);