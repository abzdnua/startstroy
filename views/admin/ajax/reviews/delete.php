<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if($_POST){
    $id = $_POST['id'];
    $sql = "DELETE FROM reviews WHERE id = ".$id;
    $db->query($sql);
}