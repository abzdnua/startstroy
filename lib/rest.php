<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.db.manager.php';
$dm = new db_manager();

if($_POST){
    $a = $_POST['a'];
    $out = array();
    foreach($a AS $id){
        $cd   = $dm->getFullInfoAboutCountByProductId($id);
        $rest = $cd->get_available() - $cd->get_sold();
        array_push($out,array('id'=>$id,'rest'=>$rest));
    }
   echo json_encode($out);
}