<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.db.manager.php';
$dm = new db_manager();
$db = db::getInstance();

if(!empty($_POST))
{
    $per  =  $_POST['period'];
    $id   =  $_POST['id'];
    $c    =  $dm->getProductById($id);
    if($per == 0)
    {
        $price = $c->get_price();
        $t = $dm->getFullInfoAboutTimerByProductId($c->get_id());
        $sc = $t->get_percentDiscount();
        $newprice = floor($price*(1-$sc/100));
        $economy = $price - $newprice;
        $duration = $t->get_timer()->get_duration();
        echo json_encode(array('newprice' => $newprice ,'economy' => $economy ,'discount' => $sc,'duration' => $duration,'period'=>1)) ;
    }
    if($per == 1)
    {
        $price = $c->get_price();
        $t = $dm->getFullInfoAboutTimerByProductId($c->get_id());
        $sc = $t->get_percentDiscount2();
        $duration = $t->get_timer2()->get_duration();
        $newprice = floor($price*(1-$sc/100));
        $economy = $price - $newprice;
        echo json_encode(array('newprice' => $newprice ,'economy' => $economy ,'discount' => $sc,'duration' => $duration,'period'=>2)) ;
    }
    if($per == 2)
    {
        $t = $dm->getFullInfoAboutTimerByProductId($c->get_id());
        if($t->get_ringed() == 1)
        {
            $time_start_new = $t->get_timer()->get_time_start_in_seconds() + $t->get_timer()->get_duration() + $t->get_timer2()->get_duration();
            $date_to_db = date('Y-m-d H:i:s', $time_start_new);
            $sql = "UPDATE timers SET start_time = '".$date_to_db."' WHERE product_id=".$c->get_id();
            $db->query($sql);
            $t = $dm->getFullInfoAboutTimerByProductId($c->get_id());
            $sc = $t->get_percentDiscount();
            $price = $c->get_price();
            $newprice = floor($price*(1-$sc/100));
            $economy = $price - $newprice;
            $duration = $t->get_timer()->get_duration();
            $period = 1;
        }
        else
        {
            $price = $c->get_price();
            $sc = $c->get_discount();
            $newprice = floor($price*(1-$sc/100));
            $economy = $price - $newprice;
            $period = 0;
            $duration = 0;
        }
        echo json_encode(array('newprice' => $newprice ,'economy' => $economy ,'discount' => $sc,'duration' => $duration,'period'=>$period)) ;
    }


}