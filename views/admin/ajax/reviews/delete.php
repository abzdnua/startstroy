<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if($_POST){
    $id = $_POST['id'];
    $sql = "UPDATE reviews SET deleted=1 WHERE id = ".$id;
    $db->query($sql);
}