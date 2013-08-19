<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if($_POST){
    $id = $_POST['id'];
    $sql = "SELECT photo, description FROM products WHERE is_present = 1 AND id=".$id;
    $db->query($sql);
    if($db->getCount()>0)
    {
        $row = $db->getRow();
        echo '<img src="sc_img/product/'.$row['photo'].'.jpg" /><div class="clear"></div><div class="present_desc">'.$row['description'].'</div>';
    }
}
