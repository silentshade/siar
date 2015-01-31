<?php

class MainInstallHelper {
	public $path_images;
	public $module;
	public $module_object;
	public $images;
	public $uploads_dir=false;

	public function __construct($module)
	{
		$this->module=$module;
		$str=ucfirst($module).'Module';

		//Yii::import($module.'.'.$str);

		$this->module_object=Yii::app()->getModule($module);
		if(isset($this->module_object->path_images))
			$this->path_images=$this->module_object->path_images;
	}

	public function install(){
		Yii::import('admin.models.AdminModules');

		if($this->module_object->delete){
			$module=AdminModules::model()->findByAttributes(array('module'=>$this->module));
			if(!$module){
				$module=new AdminModules();
			}
			if($module->state==0){
				$this->upSql();
				if($this->images)
					$this->generateImages();
			}
			$module->module=$this->module;
			$module->name=$this->module_object->name;
			$module->version=$this->module_object->version;
			$module->state=1;
			$module->delete=(int)$this->module_object->delete;
			if(!$module->save()){
				print_r($module->getErrors());
				echo 'error';
			}else{
				echo 'success';
			}
		}else{
			$this->upSql();
			if($this->images)
					$this->generateImages();
		}

		if($this->uploads_dir){
			$uploads=Yii::getPathOfAlias('webroot').'/uploads';
			if(!is_dir($uploads)){
				mkdir($uploads);
			}
			$folder=Yii::getPathOfAlias('webroot.uploads').'/'.$this->module;
			if(!is_dir($folder)){
				mkdir($folder);
			}
		}
	}

	public function uninstall(){
		Yii::import('admin.models.AdminModules');
		$module=AdminModules::model()->findByAttributes(array('module'=>$this->module,'state'=>1,'delete'=>1));
		if($module){
			$module->state=0;
			$module->save();

			$this->downSql();
			if($this->images)
				$this->deleteImages();

			if($this->uploads_dir){
				AdminHelper::rrmdir(Yii::getPathOfAlias('webroot.uploads').'/'.$this->module);
			}
		}
	}

	public function regenerateImages(){
		Yii::import('admin.models.AdminImagesSizes');

		$folder=Yii::getPathOfAlias('webroot.images').DIRECTORY_SEPARATOR;
		$path=$folder.$this->path_images;

		$sizes=AdminImagesSizes::model()->findAllByAttributes(array('module'=>$this->module));
		if($sizes){
			foreach ($sizes as $size) {
				$files = glob($path.'/*'); // get all file names
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
		}
	}

	private function generateImages(){
		Yii::import('admin.models.AdminImagesSizes');

		$folder=Yii::getPathOfAlias('webroot.images').DIRECTORY_SEPARATOR;
		if(!is_dir($folder.$this->path_images)){
			mkdir($folder.$this->path_images);
		}

		if(isset($this->images) && is_array($this->images)){
			foreach ($this->images as $path => $size_arr) {
				$size=AdminImagesSizes::model()->findByAttributes(array(
					'module'=>$this->module,
					'size'=>$path,
					'width'=>$size_arr['width'],
					'heigth'=>$size_arr['heigth'],
					'method'=>$size_arr['method']
				));
				if(!$size)
					$size=new AdminImagesSizes();

				$size->module=$this->module;
				$size->size=$path;
				$size->width=$size_arr['width'];
				$size->heigth=$size_arr['heigth'];
				$size->method=$size_arr['method'];
				$size->save();

				if(!is_dir($folder.$this->path_images.'/'.$path)){
					mkdir($folder.$this->path_images.'/'.$path);
				}

				copy($_SERVER['DOCUMENT_ROOT'].'/protected/modules/admin/assets/no_image.png',$folder.$this->path_images.'/'.$path.'/no_image.png');
				CenterServiceHelper::thumb($folder.$this->path_images.'/'.$path.'/no_image.png', $size_arr['width'], $size_arr['heigth'], "crop", "", "");
			}
		}
	}

	private function deleteImages(){
		AdminHelper::rrmdir(Yii::getPathOfAlias('webroot.images').'/'.$this->path_images);
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}

	protected function upSql(){

	}

	protected function downSql(){
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}
