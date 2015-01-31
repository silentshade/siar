<?php
/**
 * Хелпер со вспомогательными функциями, те функции,
 * которые можно использовать на всем пути приложения,
 * без создания экземпляра класса, путем вызова статических функции и свойств.
 */
class CenterServiceHelper
{
	public static $status=array(1=>'В наличии',2=>'Под заказ',3=>'Нет в наличии');
	public static $status_color=array(1=>'<span style="color:#1FE81C;">●</span> В наличии',2=>'<span style="color:red;">●</span> Под заказ',3=>'<span style="color:red;">●</span> Нет в наличии');

	public static function getCatIds($id,$ids){
		$category=Categories::model()->find(array('condition'=>'id='.$id,'select'=>'t.id'));
		if($category){
			$ids[]=$category->id;
			//self::getCatIds($category->parent, $ids);
		}

		$parent=Categories::model()->findAll(array('condition'=>'parent='.$category->id,'select'=>'t.id'));
		if($parent){
			foreach ($parent as $value) {
				$ids[]=$value->id;
				$ids=self::getCatIds($value->id, $ids);
			}
		}
		return $ids;
	}

	public static function rec_count_($gr_array,$count_gr,$parent,$count=0,$opened=false,$alias='c'){
		foreach ($gr_array as $value) {
			if($value->parent==$parent){
				if(substr_count($_SERVER['REQUEST_URI'], '-',$alias)==1 && $_GET['id']==$value->id)
					$opened=true;
				$count+=$value->count;
				$return=self::rec_count_($gr_array,$count_gr, $value->id,$count,$opened);
				$count=$return[0];
				$opened=$return[1];
			}
		}
		return array($count,$opened);
	}

	public static function thumb($imgName,$x=0,$y=0,$act="0",$roooot,$pref='n_'){

		$path = $roooot.$imgName;
		$distImg = $roooot.$pref.$imgName;

		$t = getimagesize($path) or die();
		$width = $t[0];
		$height = $t[1];
		switch ($t[2])
		{
		case 1:
			$type='GIF';
			$img=imagecreatefromgif($path);
		break;
		case 2:
			$type='JPEG';
			$img=imagecreatefromjpeg($path);
		break;
		case 3:
			$type='PNG';
			$img=imagecreatefrompng($path);
		break;
		case 6:
			$type='BMP';
			$img=imagecreatefromwbmp($path);
		break;
		}

		if($act == "crop" && ($y!=0 && $x!=0)){

				$kx = $width/$height;
				$ky = $height/$width;

			if($y >= $x){
				$xs = $y*$kx;
				$ys = $y;
			}
			else{
				$ys = $x*$ky;
				$xs = $x;
			}
			if($xs < $x){
				$xs = $x;
				$ys = $x*$ky;
			}
			if($ys < $y){
				$ys = $y;
				$xs = $y*$kx;
			}
		}
		else{
			if($y==0){
				$ys=$x*($height/$width);
				$xs = $x;
			}elseif($x==0){
				$xs=$y*($width/$height);
				$ys = $y;
			}
			else{
				$ys = $y;
				$xs = $x;
			}

		}

		$thumb=imagecreate($xs,$ys);
		$thumb = ImageCreateTrueColor($xs,$ys);
		imagecopyresampled($thumb,$img,0,0,0,0,$xs,$ys,$width,$height);

		if($act == "crop" && ($y!=0 && $x!=0)){
			$Xr = abs($ys - $y); 	//Разница в размерах
			$space_before_h = $Xr/2; 		//Размер отступа сверху/снизу

			$Xr = abs($xs - $x); 	//Разница в размерах
			$space_before_w = $Xr/2; 		//Размер отступа право/лево

			$thumb_c=imagecreate($x,$y);
			$thumb_c = ImageCreateTrueColor($x,$y);
			imagecopy($thumb_c, $thumb,0,0,$space_before_w,$space_before_h,$x,$y);
			$thumb = $thumb_c;
		}
		imagejpeg($thumb, $distImg, 79);

		return $thumb;
	}
}
