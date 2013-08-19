<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.discount.php';
require_once $root.'/lib/class.timer.php';

class timer_discount extends discount
{
    private $_db;         //БД

    private $id;
    private $product_id;
    private $percentDiscount;            //Скидка по 1 таймеру
    private $percentDiscount2;           //Скидка по 2 таймеру
    private $timer;                      //объект класса timer
    private $timer2;                     //объект класса timer
    private $on;                         //Признак работы таймера
    private $ringed;                     //Признак работы таймера


    public function __construct(){
        $this->_db = db::getInstance();
        if(func_num_args()==0)
        {
            return false;
        }
        else
        {
            if(func_num_args()==1)
            {
                $args = func_get_args();
                $sql = "SELECT * FROM timers WHERE product_id=".$args[0];
                $this->_db->query($sql);
                if($this->_db->getCount()>0)
                {
                    $row = $this->_db->getRow();

                    $this->id                  = $row['id'];
                    $this->product_id          = $args[0];
                    $this->percentDiscount     = $row['percent'];
                    $this->percentDiscount2    = $row['percent2'];
                    $this->timer               = new timer($row['start_time'],$row['duration']);
                    //Устанавливаем время старта 2-го таймера
                    $start_time2 = date('Y-m-d H:i:s',$this->timer->translateToSeconds($row['start_time'])+$row['duration']);
                    $this->timer2              = new timer($start_time2,$row['duration2']);
                    $this->on                  = $row['on'];
                    $this->ringed              = $row['ringed'];
                }
            }
            else
            {
                $args=func_get_args();
                $this->id                    = $args[0];
                $this->product_id            = $args[1];
                $this->percentDiscount       = $args[3];
                $this->percentDiscount2      = $args[4];
                $this->timer                 = $args[5];
                $this->timer2                = $args[6];
                $this->on                    = $args[7];
                $this->ringed                = $args[8];
            }
        }
    }


    //Получить скидку
    public function getDiscount(){
        if($this->timer->isTimeout())
        {
            if($this->timer2->isTimeout())
            {
                return 0;
            }
            else
            {
                return $this->percentDiscount2;
            }
        }
        else
        {
            return $this->percentDiscount;
        }
    }


    //get_functions
    public function get_id(){
        return $this->id;
    }

    public function get_product_id(){
        return $this->product_id;
    }

    public function get_percentDiscount(){
        return $this->percentDiscount;
    }

    public function get_percentDiscount2(){
        return $this->percentDiscount2;
    }

    public function get_timer(){
        return $this->timer;
    }

    public function get_timer2(){
        return $this->timer2;
    }

    public function get_on(){
        return $this->on;
    }

    public function get_ringed(){
        return $this->ringed;
    }


    //Функция вернет дату начала в формате необходимом для редактирования
    public function get_smart_date(){
        $d = $this->timer->get_start_time();
        $d = explode(' ', $d);
        $date = explode('-',$d[0]);
        $date = $date[2].".".$date[1].".".$date[0];
        $time = explode(':', $d[1]);
        $hours = $time[0];
        $minutes = $time[1];
        $out = array('date' => $date, 'hours'=>$hours, 'minutes' => $minutes);
        return $out;
    }


}