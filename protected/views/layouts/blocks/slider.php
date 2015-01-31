<div class="b-main-slider">
	<a class="arrow-left" href="#"></a>
	<a class="arrow-right" href="#"></a>
	<div class="swiper-container">
	  <div class="swiper-wrapper">
		  <?php
		$slides=Slider::model()->findAll(array('order'=>'sort DESC'));
		if($slides):
			foreach ($slides as $value): ?>
				<div class="swiper-slide">
					<img src="/images/slideshow/<?=$value->image;?>">
					<div class="b-slider-content">
						<div class="b-container">
							<div class="b-line"></div>
							<?
							if($value->text){
							$texts=explode("\n", $value->text);
							echo '<h2>'.$texts[0].'</h2>';
							if(isset($texts[1]))
							echo '<h3>'.$texts[1].'</h3>';
							}
							?>
							<a href="<?=$value->link;?>" class="b-slider-link"><?=CHtml::encode($value->name);?></a>
						</div>
					</div>
				</div>
			<? endforeach;
		endif; ?>
	  </div>
	</div>
	<div class="b-container">
		<div class="pagination"></div>
	</div>
</div>