<?php

/**
 * This is the model class for table "feedback".
 *
 * The followings are the available columns in table 'feedback':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $theme
 * @property string $text
 * @property string $created
 */
class Feedback extends MainModel
{
	public $module='feedback';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Feedback the static model class
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
		return 'feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, theme, text', 'required'),
			array('name, email, theme', 'length', 'max'=>255),
			array('email', 'email'),
			array('created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, theme, text, created', 'safe', 'on'=>'search'),
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
			'name' => 'Имя',
            'email' => 'Email',
            'theme' => 'Тема',
            'text' => 'Текст',
			'created' => 'Отправлено',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('theme',$this->theme,true);
        $criteria->compare('text',$this->text,true);
        $criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'created desc'),
		));
	}

	public function getTheme(){
		$themes=explode(';',Yii::app()->params['feedback_theme']);
		$themes=array_combine($themes, $themes);
		return $themes;
	}
}