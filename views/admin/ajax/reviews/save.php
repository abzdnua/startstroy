<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if($_POST){
    $name = $_POST['name'];

    $comment = $_POST['review'];
    $show = ($_POST['show'] == 'on')?1:0;

    if($_POST['action'] == 'add'){
        $sql = "INSERT INTO reviews(text,`show`) VALUES ('".$comment."','".$show."')";
        $db->query($sql);

        $sql = "INSERT INTO clients(name) VALUES ('".$name."')";
        $db->query($sql);
    }

    if($_POST['action'] == 'edit'){
        $id = $_POST['id'];
        $sql = "UPDATE reviews SET text='".$comment."',`show`='".$show."' WHERE id=".$id;
        $db->query($sql);
    }
}