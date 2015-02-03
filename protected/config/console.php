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
	'name'=>'sia-r',
	'sourceLanguage' => 'en_US',
	'language' => 'ru',

	// preloading 'log' component
	'preload'=>array('log','config'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.modules.admin.components.*',
		'application.modules.mailing.models.*',
		'application.components.*',
		'application.helpers.*',
	),

	'modules'=>$modules,

	// application components
	'components'=>array(
		'config'=>array(
			'class'=>'MyConfig',
		),
		'db'=>require(dirname(__FILE__) . '/db.php'),
		/*'cache'=>array(
            'class'=>'CDbCache',
        ),*/
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
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(

	),
);