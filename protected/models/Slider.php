<?php

/**
 * This is the model class for table "slider".
 *
 * The followings are the available columns in table 'slider':
 * @property integer $id
 * @property string $image
 * @property string $link
 * @property integer $sort
 */
class Slider extends CActiveRecord
{
	public $images;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Slider the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'slider';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('image', 'required'),
			array('sort', 'numerical', 'integerOnly'=>true),
			//array('image', 'length', 'max'=>255),
			array('image, type,name,text,link', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, image, sort', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'image' => 'Картинка',
			'name' => 'Название ссылки',
			'text' => 'Текст слайда',
			'link' => 'Ссылка',
			'images' => 'Картинка',
			'sort' => 'Sort',
			'type' => 'Размещение',
		);
	}

	public function set_sort($sort) {
		$elements=explode(',',$sort);
		$i=1;
		$menu= new Slider();
		if (!empty($elements)){
			$elements=array_reverse($elements);
			foreach ($elements as $value) {
				$menu->updateByPk(
					$value,
					array('sort'=>$i)
				);
				$i++;
			}
		}
	}

	public function SaveImages()
	{
		$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/slideshow/';
		$types= array('jpg', 'jpeg', 'gif', 'png');

		$i = 1;
		foreach ($this->images as $file) {
			if (!$file) continue;
			$ext=strtolower($file->extensionName);
			$name = $this->id . '_' .$i. '.' . $ext;
			while (file_exists($imagePath . $name)) {
				$i++;
				$name = $this->id . '_' .$i. '.' . $ext;
			}

			if (!empty($file) && in_array($ext, $types)) {
				$images[] = $name;
				$file->saveAs($imagePath . $name);
				$i++;


				copy($imagePath. $name,$imagePath .'/'. $name);
				CenterServiceHelper::thumb($imagePath .'/'. $name, 1920, 697, "crop", "", "");
				/*if($this->type==0){
					copy($imagePath. $name,$imagePath .'/'. $name);
					CenterServiceHelper::thumb($imagePath .'/'. $name, 1920, 697, "crop", "", "");
				}else{
					copy($imagePath. $name,$imagePath .'/'. $name);
					CenterServiceHelper::thumb($imagePath .'/'. $name, 1129, 712, "crop", "", "");
				}*/

				/*$sizes=getimagesize($imagePath . $name);
				$width = $sizes[0];
				$height = $sizes[1];

				if($width>$height){
					$image = Yii::app()->image->load($imagePath. $name);
					$image->resize(1920, 712, Image::WIDTH);
					$image->save($imagePath .$name);
				}else{
					$image = Yii::app()->image->load($imagePath. $name);
					$image->resize(1920, 712, Image::HEIGHT);
					$image->save($imagePath .$name);
				}*/
			}
		}
		if(is_array($images)){
			if(!empty($this->image))
				$this->image.=';'.implode(';',$images);
			else
				$this->image=implode(';',$images);
			$this->save();
		}
	}
}