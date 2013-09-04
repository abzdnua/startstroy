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
        $db->query("INSERT INTO clients (name,phone) VALUES ('{$name}','{$phone}')");
        $client_id = $db->last();
    }else{
        $client_id =$db->getValue();
        $db->query("UPDATE clients SET name='{$name}' WHERE id={$client_id}");
    }
    $id=$db->last();

    $sql = "INSERT INTO reviews(client_id,text,dateCreate,`show`) VALUES ({$id},'{$review}',NOW(),0)";
    $db->query($sql);


    echo json_encode(array('err'=>''));

    if(!empty($_FILES['upload']['name'])!=''){
        $img = new Upload($_FILES['upload']);

        if($img->image_src_x < 80 AND $img->image_src_y < 80)
        {
            echo json_encode(array('err'=>'Размер фото должен быть не менее 80*80'));
            exit();
        }
        $uniq_img = uniqid();


        $img -> file_new_name_body = 'm_'.$uniq_img;
        $img -> jpeg_quality = 100;
        $img -> image_x = 80;
        $img -> image_y = 80;
        $img ->image_resize = true;
        $img -> process($pathToSaveImg);
        $thumb_str =$uniq_img.'.'.$img->image_src_type;


        $sql = "UPDATE clients SET img = '{$thumb_str}' WHERE id = {$id}";

//       echo json_encode(array('err'=>$sql);
        $db->query($sql);


    }
}
else
{
    echo json_encode(array('err'=>'Заполните поля'));
}
