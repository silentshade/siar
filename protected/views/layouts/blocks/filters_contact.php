<div style=" background-color: #C1C1C1; padding:15px; font-size:12px; line-height:1em"  class="same_height">
	<form action="/catalog/search" method="get" id="filters-catalog-index">
		<div>
			<span>Ширина</span>
			<?=CHtml::dropDownList('size_width', isset($_GET['size_width']) ? $_GET['size_width'] : '', CHtml::listData(ItemsSizeWidth::model()->findAll(array(
			'select'=>'t.id,t.name',
			'order'=>'t.name'
			)), 'id', 'name'),array('empty'=>'Все'));?>
		</div>

		<div>
			<span>Профиль</span>
			<?=CHtml::dropDownList('size_height', isset($_GET['size_height']) ? $_GET['size_height'] : '', CHtml::listData(ItemsSizeHeight::model()->findAll(array(
			'select'=>'t.id,t.name',
			'order'=>'t.name'
			)), 'id', 'name'),array('empty'=>'Все'));?>
		</div>

		<div>
			<span>Диаметр</span>
			<?=CHtml::dropDownList('size_duym', isset($_GET['size_duym']) ? $_GET['size_duym'] : '', CHtml::listData(ItemsSizeDuym::model()->findAll(array(
			'select'=>'t.id,t.name',
			'order'=>'t.name'
			)), 'id', 'name'),array('empty'=>'Все'));?>
		</div>

		<div>
			<span>Сезон</span>
			<?=CHtml::dropDownList('sezon', isset($_GET['sezon']) ? $_GET['sezon'] : '', CHtml::listData(ItemsSezon::model()->findAll(array(
			'select'=>'t.id,t.name',
			)), 'id', 'name'),array('empty'=>'Все'));?>
		</div>

		<div class="f-submit">
			<input class="btn btn-submit" type="submit" value="Поиск" name="yt0">
		</div>
	</form>
</div>