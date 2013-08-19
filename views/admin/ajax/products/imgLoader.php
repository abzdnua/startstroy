<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/sc_img/product/';

if(!empty($_POST)){
        if(!empty($_FILES)){

                list($n,$e) = $_FILES['main_img']['name'];
                $e = strtolower($e);
                switch ($e) 
                {
                    case 'jpeg':
                        $ext = 'jpg';
                        break;
                    case 'png':
                        $ext = 'png';
                        break;
                    default:
                        $ext = 'png';
                        break;
                }
                if($_POST['is_present'] != 'on')
                {
                    $uniq = uniqid();
                    $img = new upload($_FILES['main_img']);

                    if($img->image_src_x<450)
                    {
                        echo "Ошибка - ширина картинки не может быть меньше 450px";
                        exit();
                    }
                    if($img->image_src_y<426)
                    {
                        echo "Ошибка - высота картинки не может быть меньше 426px";
                        exit();
                    }
                    if($img->file_src_size>1024*1024*10)
                    {
                        echo "Ошибка - файл слишком большой";
                        exit();
                    }



                    $img -> file_new_name_body = $uniq;
                    $img -> image_convert = 'jpg';

                    if($img->image_src_x/$img->image_src_y>450/426)
                    {
                        //сколько нужно обрезать
                        $crop=(-1)*(450/426-$img->image_src_x/$img->image_src_y);
                        if ($crop%2 == 0){
                            $img->image_crop            = '0 '.($crop/2).' 0 '.($crop/2);
                        }
                        else
                        {
                            $img->image_crop            = '0 '.(int)($crop/2).' 0 '.((int)($crop/2)+1);
                        }
                    }

                    $img->image_resize          = true;
                    $img->image_y               = 426;
                    $img->image_ratio_x         = true;
                    $img->jpeg_quality = 100;
                    $img -> process($pathToSaveImg);


                    $img -> file_new_name_body = $uniq.'_m';
                    $img -> image_convert = 'jpg';
                    if($img->image_src_x/$img->image_src_y>450/426)
                    {
                        //сколько нужно обрезать
                        $crop=(-1)*(450/426-$img->image_src_x/$img->image_src_y);
                        if ($crop%2 == 0){
                            $img->image_crop            = '0 '.($crop/2).' 0 '.($crop/2);
                        }
                        else
                        {
                            $img->image_crop            = '0 '.(int)($crop/2).' 0 '.((int)($crop/2)+1);
                        }
                    }

                    $img->image_resize          = true;
                    $img->image_y               = 175;
                    $img->image_ratio_x         = true;
                    $img->jpeg_quality = 100;
                    $img -> process($pathToSaveImg);

                    $img -> file_new_name_body = $uniq.'_c';
                    $img -> image_convert = 'jpg';
                    if($img->image_src_x/$img->image_src_y>450/426)
                    {
                        //сколько нужно обрезать
                        $crop=(-1)*(450/426-$img->image_src_x/$img->image_src_y);
                        if ($crop%2 == 0){
                            $img->image_crop            = '0 '.($crop/2).' 0 '.($crop/2);
                        }
                        else
                        {
                            $img->image_crop            = '0 '.(int)($crop/2).' 0 '.((int)($crop/2)+1);
                        }
                    }

                    $img->image_resize          = true;
                    $img->image_y               = 107;
                    $img->image_ratio_x         = true;
                    $img->jpeg_quality = 100;
                    $img -> process($pathToSaveImg);

                    $img -> file_new_name_body = $uniq.'_o';
                    $img -> image_convert = 'jpg';
                    if($img->image_src_x/$img->image_src_y>450/426)
                    {
                        //сколько нужно обрезать
                        $crop=(-1)*(450/426-$img->image_src_x/$img->image_src_y);
                        if ($crop%2 == 0){
                            $img->image_crop            = '0 '.($crop/2).' 0 '.($crop/2);
                        }
                        else
                        {
                            $img->image_crop            = '0 '.(int)($crop/2).' 0 '.((int)($crop/2)+1);
                        }
                    }

                    $img->image_resize          = true;
                    $img->image_y               = 71;
                    $img->image_ratio_x         = true;
                    $img->jpeg_quality = 100;
                    $img -> process($pathToSaveImg);

                    if(!empty($_POST['photo']) AND file_exists($pathToSaveImg.$_POST['photo'].'.jpg')){
                        @unlink($pathToSaveImg.$_POST['photo'].'.jpg');
                        @unlink($pathToSaveImg.$_POST['photo'].'_c.jpg');
                        @unlink($pathToSaveImg.$_POST['photo'].'_m.jpg');
                        @unlink($pathToSaveImg.$_POST['photo'].'_o.jpg');
                    }
                    echo '<img style="margin:25px; "  src ="sc_img/product/'.$uniq.'_c.jpg"/><input type="hidden" name="photo" value="'.$uniq.'" />';
                }
                else
                {
                    $uniq = uniqid();
                    $img = new upload($_FILES['main_img']);


                    if($img->image_src_y<548)
                    {
                        echo "Ошибка - высота картинки не может быть меньше 548px";
                        exit();
                    }
                    if($img->file_src_size>1024*1024*10)
                    {
                        echo "Ошибка - файл слишком большой";
                        exit();
                    }



                    $img -> file_new_name_body = $uniq;
                    $img -> image_convert = 'jpg';

                    if($img->image_src_x/$img->image_src_y>924/548)
                    {
                        //сколько нужно обрезать
                        $crop=(-1)*(924/548-$img->image_src_x/$img->image_src_y);
                        if ($crop%2 == 0){
                            $img->image_crop            = '0 '.($crop/2).' 0 '.($crop/2);
                        }
                        else
                        {
                            $img->image_crop            = '0 '.(int)($crop/2).' 0 '.((int)($crop/2)+1);
                        }
                    }

                    $img->image_resize          = true;
                    $img->image_y               = 548;
                    $img->image_ratio_x         = true;
                    $img->jpeg_quality = 100;
                    $img -> process($pathToSaveImg);

                    if(!empty($_POST['photo']) AND file_exists($pathToSaveImg.$_POST['photo'].'.jpg')){
                        @unlink($pathToSaveImg.$_POST['photo'].'.jpg');
                    }
                    echo '<img style="margin:25px; " height="107" src ="sc_img/product/'.$uniq.'.jpg"/><input type="hidden" name="photo" value="'.$uniq.'" />';
                }

        }else{
            echo 'Ошибка, файл не загружен';
        }
   
}else{
    echo 'Ошибка, файл не загружен';
}

?>