<?php
error_reporting(6135);
//error_reporting(E_ALL || E_WARNING);
$yii=dirname(__FILE__).'/../../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('YII_CONSOLE') or define('YII_CONSOLE',true);

require_once($yii);
Yii::createConsoleApplication($config)->run();
?>
