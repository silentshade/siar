<?php if($items): ?>
	<? foreach ($items as $key=>$value): ?>
		<? if($value->all_row==1): ?>
			<div class="row"> <!-- first wide worker card-->
				<? $this->render('_view_all_row_staff', array('value'=>$value)); ?>
			</div>
		<? endif; ?>
		<? if($value->all_row<>1):
			$print_normal[]=$value;
			endif; ?>
	<? endforeach;

	if($print_normal)
		$print_normal=  array_chunk ($print_normal, 2);
		foreach ($print_normal as $value) {
			echo '<div class="row"> <!-- worker cards-->';
			foreach ($value as $val) {
				$this->render('_view_staff', array('value'=>$val));
			}
			echo '</div>';
		}

	?>
<? endif; ?>