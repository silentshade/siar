<div class="page-lead"> <!-- Page leading text -->
	<h2 class="h2-red">Контакты</h2>
	<hr class="page-lead__hr">
</div>

<div class="page-content page-contacts"> <!-- Page welcome text -->
	<?=$model->text;?>
</div>

<? $this->widget('feedback.widgets.FeedbackWidget'); ?>