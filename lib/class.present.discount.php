<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';

class present_discount extends discount
{
    private $_db;

    private $id;                      //id
    private $product_id;              //код товара с подарком
    private $present_id;              //код самого подарка
    private $available;               //Доступно подарков
    private $sold;                    //из них продано
    private $on;                      //признак подключения дисконта



    public function __construct(){
        $this->_db = db::getInstance();

        if(func_num_args() == 0)
        {
            return false;
        }
        else
        {
            if(func_num_args() == 1)
            {
                $args = func_get_args();
                $sql = "SELECT * FROM presents WHERE product_id = ".$args[0];
                $this->_db->query($sql);
                if($this->_db->getCount()>0)
                {
                    $row = $this->_db->getRow();
                    $this->id            = $row['id'];
                    $this->product_id    = $args[0];
                    $this->present_id    = $row['present_id'];
                    $this->available     = $row['available'];
                    $this->sold          = $row['sold'];
                    $this->on            = $row['on'];
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $args = func_get_args();
                $this->id            = $args[0];
                $this->product_id    = $args[1];
                $this->present_id    = $args[2];
                $this->available     = $args[3];
                $this->sold          = $args[4];
                $this->on            = $args[5];
            }
        }
    }



    public function showPresents(){
        if($this->sold < $this->available)
        {
            return true;
        }
        else
        {
            return false;
        }
    }



    public function get_id(){
        return $this->id;
    }

    public function get_product_id(){
        return $this->product_id;
    }

    public function get_present_id(){
        return $this->present_id;
    }

    public function get_available(){
        return $this->available;
    }

    public function get_sold(){
        return $this->sold;
    }

    public function get_on(){
        return $this->on;
    }
}