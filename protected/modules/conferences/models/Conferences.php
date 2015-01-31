<?php

/**
 * This is the model class for table "conferences".
 *
 * The followings are the available columns in table 'conferences':
 * @property string $id
 * @property string $name
 * @property string $text
 * @property string $begin_conf
 * @property string $end_conf
 * @property string $created
 * @property string $modified
 * @property integer $published
 */
class Conferences extends MainModel
{
	public $module='conferences';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'conferences';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, text, begin_conf, end_conf', 'required'),
			array('published', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, text, begin_conf, end_conf, created, modified, published', 'safe', 'on'=>'search'),
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
			'begin_conf' => 'Начало конференции',
			'end_conf' => 'Конец конференции',
			'created' => 'Created',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('begin_conf',$this->begin_conf,true);
		$criteria->compare('end_conf',$this->end_conf,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('published',$this->published);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'begin_conf desc'
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Conferences the static model class
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

	public function getConfDate(){
		$date=Yii::app()->dateFormatter->format("dd MMMM yyyy", $this->end_conf).' г.';
		$begin_date=explode(' ', Yii::app()->dateFormatter->format("dd MMMM yyyy", $this->begin_conf));
		$end_date=explode(' ', Yii::app()->dateFormatter->format("dd MMMM yyyy", $this->end_conf));
		
		if(($begin_date[0]<>$end_date[0]) ||
			($begin_date[0]==$end_date[0] && $begin_date[1]<>$end_date[1] && $begin_date[2]==$end_date[2]) ||
			($begin_date[0]==$end_date[0] && $begin_date[1]==$end_date[1] && $begin_date[2]<>$end_date[2])){
			$begin_date_str=$begin_date[0];
		}

		if(($begin_date[1]<>$end_date[1]) ||
			($begin_date[1]<>$end_date[1] && $begin_date[2]==$end_date[2]) ||
			($begin_date[1]==$end_date[1] && $begin_date[2]<>$end_date[2])){
			$begin_date_str.=' '.$begin_date[1];
		}

		if($begin_date[2]<>$end_date[2]){
			$begin_date_str.=' '.$begin_date[2];
		}

		$date=($begin_date_str ? $begin_date_str.' - ' : '').$date;
		//echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $this->begin_conf).' - '.Yii::app()->dateFormatter->format("dd MMMM yyyy", $this->end_conf).' г.';
		echo $date;
	}
}
