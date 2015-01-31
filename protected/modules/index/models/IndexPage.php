<?php

/**
 * This is the model class for table "index_page".
 *
 * The followings are the available columns in table 'index_page':
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $name2
 * @property string $text2
 * @property string $created
 * @property string $modified
 */
class IndexPage extends MainModel
{
	public $module='index';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'index_page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, text, name2, text2', 'required'),
			array('name, text, name2', 'length', 'max'=>255),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, text, name2, text2, created, modified', 'safe', 'on'=>'search'),
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
			'name' => 'Заголовок 1 (слева)',
			'text' => 'Текст 1 (слева)',
			'name2' => 'Заголовок 2 (справа)',
			'text2' => 'Текст 2 (справа)',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('name2',$this->name2,true);
		$criteria->compare('text2',$this->text2,true);
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
	 * @return IndexPage the static model class
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
