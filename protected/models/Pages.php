<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $text
 * @property string $created
 * @property string $modified
 */
class Pages extends CActiveRecord
{
	public $yes_no=array('1'=>'Да','0'=>'Нет');
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pages the static model class
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
		return 'pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name, alias', 'length', 'max'=>255),
			array('text,created, modified,delete,in_footer,in_header,controller,action,header_order,footer_order,dev_alias', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, alias, text, created, modified', 'safe', 'on'=>'search'),
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
			'name' => 'Название',
			'alias' => 'url',
			'text' => 'Текст',
			'created' => 'Создана',
			'in_footer' => 'Отображать в нижнем меню',
			'in_header' => 'Отображать в верхнем меню',
			'modified' => 'Посл. изменение',
			'header_order' => 'Порядок показа в верхнем меню',
			'footer_order' => 'Порядок показа в нижнем меню',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'header_order asc'
			)
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created=date('Y-m-j H-i-s');
				$this->modified=date('Y-m-j H-i-s');
				$this->header_order=Yii::app()->db->createCommand("SELECT MAX(header_order)+1 FROM pages WHERE alias<>'404'")->queryScalar();
				$this->footer_order=Yii::app()->db->createCommand("SELECT MAX(footer_order)+1 FROM pages WHERE alias<>'404'")->queryScalar();
			} else {
				$this->modified=date('Y-m-j H-i-s');
				if($this->delete)
					$this->alias=SiteHelper::str2url($this->name).'-s'.$this->id;
			}

			return true;
		}
		else
			return false;
	}

	protected function afterSave()
	{
		if($this->isNewRecord)
		{
			if($this->delete)
				Pages::model()->updateByPk($this->id, array('alias'=>SiteHelper::str2url($model->name).'-s'.$this->id));
		}

		$seo=Seo::model()->findByAttributes(array('entity'=>$this->id,'type'=>3));
		$seo_post=$_POST['Seo'];
		if($seo){
			$seo->title=$seo_post['title'] ? $seo_post['title'] : $this->name;
			$seo->description=$seo_post['description'] ? $seo_post['description'] : $this->name;
			$seo->keywords=$seo_post['keywords'] ? $seo_post['keywords'] : $this->name;
			$seo->save();
		}else{
			$seo= new Seo();
			$seo->entity=$this->id;
			$seo->type=3;
			$seo->title=$seo_post['title'] ? $seo_post['title'] : $this->name;
			$seo->description=$seo_post['description'] ? $seo_post['description'] : $this->name;
			$seo->keywords=$seo_post['keywords'] ? $seo_post['keywords'] : $this->name;
			$seo->save();
		}
	}
}