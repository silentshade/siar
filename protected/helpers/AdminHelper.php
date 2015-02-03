<?php
class AdminHelper {
	public static function read_files_dir($path,$mask) {
		$files = glob($path.'/'.$mask, GLOB_NOSORT);
		if (is_array($files))
		foreach ($files as &$value) {
			 $value = str_replace(dirname($_SERVER['SCRIPT_FILENAME']), '', $value);
		}

		return $files;
	}

	public static function returnMenuArray(){
		$dirs = scandir(dirname(__FILE__).'/../modules');
		$menu=array();

		foreach ($dirs as $name){
			if ($name[0] != '.' && $name!='admin'){
				$find=AdminModules::model()->findByAttributes(array('module'=>$name,'state'=>1));
				if($find){
					$tmp=Yii::app()->getModule($name)->getMenuItems();
					if($tmp)
						$menu=array_merge($menu,$tmp);
				}
			}

		}

		return $menu;
	}
//AdminHelper::executeSql(dirname($_SERVER['SCRIPT_FILENAME']).'/protected/modules/'.$this->module.'/install/dump.sql');
	public static function executeSql($sqlDumpPath){
		if(is_file($sqlDumpPath)){
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
						if($query)
							$connection->createCommand($query)->execute();
					}
				}
			}
		}
	}

	public static function removeDir($path){
		if(is_dir($path)){
			$files = glob($path.'/*'); // get all file names
			if($files)
			foreach($files as $file){ // iterate files
			  if(is_file($file))
				unlink($file); // delete file
			}
			rmdir($path);
		}
	}

	public static function regenerateImage($path,$size){
		$files = glob($path.'/*'); // get all file names

		if(!is_dir($path.'/'.$size->size)){
			mkdir($path.'/'.$size->size);
		}

		if($files)
		foreach($files as $file){ // iterate files
			if(is_file($file)){
				$file=end(explode('/', $file));
				copy($path.'/'.$file,$path.'/'.$size->size.'/'.$file);
				if($size->method=='crop'){
					CenterServiceHelper::thumb($path.'/'.$size->size.'/'.$file, $size->width, $size->heigth, "crop", "", "");
				}elseif($size->method=='heigth'){
					$image = Yii::app()->image->load($path.'/'.$size->size.'/'.$file);
					$image->resize($size->width, $size->heigth, Image::HEIGHT);
					$image->save($path.'/'.$size->size.'/'.$file);
				}elseif($size->method=='width'){
					$image = Yii::app()->image->load($path.'/'.$size->size.'/'.$file);
					$image->resize($size->width, $size->heigth, Image::WIDTH);
					$image->save($path.'/'.$size->size.'/'.$file);
				}elseif($size->method=='auto'){
					$image = Yii::app()->image->load($path.'/'.$size->size.'/'.$file);
					$image->resize($size->width, $size->heigth, Image::AUTO);
					$image->save($path.'/'.$size->size.'/'.$file);
				}
			}
		}

		copy($_SERVER['DOCUMENT_ROOT'].'/protected/modules/admin/assets/no_image.png',$path.'/'.$size->size.'/no_image.png');
		CenterServiceHelper::thumb($path.'/'.$size->size.'/no_image.png', $size->width, $size->heigth, "crop", "", "");
	}

	public static function generateImage($path,$file,$size){
		if(is_file($path.$file)){
			if(!is_dir($path.$size->size))
				mkdir($path.$size->size);
			copy($path.$file,$path.$size->size.'/'.$file);
			if($size->method=='crop'){
				CenterServiceHelper::thumb($path.$size->size.'/'.$file, $size->width, $size->heigth, "crop", "", "");
			}elseif($size->method=='heigth'){
				$image = Yii::app()->image->load($path.$size->size.'/'.$file);
				$image->resize($size->width, $size->heigth, Image::HEIGHT);
				$image->save($path.$size->size.'/'.$file);
			}elseif($size->method=='width'){
				$image = Yii::app()->image->load($path.$size->size.'/'.$file);
				$image->resize($size->width, $size->heigth, Image::WIDTH);
				$image->save($path.$size->size.'/'.$file);
			}elseif($size->method=='auto'){
				$image = Yii::app()->image->load($path.$size->size.'/'.$file);
				$image->resize($size->width, $size->heigth, Image::AUTO);
				$image->save($path.$size->size.'/'.$file);
			}
		}
	}

	/*
	 * recursively remove a directory
	 */
	public static function rrmdir($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file))
				self::rrmdir($file);
			else
				unlink($file);
		}
		if(is_dir($dir))
			rmdir($dir);
	}

	public static function scanModules(){
		$dirs = scandir(dirname(__FILE__).'/../modules');
		foreach ($dirs as $name){
			if ($name[0] != '.'){
				$module=Yii::app()->getModule($name);
				if(!$module->not_menu){
					$find=AdminModules::model()->findByAttributes(array('module'=>$name));
					if(!$find){
						$find=new AdminModules();
						$find->module=$name;
						$find->name=$module->name;
						$find->version=$module->version;
						$find->delete=$module->delete;
						$find->save(false);
					}
				}
			}
		}
	}

	public static function returnModules(){
		$dirs = scandir(dirname(__FILE__).'/../modules');
		foreach ($dirs as $name){
			if ($name[0] != '.'){
				$modules[$name]=Yii::app()->getModule($name);
			}
		}
		return $modules;
	}

	public static function full_pathinfo($path_file){
        $path_file = strtr($path_file,array('\\'=>'/'));

        preg_match("~[^/]+$~",$path_file,$file);
        preg_match("~([^/]+)[.$]+(.*)~",$path_file,$file_ext);
        preg_match("~(.*)[/$]+~",$path_file,$dirname);

        return array('dirname' => $dirname[1],
        'basename' => $file[0],
        'extension' => (isset($file_ext[2]))?$file_ext[2]:false,
        'filename' => (isset($file_ext[1]))?$file_ext[1]:$file[0]);
    }

	public static function returnDeleteImages($delete,$path,$module_name)
    {
		$imagePath = $_SERVER['DOCUMENT_ROOT'] . $path;
		$images_size=AdminImagesSizes::model()->findAllByAttributes(array('module'=>$module_name));

		if($delete && is_array($delete)){
			foreach ($delete as $del=>$d) {
				if($del && $d==1){
					if(is_file($imagePath.$del)) unlink($imagePath.$del);

					if($images_size){
						foreach ($images_size as $size) {
							if(is_file($imagePath.$size->size.'/'.$del)) unlink($imagePath.$size->size.'/'.$del);
						}
					}
				}
			}
		}elseif($delete){
			if(is_file($imagePath.$delete)) unlink($imagePath.$delete);

			if($images_size){
				foreach ($images_size as $size) {
					if(is_file($imagePath.$size->size.'/'.$delete)) unlink($imagePath.$size->size.'/'.$delete);
				}
			}
		}
    }

	public static function getUsersEmails(){
		Yii::import('users.models.User');
		$users=User::model()->findAll(array('condition'=>'blocked=0'));
		if($users){
			foreach ($users as $user) {
				$emails[]=$user->email;
			}
		}
		return $emails ? implode(',', $emails) : '';
	}
}
