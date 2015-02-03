<?php
/**
 * Хелпер со вспомогательными функциями, те функции,
 * которые можно использовать на всем пути приложения,
 * без создания экземпляра класса, путем вызова статических функции и свойств.
 */
class SiteHelper
{
    public static $status=array('1'=>'Есть в наличии','2'=>'Под заказ','3'=>'Нет в наличии');
	public static $yes_no=array('1'=>'Да','0'=>'Нет');
	public static $status_color=array('1'=>'<div class="b-product-avilable i-yes">Есть в наличии!</div>','2'=>'<div class="b-product-avilable i-order">Под заказ!</div>','3'=>'<div class="b-product-avilable i-no">Нет в наличии!</div>');
	public static $globalcat_name=array('1'=>'Постельное белье','2'=>'Подушки','3'=>'Одеяла','4'=>'Для подростков','5'=>'Для детей');
	public static $globalcat_url=array('1'=>'postelnoe-belie','2'=>'podushki','3'=>'odeyala','4'=>'dlya-podrostkov','5'=>'dlya-detey');

    /**
     * Get money in specific format 1234 = 1 234
     * @static
     * @param $price money number
     * @return string money in specific format
     */
    public static function GetMoneyFormat($price)
    {
        $price = (string)$price;
        $res = '';
        for ($i = strlen($price) - 1; $i >= 0; $i--) {
            $res .= $price{$i};
            if (((strlen($price) - $i) % 3) == 0) $res .= ' ';
        }
        return strrev($res);
    }

    public static function GetFormatWord($word, $number)
    {
        $num = $number % 10;
        if ($word == 'оценка') {
            if ($num == 1)
                return 'оценка';
            elseif ($num > 1 && $num < 5)
                return 'оценки';
            else
                return 'оценок';
        }
    }


    /**
     * Вспомогательная функция для str2url, переводит русский текст в транслит
     * @param type $string
     * @return type
     */
    public static function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'j',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '',    'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'u',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'J',   'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
			'№'=>'#'
        );
        return strtr($string, $converter);
    }
    /**
     * Получаем имя транслитом, пригодным для url
     * @param string $str
     * @return string
     */
    public static function str2url($str) {
        // переводим в транслит
        $str = self::rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }

    /**
     * Функция для отправки email
     * @param string $to кому
     * @param string $from_user от кого
     * @param type $from_email от какого email
     * @param string $subject тема
     * @param type $message сообщение
     */
    public static function mail_utf8($to, $from_user, $from_email, $subject = '(Нет темы)', $message = '')
    {
        $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
        $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

        $headers = "From: $from_user <".Yii::app()->params['siteEmail'].">\r\n".
				"Reply-To: {$from_email}\r\n".
                "MIME-Version: 1.0" . "\r\n" .
                "Content-type: text/html; charset=UTF-8" . "\r\n";

        //mail('grinvi4.11@gmail.com', $subject, $message.' <br>Исходный email:'.$to, $headers);
        //if (Yii::app()->user->GetId()==8141)   mail('info@entua.com', $subject, $message.' <br>Исходный email:'.$to, $headers);
		mail($to, $subject, $message, $headers);
    }

    /**
     * Удаляем копейки, если 0 и возвращаем цену
     * @param type $param
     * @return string
     */
    public static function removeKopeyki($param)
    {
        list($price_main,$price_kopeyki)=explode('.', $param);
        //формируем окончательную цену с копейками или без
        if ($price_kopeyki=='000')
            $price=$price_main;
        else
            $price=$price_main.'.'.$price_kopeyki;
        return $price;
    }
    /**
     * Возвращает массив картинок из строки
     * @param string $images параметр вида images=name.jpg;name2.jpg
     * @return array
     */
    public static function returnArrayImagesFromDB($images)
    {
        $images=trim($images);
        $images=str_replace(array('images='),array(''),$images);
        $images=explode(';',$images);
        return array_filter($images);
    }

    public static function returnItemImageFromDB($item)
    {
		$item=Items::model()->findByAttributes(array('id' => $item,));
        $images=trim($item->images);
        $images=str_replace(array('images='),array(''),$images);
        $images=explode(';',$images);
		$images=array_filter($images);

		$images ? $images=$images[0] : $images='no_image.png';
		$img='<div style="width:50px;margin: 0 auto;"><img src="/images/small/'.$images.'"></div>';
        return $img;
    }

    /**
     * Переводит цвет из Hex формата в RGB
     * @param type $hex
     * @return type
     *
     */
    public static function HexToRGB($hex) {
        $hex = ereg_replace("#", "", $hex);
        $color = array();

        if(strlen($hex) == 3) {
        $color['r'] = hexdec(substr($hex, 0, 1) . $r);
        $color['g'] = hexdec(substr($hex, 1, 1) . $g);
        $color['b'] = hexdec(substr($hex, 2, 1) . $b);
        }
        else if(strlen($hex) == 6) {
        $color['r'] = hexdec(substr($hex, 0, 2));
        $color['g'] = hexdec(substr($hex, 2, 2));
        $color['b'] = hexdec(substr($hex, 4, 2));
        }

        return $color;
    }
    /**
     * Переводит цвет из RGB в Hex
     * @param type $r
     * @param type $g
     * @param type $b
     * @return type
     */
    public static function RGBToHex($r, $g, $b) {
        //String padding bug found and the solution put forth by Pete Williams (http://snipplr.com/users/PeteW)
        $hex = "#";
        $hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
        $hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
        $hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);

        return $hex;
    }

    /**
     * Лимитирует фуллтекст
     * @param type $text
     * @param type $limit
     * @param type $chars
     * @return type
     */
    public static function wordsLimit($text, $limit, $chars = null) {
            if( $text == '' ) return;
			$text=  strip_tags($text,'<br><br/>');

			$end_char='...';

            if (trim($text) == '') return $str;
            preg_match('/\s*(?:\S*\s*){'. (int) $limit .'}/', $text, $matches);
            if (strlen($matches[0]) == strlen($text)) $end_char = '';
            return rtrim($matches[0]).$end_char;
    }

    /**
     * Используется в переводе цены при выводе from Joomla
     * @param type $value
     * @param type $currency
     * @param type $d
     * @return type
     */
    public static function unsignZeros($value, $currency = '', $d = NULL)
    {
        if(!$d)
        {
                $last_sign_pos = 0;
                $int = floor(floatval($value));
                $fract = floatval($value) - $int;
                if(!$fract) {
					$return=strval($int) . ($currency != '' ? ' '.$currency : '');
					if($return!=0) return $return;
				}

                $fract_str = substr( strval($fract), strpos(strval($fract),'.')+1);
                for($i=0; $n=strlen($fract_str), $i<$n; $i++)
                {
                        if($fract_str[$i] != '0') $last_sign_pos = $i;
                }

                $fract_str = substr($fract_str, 0, $last_sign_pos+1);
                $return=strval($int).($fract_str!='' ? '.'.$fract_str : '') . ($currency != '' ? ' '.$currency : '');
				if($return!=0) return $return;
        }
        else
        {
                //$value = 12.2;
                $value = round($value, $d);
                //echo $value.' / ';

                $dot_pos = strpos(strval($value), '.');

                if($dot_pos === false) $int = substr( strval($value), 0);
                else $int = substr( strval($value), 0, $dot_pos);
                //echo $int.' / ';

                if($dot_pos === false) $fract = '';
                else $fract = substr( strval($value), $dot_pos+1);
                //echo $fract.' / ';

                $fract .= str_repeat('0', $d-strlen($fract));
                //echo $fract.' / ';

                $return=strval($int).','.$fract . ($currency != '' ? ' '.$currency : '');
				if($return!=0) return $return;
        }
    }

	public static function getImageIfExist($path,$full_path,$no_image,$image=''){
		if(!is_file($_SERVER['DOCUMENT_ROOT'] .$path.$image)){
			if(is_file($_SERVER['DOCUMENT_ROOT'] .$full_path.$image)){
				$image_ = Yii::app()->image->load(dirname($_SERVER['SCRIPT_FILENAME']).$full_path . $image);
				$image_->resize(200, 200, Image::AUTO);
				$image_->save(dirname($_SERVER['SCRIPT_FILENAME']).$path . $image);
				return $path.$image;
			}
		}
		if(is_file($_SERVER['DOCUMENT_ROOT'] .$path.$image)){
			return $path.$image;
		}
		else
			return $no_image;
	}

	public static function returnImagesArray($images,$only_if_exist=true)
    {
        $images=trim($images);
        $images=explode(';',$images);
        $array_images=array_filter($images);
		return $array_images;
    }

	public static function returnOneImages($images,$only_if_exist=false)
    {
        $images=trim($images);
        $images=explode(';',$images);
        $array_images=array_filter($images);
		if($only_if_exist)
			return $array_images[0];
		else
			return $array_images[0] ? $array_images[0] : 'no_image.png';
    }

	public static function returnImagesArrayFilter($images,$delete,$path)
    {
		$imagePath = $_SERVER['DOCUMENT_ROOT'] . $path;
        $images=trim($images);
        $images=explode(';',$images);
        $images=array_filter($images);
		if(is_array($images)){
			foreach ($images as $key=>$value) {
				foreach ($delete as $del=>$d) {
					if($del==$value && $d==1){
						if(is_file($imagePath.$value)) unlink($imagePath.$value);
						if(is_file($imagePath.'small/'.$value)) unlink($imagePath.'small/'.$value);
						if(is_file($imagePath.'middle/'.$value)) unlink($imagePath.'middle/'.$value);
						if(is_file($imagePath.'mini/'.$value)) unlink($imagePath.'mini/'.$value);
						unset($images[$key]);
					}
				}
			}
			if(!empty($images) && is_array($images))
				return implode(';',$images);
		}
		return '';
    }

	public static function deleteImages($delete,$path)
    {
		$imagePath = $_SERVER['DOCUMENT_ROOT'] . $path;

		foreach ($delete as $del=>$d) {
			if($d==1){
				if(is_file($imagePath.$del)) unlink($imagePath.$del);
				if(is_file($imagePath.'small/'.$del)) unlink($imagePath.'small/'.$del);
				if(is_file($imagePath.'middle/'.$del)) unlink($imagePath.'middle/'.$del);
				if(is_file($imagePath.'mini/'.$del)) unlink($imagePath.'mini/'.$del);
				if(is_file($imagePath.'big/'.$del)) unlink($imagePath.'big/'.$del);
			}
		}
		return '';
    }

	public static function getParam($param,$value='',$addthis=false,$arr_exc=''){
		$arr_exc['category']='';
		if(isset($_GET) && is_array($_GET)){
			foreach ($_GET as $key=>$v) {
				if(!isset($arr_exc[$key]))
					if($key==$param){
						if($addthis){
							$subarr=explode(',', $v);
							$subarr[]=$value;
							$subarr=array_unique($subarr);
							$subarr=array_filter($subarr);
							$str[]=$key.'='.  implode(',', $subarr);
						}else
							$str[]=$key.'='.$value;
					}else
						$str[]=$key.'='.$v;
			}
			if(!isset($_GET[$param]))
				$str[]=$param.'='.$value;
			if(!empty($str)){
				return '?'.implode('&', $str);
			}
		}
		return '?'.$param.'='.$value;
	}

	public static function excludeParam($param,$value='',$removethis=false,$arr_exc=''){
		$arr_exc['category']='';
		if(isset($_GET) && is_array($_GET)){
			foreach ($_GET as $key=>$v) {
				if(!isset($arr_exc[$key]))
					if($key!=$param){
						if(!empty($v))
							$str[]=$key.'='.$v;
					}else{
						if($removethis){
							$subarr=explode(',', $v);
							$subarr=array_unique($subarr);
							$subarr=array_filter($subarr);
							unset($subarr[array_search($value, $subarr)]);
							$tmp=implode(',', $subarr);
							if(!empty($tmp))
								$str[]=$key.'='.  $tmp;
						}else
							if(!empty($value))
								$str[]=$key.'='.$value;
					}

			}
			if(!empty($str)){
				return '?'.implode('&', $str);
			}
		}
	}

	public static function mail_with_body($to, $subject = '(Нет темы)', $view,$vars,$main='main',$pathViews)
    {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
		$mailer->IsHTML(true);


		/*if(Yii::app()->params['smtp_on']){
			$mailer->IsSMTP();
			$mailer->SMTPDebug = false;
			$mailer->SMTPAuth = true;
			if(Yii::app()->params['smtp_port']==465)
				$mailer->SMTPSecure = "ssl";
			$mailer->Port = Yii::app()->params['smtp_port'];
			$mailer->Host = Yii::app()->params['smtp_host'];
			$mailer->Username = Yii::app()->params['smtp_user'];//Yii::app()->params['adminEmail'];
			$mailer->Password = Yii::app()->params['smtp_password'];
			$mailer->From = Yii::app()->params['smtp_user'];//Yii::app()->params['adminEmail'];
		}else*/
			$mailer->From = Yii::app()->params['noreplyEmail'];




		$mailer->FromName = Yii::app()->params['fromName'];

		$mailer->AddReplyTo(Yii::app()->params['noreplyEmail'],Yii::app()->params['noreplyEmail']);
		$to=explode(',',$to);
		if($to)
			foreach ($to as $email) {
				$mailer->AddAddress(trim($email));
			}
		$mailer->CharSet = 'UTF-8';
		$mailer->Subject = $subject;
		if($pathViews)
			$mailer->setPathViews($pathViews);
		$mailer->getView($view,$vars,$main);
		$mailer->Send();
    }
}
