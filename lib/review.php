<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/class.invis.db.php";
$db = db::getInstance();

if($_POST)
{
    $name = trim($_POST['name']);
    $city = trim($_POST['city']);
    $mail = trim($_POST['e-mail']);
    $review = $_POST['review'];
    if($name == '')
    {
        echo json_encode(array('err'=>'Введите имя'));
        exit;
    }

    if($mail == '')
    {
        echo json_encode(array('err'=>'Введите адрес электронной почты'));
        exit;
    }

    if($review == '')
    {
        echo json_encode(array('err'=>'Оставьте ваш отзыв'));
        exit;
    }

    $sql = "INSERT INTO reviews(name,city,mail,comment,date_create,`show`) VALUES ('".$name."','".$city."','".$mail."','".$review."',NOW(),0)";
    $db->query($sql);
    echo json_encode(array('mess'=>'ok'));
}
else
{
    echo json_encode(array('err'=>'Заполните поля'));
}
