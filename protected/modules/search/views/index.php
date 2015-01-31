<?php
if($items){
	foreach ($items as $value) {
		$this->renderPartial('/_view', array('value'=>$value));
	}
}else{
	echo '<div class="AS_ajax_result">
	Ничего не найдено
</div>';
}
?>