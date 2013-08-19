<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
$db  = db::getInstance();
echo $root.'/sc_img/product/'.$_POST['img'];
if(!empty($_POST['img']))
{
    if(file_exists($root.'/sc_img/product/'.$_POST['img']))
    {
        unlink($root.'/sc_img/product/'.$_POST['img']);
        $sql = "DELETE FROM photo_gallery WHERE photo='".$_POST['img']."'";
        $db->query($sql);
        echo '1';
    }
    else
    {
        echo 'error File not exists';
    }
}
else
{
 echo 'error File not exists';
}