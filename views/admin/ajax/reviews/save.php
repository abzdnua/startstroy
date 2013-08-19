<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if($_POST){
    $name = $_POST['name'];
    $city = $_POST['city'];
    $mail = $_POST['mail'];
    $comment = $_POST['review'];
    $show = ($_POST['show'] == 'on')?1:0;

    if($_POST['action'] == 'add'){
        $sql = "INSERT INTO reviews(name,city,mail,comment,date_create,`show`) VALUES ('".$name."','".$city."','".$mail."','".$comment."',NOW(),".$show.")";
        $db->query($sql);
    }

    if($_POST['action'] == 'edit'){
        $id = $_POST['id'];
        $sql = "UPDATE reviews SET name='".$name."',city='".$city."',mail='".$mail."',comment='".$comment."',`show`='".$show."' WHERE id=".$id;
        $db->query($sql);
    }
}