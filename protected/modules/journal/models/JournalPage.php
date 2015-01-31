<?php

/**
 * This is the model class for table "journal_page".
 *
 * The followings are the available columns in table 'journal_page':
 * @property string $id
 * @property string $name
 * @property string $text
 * @property string $redactor_collegy
 * @property string $redactor_collegy_text
 * @property string $redactor_advice
 * @property string $redactor_advice_text
 * @property string $created
 * @property string $modified
 */
class JournalPage extends MainModel
{
	public $module='journal';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'journal_page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, text, redactor_collegy, redactor_collegy_text, redactor_advice, redactor_advice_text', 'required'),
			array('name, redactor_collegy, redactor_advice', 'length', 'max'=>255),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, text, redactor_collegy, redactor_collegy_text, redactor_advice, redactor_advice_text, created, modified', 'safe', 'on'=>'search'),
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
			'text' => 'Описание',
			'redactor_collegy' => 'Редакционная коллегия',
			'redactor_collegy_text' => 'Состав коллегии',
			'redactor_advice' => 'Редакционный совет',
			'redactor_advice_text' => 'Состав совета',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('redactor_collegy',$this->redactor_collegy,true);
		$criteria->compare('redactor_collegy_text',$this->redactor_collegy_text,true);
		$criteria->compare('redactor_advice',$this->redactor_advice,true);
		$criteria->compare('redactor_advice_text',$this->redactor_advice_text,true);
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
	 * @return JournalPage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterSave()
	{
		$module=Yii::app()->getModule($this->module);
		$seo=Seo::model()->findByAttributes(array('entity'=>$this->id,'type'=>$module->seo_type,'module'=>$module->getName()));
		$seo_post=$_POST['Seo'];
		if($seo){
			$seo->title=$seo_post['title'] ? $seo_post['title'] : $this->name;
			$seo->description=$seo_post['description'] ? $seo_post['description'] : $this->name;
			$seo->keywords=$seo_post['keywords'] ? $seo_post['keywords'] : $this->name;
			$seo->save();
		}else{
			$seo= new Seo();
			$seo->entity=$this->id;
			$seo->type=$module->seo_type;
			$seo->module=$module->getName();
			$seo->title=$seo_post['title'] ? $seo_post['title'] : $this->name;
			$seo->description=$seo_post['description'] ? $seo_post['description'] : $this->name;
			$seo->keywords=$seo_post['keywords'] ? $seo_post['keywords'] : $this->name;
			$seo->save();
		}
	}
}
