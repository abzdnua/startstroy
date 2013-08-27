<?
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/class.invis.db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/class.dll.php';

$db = db :: getInstance();

$_POST['review'] = $DLL -> clearVar($_POST['review']);
$text = str_replace("\n", '<br />', $_POST['review']);
$name = $DLL -> clearVar($_POST['name']);

if (preg_match('/admin/', $_SERVER['HTTP_REFERER']))
{
    $phone = $_POST['phone'];
}
else
{
    $phone = preg_replace('/[^0-9\+]/','', $_POST['phone']);
     if (preg_match("/(\+\d{9,16})/", $phone, $nomber)) $phone = $nomber[0];
        
}
 
$date = $_POST['dateReview'] ? $_POST['dateReview'] : date('Y-m-d');
$show = $_POST['show'] ? 1 : 0;

 
if ($name and $text and $phone or preg_match('/admin/', $_SERVER['HTTP_REFERER']))
{
    $crop = 0;
    $imgname = $_FILES['photo']['tmp_name'];
    if($imgname)
    if(is_uploaded_file($imgname))
    {
        $imgnamenew = uniqid().'.jpg';
        $uploaddir = '/img/reviews/';
        $imgupload = $uploaddir.$imgnamenew;
        $imginfo = getimagesize($imgname);
        $root = $_SERVER['DOCUMENT_ROOT'];
        if (($imginfo[0] >= 100)and($imginfo[1] >= 100) and ($imginfo["mime"] == "image/jpeg"))
        {
            
            if (move_uploaded_file($imgname, $root.$uploaddir.'original_'.$imgnamenew)) 
            {
                if ($imginfo[0]>$imginfo[1]) 
                {
                    resize($root.$uploaddir.'original_'.$imgnamenew,$root.$imgupload,($imginfo[0]*(100/$imginfo[1])),100);
                    $crop = (int)(($imginfo[0]*(100/$imginfo[1])) - 100)/2;
                    $c = array($crop, 0, (100+$crop), 100);
                }
                else
                {
                    resize($root.$uploaddir.'original_'.$imgnamenew,$root.$imgupload,100,($imginfo[1]*(100/$imginfo[0])));
                    $crop = (int)(($imginfo[1]*(100/$imginfo[0])) - 100)/2;
                    $c = array(0, $crop, 100, (100+$crop));
                }
                if ($crop!=0) crop($root.$imgupload, $root.$imgupload,$c);
                
            }else{resize($root.$uploaddir.'original_'.$imgnamenew,$root.$imgupload,100,100);}
        }
    }
    if ($imgnamenew) $photo = $imgnamenew; else $photo = '';
    
    if ($_POST['action'] == 'edit')
    {
        if (!$photo) $photo = $_POST['img'];
        $db -> query("UPDATE reviews SET name = '{$name}' ,phone = '{$phone}' ,photo = '{$photo}' ,`date` = '{$date}' ,`text` = '{$text}', `show` = '{$show}' WHERE id = '{$_POST['id']}'");
    }
    else
        $db -> query("INSERT INTO `reviews` (`name` ,`phone` ,`photo` ,`date` ,`text`, `show`) VALUES ('".$name."','".$phone."','".$photo."','".$date."','".$text."' , '".$show."')");
    //$html = 'Имя: '.$name.'<br />E-mail: '.$email.'<br />Отзыв:<br /> '.$text.'<br /><br /><br />';
    //$html .= 'Данный отзыв можно отредактировать перейдя по <a href="http://bp.aviatravel.com.ua/" terget="_blank">этой ссылке</a>, и выбрав раздел "Отзывы".<br /><br />';
    //$html .= 'Password: <strong>Marinad</strong><br />Login: <strong>Masya_1902</strong>';
    //$headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: AviaTravel <jamp@inbox.ru>\r\n";
    //@mail('jamp@inbox.ru','«Авиа Тревел» | Новый отзыв', $html, $headers);  
    
    unset($_SESSION['review']);
    header('Location: '.preg_replace('/\/admin\/index\/.+/', '/admin/', $_SERVER['HTTP_REFERER']).'#ok');
} else {
    $_SESSION['review']['name'] = $_POST['name'];
    $_SESSION['review']['text'] = $_POST['review'];
    $_SESSION['review']['phone'] = $_POST['phone'];
    header('Location: '.preg_replace('/\/admin\/index\/.+/', '/admin/', $_SERVER['HTTP_REFERER']).'#nofullinfo');}
 
 
 
function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
        header('Location: '.$_SERVER['HTTP_REFERER'].'#badsize');
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
        header('Location: '.$_SERVER['HTTP_REFERER'].'#badformat');
		return;
    }
	if ($percent) {
		$w_o *= $w_i / 100;
		$h_o *= $h_i / 100;
	}
	if (!$h_o) $h_o = $w_o/($w_i/$h_i);
	if (!$w_o) $w_o = $h_o/($h_i/$w_i);
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,90);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}
function crop($file_input, $file_output, $crop = 'square',$percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
        header('Location: '.$_SERVER['HTTP_REFERER'].'#badsize');
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
        header('Location: '.$_SERVER['HTTP_REFERER'].'#badformat');
		return;
    }
	if ($crop == 'square') {
		$min = $w_i;
		if ($w_i > $h_i) $min = $h_i;
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;
		if ($percent) {
			$w_o *= $w_i / 100;
			$h_o *= $h_i / 100;
			$x_o *= $w_i / 100;
			$y_o *= $h_i / 100;
		}
    	if ($w_o < 0) $w_o += $w_i;
	    $w_o -= $x_o;
	   	if ($h_o < 0) $h_o += $h_i;
		$h_o -= $y_o;
	}
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}
?>