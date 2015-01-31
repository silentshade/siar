<?php

/**
 * This is the model class for table "banners".
 *
 * The followings are the available columns in table 'banners':
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $sort
 * @property integer $place
 * @property integer $views
 * @property integer $clicked
 * @property string $images
 * @property string $created
 * @property string $modified
 * @property integer $published
 */
class Banners extends MainModel
{
	public $image;
	public $module='banners';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'banners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, text', 'required'),
			array('sort, place, views, clicked, published', 'numerical', 'integerOnly'=>true),
			array('name, images', 'length', 'max'=>255),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, text, sort, place, views, clicked, images, created, modified, published', 'safe', 'on'=>'search'),
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
			'name' => 'Заголовок',
			'text' => 'Ссылка',
			'sort' => 'Сортировка',
			'place' => 'Место',
			'views' => 'Просмотров',
			'clicked' => 'Кликов',
			'images' => 'Баннер',
			'created' => 'Добавлен',
			'modified' => 'Modified',
			'published' => 'Опубликовано',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('place',$this->place);
		$criteria->compare('views',$this->views);
		$criteria->compare('clicked',$this->clicked);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('published',$this->published);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banners the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPlaces(){
		return array(
			'0'=>'Справа',
			'1'=>'Главная страница'
		);
	}
}
