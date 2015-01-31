<?php

class DatabaseController extends CAdminController
{
	public function actionIndex() {
		$server_dir=dirname($_SERVER['SCRIPT_FILENAME']);
		$rawData=array();
		$files=AdminHelper::read_files_dir($server_dir.'/protected/backups','*'.'*');
		if(!empty($files) && is_array($files)){
			foreach($files as $file) {
				$rawData[]=array('id'=>$i++,'file'=>  str_replace('/protected/backups/', '', $file));
			}
		}

		$arrayDataProvider=new CArrayDataProvider($rawData, array(
			'id'=>'id',
			 'sort'=>array(
				'attributes'=>array(
					'file',
				),
				'defaultOrder'=>'file.desc'
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));

		$this->render('index',array('arrayDataProvider'=>$arrayDataProvider));
	}

	public function actionDbBackup(){
		Yii::import('ext.yii-database-dumper.SDatabaseDumper');
		/*echo exec('df -h').'<br>';
		echo exec('free -m').'<br>';
		echo exec('date').'<br>';*/

		$dumper = new SDatabaseDumper;
		// Get path to backup file
		$file = Yii::getPathOfAlias('webroot.protected.backups').DIRECTORY_SEPARATOR.'dump_'.date('Y-m-d_H_i_s').'.sql';

		// Gzip dump
		if(function_exists('gzencode'))
			file_put_contents($file, $dumper->getDump());
			//file_put_contents($file.'.gz', gzencode($dumper->getDump()));
		else
			file_put_contents($file, $dumper->getDump());

		//echo file_get_contents($file);
		Yii::app()->user->setFlash('success', 'Бекап создан');

		$this->redirect('/admin/database');
	}

	public function actionGetFile(){
		$file=dirname($_SERVER['SCRIPT_FILENAME']).'/protected/backups/'.$_GET['file'];
		if(is_file($file))
			Yii::app()->request->sendFile($_GET['file'],file_get_contents($file));
	}

	public function actionimportSqlDump()
	{
		//$sqlDumpPath = Yii::getPathOfAlias('application.modules.install.data').DIRECTORY_SEPARATOR.'dump.sql';
		$sqlDumpPath = dirname($_SERVER['SCRIPT_FILENAME']).'/protected/backups/'.(isset($_GET['file']) ? $_GET['file'] : '');
		$sqlRows=preg_split("/--\s*?--.*?\s*--\s*/", file_get_contents($sqlDumpPath));

		/*$connection=new CDbConnection($this->getDsn(), $this->dbUserName, $this->dbPassword);
		$connection->charset='utf8';
		$connection->active=true;*/
		$connection=Yii::app()->db;

		$connection->createCommand("SET NAMES 'utf8';");

		foreach($sqlRows as $q)
		{
			$q=trim($q);
			if(!empty($q))
			{
				if(strpos($q, 'DROP TABLE IF EXISTS')===false)
					$connection->createCommand($q)->execute();
				else
				{
					$lines=preg_split("/(\r?\n)+/", $q);
					$dropQuery=$lines[0];
					array_shift($lines);
					$query=implode('', $lines);

					$connection->createCommand($dropQuery)->execute();
					$connection->createCommand($query)->execute();
				}
			}
		}

		Yii::app()->user->setFlash('success', 'Бекап '.$_GET['file'].' восстановлен');
		$this->redirect('/admin/database');
	}

	public function actionimportSqlDumpForm()
	{

		if(is_uploaded_file($_FILES['file']["tmp_name"])){
			//$sqlDumpPath = Yii::getPathOfAlias('application.modules.install.data').DIRECTORY_SEPARATOR.'dump.sql';
			$sqlDumpPath = $_FILES['file']["tmp_name"];
			$sqlRows=preg_split("/--\s*?--.*?\s*--\s*/", file_get_contents($sqlDumpPath));

			/*$connection=new CDbConnection($this->getDsn(), $this->dbUserName, $this->dbPassword);
			$connection->charset='utf8';
			$connection->active=true;*/
			$connection=Yii::app()->db;

			$connection->createCommand("SET NAMES 'utf8';");

			foreach($sqlRows as $q)
			{
				$q=trim($q);
				if(!empty($q))
				{
					if(strpos($q, 'DROP TABLE IF EXISTS')===false)
						$connection->createCommand($q)->execute();
					else
					{
						$lines=preg_split("/(\r?\n)+/", $q);
						$dropQuery=$lines[0];
						array_shift($lines);
						$query=implode('', $lines);

						$connection->createCommand($dropQuery)->execute();
						$connection->createCommand($query)->execute();
					}
				}
			}

			Yii::app()->user->setFlash('success', 'Бекап '.$_GET['file'].' восстановлен');
			$this->redirect('/admin/database');
		}

	}
}