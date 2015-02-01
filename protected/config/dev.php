<?php

return CMap::mergeArray(
	require(dirname(__FILE__) . '/main.php'), array(
		'components' => array(
			'db'=>require(dirname(__FILE__) . '/db.php'),
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(


									  //Закоментировал для работы DbProfile

											//	'class'=>'CFileLogRoute',

				   'class'=>'ext.db_profiler.DbProfileLogRoute',
				   'countLimit' => 1, // How many times the same query should be executed
				   'slowQueryMin' => 0.01, // Minimum time for the query to be slow


						'levels'=>'error, warning, trace, profile, info',
					),
					// uncomment the following to show log messages on web pages
					/*
					array(
						'class'=>'CWebLogRoute',
					),
					*/
				),
			),
			/*'cache'=>array(
				'class'=>'CDbCache',
			),*/
		),
	)
);
