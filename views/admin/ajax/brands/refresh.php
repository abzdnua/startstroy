<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
$db = db::getInstance();

if($_POST){
    print_r($_POST);
    $name = $_POST['name'];
    $name_eng = $DLL->linkInBD($name);
    $id = $_POST['id'];
    $sql = "UPDATE brands SET name = '".$name."', name_eng = '".$name_eng."' WHERE id =".$id;
    echo $sql;
    $db->query($sql);
    echo 'OK';
}