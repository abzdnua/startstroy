<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';

class count_discount extends discount
{
    private $_db;

    private $id;                 //id
    private $product_id;         //id товара
    private $percent;            //размер скидки
    private $available;          //Товаров на складе
    private $sold;               //Из них продано
    private $on;                 //Показатель подключения скидки

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
                $sql = "SELECT * FROM restriction_by_count_discount WHERE product_id =".$args[0];
                $this->_db->query($sql);
                if($this->_db->getCount()>0)
                {
                    $row = $this->_db->getRow();
                    $this->id             = $row['id'];
                    $this->product_id     = $args[0];
                    $this->percent        = $row['percent'];
                    $this->available      = $row['available'];
                    $this->sold           = $row['sold'];
                    $this->on             = $row['on'];
                }
                else
                {
                    return false;
                }

            }
            else
            {
                $args=func_get_args();
                $this->id                    = $args[0];
                $this->product_id            = $args[1];
                $this->persent               = $args[2];
                $this->available             = $args[3];
                $this->sold                  = $args[4];
                $this->on                    = $args[5];
            }
        }
    }


    //Получить скидку
    public function getDiscount(){
        if($this->sold < $this->available)
        {
            return $this->percent;
        }
        else
        {
            return 0;
        }
    }

    //Проверка остались ли еще товары
    public function is_rest(){
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

    public function get_percent(){
        return $this->percent;
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