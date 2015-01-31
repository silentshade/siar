<?php
Yii::import('zii.widgets.jui.CJuiInputWidget');

class JQFileUpload extends CJuiInputWidget
{
    public $url;

    public function run()
    {
        $this->registerClientScript();

        list($name, $id) = $this->resolveNameID();

        if($this->hasModel()) {
            //echo CHtml::activeFileField($this->model, $this->attribute, $this->htmlOptions);

			CHtml::resolveNameID($this->model, $this->attribute, $this->htmlOptions);
			// add a hidden field so that if a model only has a file field, we can
			// still use isset($_POST[$modelClass]) to detect if the input is submitted
			$hiddenOptions=isset($this->htmlOptions['id']) ? array('id'=>CHtml::ID_PREFIX.$this->htmlOptions['id']) : array('id'=>false);
			echo CHtml::hiddenField($this->htmlOptions['name'],  CHtml::value($this->model, $this->attribute),$hiddenOptions)
				. CHtml::fileField(CHtml::modelName($this->model).'['.$this->attribute.']', $this->value, $this->htmlOptions);
        } else {
            echo CHtml::fileField($this->name, $this->value, $this->htmlOptions);
        }

        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $id;
        }

        $this->options['url'] = $this->url;

        $options = CJavaScript::encode($this->options);

        $js = "jQuery('#{$this->htmlOptions['id']}').fileupload({$options});";

        Yii::app()->getClientScript()->registerScript(
            __CLASS__ . '#' . $this->htmlOptions['id'], $js,
            CClientScript::POS_READY
        );
    }

    public function registerClientScript()
    {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($assets);
        $cs = Yii::app()->getClientScript();

        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($baseUrl . '/jquery.fileupload.js', CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl . '/jquery.fileupload-process.js', CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl . '/jquery.fileupload-validate.js', CClientScript::POS_END);
    }

    public static function getClassName()
    {
        return get_called_class();
    }
}