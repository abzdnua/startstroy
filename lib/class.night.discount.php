<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
class night_discount
{
    private $_db;

    private $time_start;    //Время начала действия скидки
    private $time_end;      //Время окончания действия скидки
    private $current_time;  //Текущее время
    private $percent;


    public function __construct(){
        $this->_db = db :: getInstance();
        $sql = "SELECT * FROM night_discount";
        $this->_db->query($sql);
        if($this->_db->getCount()>0){
            $arr = $this->_db->getArray();
            $this->time_start      = $arr[0]['time_start'];
            $this->time_end        = $arr[0]['time_end'];
            $this->current_time    = date('H:i:s');
            $this->percent         = $arr[0]['percent'];
        }
    }

    public function getDiscount(){
        $ts = explode(':',$this->time_start);
        $te = explode(':',$this->time_end);
        if($ts[0]<$te[0])
        {
            $start_timestamp = mktime($ts[0],$ts[1],$ts[2],date('m'), date('d'), date('Y'));
            $end_timestamp   = mktime($te[0],$te[1],$te[2],date('m'), date('d'), date('Y'));
        }
        else
        {
            $start_timestamp = mktime($ts[0],$ts[1],$ts[2],date('m'), date('d'), date('Y'));
            $end_timestamp   = mktime($te[0],$te[1],$te[2],date('m'), date('d')+1, date('Y'));
        }
        if(time()>$start_timestamp && time()<$end_timestamp)
        {
            return $this->percent;
        }
        else
        {
            return 0;
        }
    }

    public function getHourStart(){
        $ts = explode(':',$this->time_start);
        return $ts[0];
    }

    public function getHourEnd(){
        $te = explode(':',$this->time_end);
        return $te[0];
    }
}