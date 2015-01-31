<?php
Yii::import('staff.models.Staff');
Yii::import('admin.components.MainModel');


class AllStaffWidget extends CWidget
{
    public function run()
    {
        $items = Staff::model()->findAll(array(
			'order'=>'all_row asc, sort desc',
			'condition'=>'published=1'
		));
        $this->render('all_staff', array('items'=>$items));
    }
}