<? $this->headerTitle='УСЛУГИ'; ?>
<script type="text/javascript" src="/js/jquery.mCustomScrollbar.concat.min.js"></script>

<div class="b-service">
	<div class="b-text-block">
		<?=$model->text;?>
	</div>

	<div class="b-list">
		<div class="b-item">
			<div class="b-img"><a href="#"><img src="/images/service1.png" alt=""></a></div>
			<div class="b-title"><?=CHtml::encode($uslugi[0]->name);?></div>
			<div class="b-button"><a href="#service-1" class="popup" data-fancybox-width="800" data-fancybox-height="840">смотреть услуги</a></div>
			<div class="b-text"><p><?=$uslugi[0]->preview;?></p></div>
		</div>
		<div class="b-item">
			<div class="b-img"><a href="#"><img src="/images/service2.png" alt=""></a></div>
			<div class="b-title"><?=CHtml::encode($uslugi[1]->name);?></div>
			<div class="b-button"><a href="#service-2" class="popup" data-fancybox-width="800" data-fancybox-height="840">смотреть услуги</a></div>
			<div class="b-text"><p><?=$uslugi[1]->preview;?></p></div>
		</div>
		<div class="b-item">
			<div class="b-img"><a href="#"><img src="/images/service3.png" alt=""></a></div>
			<div class="b-title"><?=CHtml::encode($uslugi[2]->name);?></div>
			<div class="b-button"><a href="#service-3" class="popup" data-fancybox-width="800" data-fancybox-height="840">смотреть услуги</a></div>
			<div class="b-text"><p><?=$uslugi[2]->preview;?></p></div>
		</div>
	</div>
</div>

<div style="display:none;">
	<div class="b-popup-window" id="service-1">
		<div class="b-service-popup">
			<?=$uslugi[0]->text;?>
		</div>
	</div>
	<div class="b-popup-window" id="service-2">
		<div class="b-service-popup">
			<?=$uslugi[1]->text;?>
		</div>
	</div>
	<div class="b-popup-window" id="service-3">
		<div class="b-service-popup">
			<?=$uslugi[2]->text;?>
		</div>
	</div>
</div>