<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/img/client/';
$db = db::getInstance();

if($_POST)
{


    $name = trim($_POST['name']);
    $phone   = preg_replace('/[\s\(\)]/','',$_POST['phone']);
    $review = $_POST['review'];
    if(!empty($_FILES['upload']['name'])!=''){
        $img = new Upload($_FILES['upload']);
        $uniq_img = uniqid();
        $img -> file_new_name_body = 'm_'.$uniq_img;
        $img -> jpeg_quality = 100;
//        echo json_encode(array('err'=>$img->image_src_x));
//        echo json_encode(array('err2'=>$img->image_src_y));
        if($img->image_src_x > 80 or $img->image_src_y > 80){
            if($img->image_src_x <= $img->image_src_y){
                if($img -> image_src_y*(80/$img -> image_src_x) > 80){
                    $crop = $img -> image_src_y*(80/$img -> image_src_x) - 80;
//                    echo json_encode(array('errz'=>$crop));
                    $img->image_crop = ($crop/2).' 0 '.(($crop/2)+1).' 0';

                }
                $img -> image_x = 80;
                $img -> image_ratio_y = true;
            }else{
                if($img -> image_src_x*(80/$img -> image_src_y) > 80){
                    $crop = $img -> image_src_x*(80/$img -> image_src_y) - 80;
//                    echo json_encode(array('errq'=>$crop));
                    $img->image_crop = '0 '.($crop/2).' 0 '.(($crop/2)+1);

                }
                $img -> image_y = 80;
                $img -> image_ratio_x = true;
            }
        }
        $img ->image_unsharp = false;
        $img ->image_resize = true;
        $img -> process($pathToSaveImg);
        $thumb_str =$uniq_img.'.'.$img->image_src_type;
    }
   /* if($name == '')
    {
        echo json_encode(array('err'=>'Введите имя'));
        exit;
    }

    if($phone == '')
    {
        echo json_encode(array('err'=>'Введите телефон'));
        exit;
    }

    if($review == '')
    {
        echo json_encode(array('err'=>'Оставьте ваш отзыв'));
        exit;
    }*/
    $db->query("SELECT id FROM clients WHERE phone = {$phone}");

    if($db->getCount()==0){
        $db->query("INSERT INTO clients (name,phone,img) VALUES ('{$name}','{$phone}','{$thumb_str}')");
        $client_id = $db->last();
    }else{
        $client_id =$db->getValue();
        $db->query("UPDATE clients SET name='{$name}', img = '{$thumb_str}' WHERE id={$client_id}");
    }

    $sql = "INSERT INTO reviews(client_id,text,dateCreate,`show`) VALUES ({$client_id},'{$review}',NOW(),0)";
    $db->query($sql);


    echo json_encode(array('err'=>''));


}
else
{
    echo json_encode(array('err'=>'Заполните поля'));
}
