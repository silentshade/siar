<?php

/**
 * This is the model class for table "admin_images_sizes".
 *
 * The followings are the available columns in table 'admin_images_sizes':
 * @property string $id
 * @property string $module
 * @property string $size
 * @property integer $width
 * @property integer $heigth
 * @property string $method
 * @property string $created
 * @property string $modified
 */
class AdminImagesSizes extends MainModel
{
	public $method_array=array('auto'=>'Авто','crop'=>'Кроп','width'=>'По ширине','heigth'=>'По высоте');
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'admin_images_sizes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module, size, width, heigth, method', 'required'),
			array('width, heigth', 'numerical', 'integerOnly'=>true),
			array('module, size, method', 'length', 'max'=>255),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, module, size, width, heigth, method, created, modified', 'safe', 'on'=>'search'),
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
			'module' => 'Module',
			'size' => 'Размер',
			'width' => 'Ширина',
			'heigth' => 'Высота',
			'method' => 'Метод',
			'created' => 'Created',
			'modified' => 'Modified',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('heigth',$this->heigth);
		$criteria->compare('method',$this->method,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdminImagesSizes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
