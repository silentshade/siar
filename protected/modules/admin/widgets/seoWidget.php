<?php
class seoWidget extends CWidget
{
	public $seo;

    public function run()
    {
        $this->render('seo', array('seo'=>$this->seo));
    }
}