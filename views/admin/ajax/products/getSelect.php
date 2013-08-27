<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.db.manager.php';

$dm = new db_manager();
if($_POST){
    $id = $_POST['id'];

    echo $dm->getCategorySelect('subCategory_id',0,$id);
}