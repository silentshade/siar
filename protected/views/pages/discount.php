<? $this->headerTitle='ДИСКОНТНАЯ ПРОГРАММА';
$discount=unserialize($model->text);
?>

<div class="b-discount">
	<div class="b-text-block">
		<?=$discount['text_up'];?>
	</div>
</div>

</div>

<div class="b-discount-list">
	<div class="b-container">
		<div class="b-title">
			<p><?=$discount['body_text_up'];?></p>
		</div>
		<div class="b-table-discount">
			<?=$discount['body_table'];?>
		</div>
		<div class="b-note"><p><?=$discount['body_footer_h1'];?></p></div>
		<div class="b-descr"><p><?=$discount['body_footer_text'];?></p></div>
	</div>