<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';

class day_of_week_discount
{

    private $_db;

    private $presentTime;         //текущий день недели
    private $percent;

    public function __construct(){
        $db = $this->_db;
        $db = db::getInstance();
        $sql = "SELECT percent FROM day_of_week_discount WHERE id = 1";
        $db->query($sql);
        $this->percent = $db->getValue();
        $this->presentTime = date('w');

    }

    //Получить скидку в зависимости от дня недели
    public function getDiscount(){
        if($this->presentTime == 0 || $this->presentTime == 6)
        {
            return $this->percent;
        }
        else
        {
            return 0;
        }
    }
}