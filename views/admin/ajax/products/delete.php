<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
$db  = db::getInstance();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $del_pr = "DELETE FROM products WHERE id=".$id;
    $del_pi = "DELETE FROM product_items WHERE product_id =".$id;
    $del_timer = "DELETE FROM timers WHERE product_id =".$id;
    $del_count = "DELETE FROM restriction_by_count_discount WHERE product_id =".$id;
    $del_present = "DELETE FROM presents WHERE product_id =".$id;
    $db->query($del_pr);
    $db->query($del_pi);
    $db->query($del_timer);
    $db->query($del_count);
    $db->query($del_present);


    $sql = "SELECT photo FROM photo_gallery WHERE product_id =".$id;
    $db->query($sql);
    if($db->getCount()>0)
    {
        $arr = $db->getArray();
        foreach($arr as $key=>$val)
        {
            if(file_exists('sc_img/product/'.$val['photo']))
            {
                unlink('sc_img/product/'.$val['photo']);
            }
        }
        $del_photo = "DELETE FROM photo_gallery WHERE product_id =".$id;
        $db->query($del_photo);
    }

}