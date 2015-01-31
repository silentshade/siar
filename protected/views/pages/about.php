<? $this->headerTitle='О САЛОНЕ';
$about=unserialize($model->text);
?>
	<div class="b-text-block">
		<?=$about['text_up'];?>
	</div>
	<div class="b-blockquet">
		<?=$about['text_with_image'];?>
	</div>
	<div class="b-text-block b-text_after_image">
		<?=$about['text_after_image'];?>
	</div>
</div>

<div class="b-service-block">
	<div class="b-container">
		<div class="b-item">
			<p><?=$about['text_uslug'];?></p>
			<div class="b-img"><img src="/images/service1.jpg" alt=""></div>
			<a href="/services"><span>НАШИ УСЛУГИ</span></a>
		</div>
		<div class="b-item">
			<p><?=$about['text_masters'];?></p>
			<div class="b-img"><img src="/images/service2.jpg" alt=""></div>
			<a href="/masters"><span>НАШИ МАСТЕРА</span></a>
		</div>
	</div>
</div>

<div class="b-wrighter b-about-page-f">
	<div class="b-container">
		<p><?=$about['text_right_image_first'];?></p>
		<div class="b-call-block">
			<div class="b-title">Звоните и записывайтесь!</div>
			<div class="b-num"><?=$about['phone_right_image'];?></div>
		</div>
		<div class="b-call-block text_right_image_after_phone"><?=$about['text_right_image_after_phone'];?></div>
		<p class="white-space"><?=$about['text_podpis'];?> <img src="/images/grapch.jpg" alt=""></p>
	</div>