<? $this->widget('banners.widgets.BannersWidget', array('limit'=>1, 'place'=>1)); ?>
<div class="row"> <!-- about organisation on index page-->
	<div class="index-lead__about">

		<div class="index-lead__about-left">

			<h2 class="h2-black"><?=$model->name;?></h2>
			<p class="text-12-18"><?=$model->text;?></p>

		</div>

		<div class="index-lead__about-right">

			<h2 class="h2-red"><?=$model->name2;?></h2>
			<hr class="hr">
			<div class="text">
			<?=$model->text2;?>
			</div>

		</div>
	</div>
</div>

<? $this->widget('staff.widgets.AllStaffWidget'); ?>