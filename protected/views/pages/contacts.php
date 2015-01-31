<? $this->headerTitle='КОНТАКТЫ';
$contacts=unserialize($model->text);
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script type="text/javascript" src="/js/jquery.mCustomScrollbar.concat.min.js"></script>

<script>
 function initialize() {
   var myLatlng = new google.maps.LatLng(<?=$contacts['location'];?>);
   var mapOptions = {
	 zoom: <?=$contacts['zoom'];?>,
	 center: myLatlng
   }
   var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

   var marker = new google.maps.Marker({
	   position: myLatlng,
	   map: map,
	   title: 'Hello World!'
   });
 }

 google.maps.event.addDomListener(window, 'load', initialize);

 </script>

	<div class="b-contact">
		<div class="b-text-block">
			 <?=$contacts['text_up'];?>

			<div class="b-call-block">
				<div class="b-num"><?=$contacts['phone'];?></div>
			</div>

			<div class="contact_address"><?=$contacts['address'];?></div>
			<p><a href="#call-from" class="b-call-button popup" data-fancybox-width="542" data-fancybox-height="461">СВЯЗАТЬСЯ С НАМИ</a></p>
		</div>
	</div>

</div>


<div style="display:none;">
	<div class="b-popup-window" id="call-from">
		<form action="/site/contact" class="b-call" id="call-from-form" autocomplete="off" method="POST">
			<div class="b-title">СВЯЗАТЬСЯ С НАМИ:</div>
			<div class="b-item-from">
				<label>Имя:</label>
				<input type="text" class="b-input-text" name="name">
			</div>
			<div class="b-item-from">
				<label>E-mail:</label>
				<input type="email" class="b-input-text" name="email">
			</div>
			<div class="b-item-from">
				<label>Cообщение / <br>Предложение:</label>
				<textarea class="b-input-text" name="text"></textarea>
			</div>
			<div class="b-button">
				<button class="b-button1">Отправить</button>
			</div>
		</form>
	</div>
</div>

<div class="b-map" id="map-canvas">