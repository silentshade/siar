<?php
Yii::import('users.models.User');
/**
 * This is the model class for table "thesises".
 *
 * The followings are the available columns in table 'thesises':
 * @property string $id
 * @property string $name_conf
 * @property string $name_thesis
 * @property string $text
 * @property string $user_id
 * @property string $file
 * @property string $created
 * @property string $modified
 */
class Thesises extends MainModel
{
	public $module='thesises';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'thesises';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_conf, name_thesis, text, user_id', 'required'),
			array('name_conf, name_thesis, file', 'length', 'max'=>255),
			array('user_id', 'length', 'max'=>11),
			array('created, modified', 'safe'),

			array(
				'file', 'file',
				'types'=>Yii::app()->params['thesises_ext'],
				'maxSize'=>Yii::app()->params['thesises_size']*1024*1024,
				'tooLarge'=>'Размер файла слишком велик, он не должен превышать '.Yii::app()->params['thesises_size'].'MB',
				'on'=>'create'
			),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name_conf, name_thesis, text, user_id, file, created, modified', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, User, 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name_conf' => 'Название конференции',
			'name_thesis' => 'Название тезиса',
			'text' => 'Комментарий к тезису',
			'user_id' => 'Пользователь',
			'file' => 'Сопровождающий документ',
			'created' => 'Добавлены',
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
		$criteria->compare('name_conf',$this->name_conf,true);
		$criteria->compare('name_thesis',$this->name_thesis,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.created DESC'
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Thesises the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
