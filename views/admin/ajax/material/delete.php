<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if($_POST){
    $id = $_POST['id'];
    echo $id;
    $user = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE materials SET
                    deleted=1,
                    userUpdate = {$user},
                    dateUpdate = '{$date}'
                    WHERE id = ".$id;
    $db->query($sql);
}