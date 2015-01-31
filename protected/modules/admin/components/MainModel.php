<?php
class MainModel extends CActiveRecord {
	public $module;

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'created',
				'updateAttribute' => 'modified',
			)
		);
	}

	public function getModelName()
	{
		return get_called_class();
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if(isset($_POST[$this->getModelName()]))
			{
				$module=Yii::app()->getModule($this->module);

				if(isset($_POST[$this->getModelName()]['updatedimage']))
					AdminHelper::returnDeleteImages($_POST[$this->getModelName()]['updatedimage'],'/images/'.$module->path_images.'/',$module->getName());
			}

			return true;
		}
		else
			return false;
	}

	protected function afterDelete(){
		if(isset($this->images) && $this->images){
			$module=Yii::app()->getModule($this->module);
			$images=explode(';',$this->images);
			if($images){
				foreach ($images as $value) {
					AdminHelper::returnDeleteImages($value,'/images/'.$module->path_images.'/',$module->getName());
				}
			}
		}
	}
}
