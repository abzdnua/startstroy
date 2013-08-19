<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';

class clock extends product
{

    private $_db;

    private $id;             //id
    private $article;        //Артикул
    private $name;           //название товара
    private $description;    //описание
    private $type;           //Тип(муж,жен,уни,дет)
    private $discount;       //Размер фиксированной скидки
    private $is_present;     //1 - подарок; 0 - товар
    private $price;          //Цена
    private $photo;          //Фото
    private $video;          //видео
    private $show;           // 1 - отображать на сайте; 0 - скрывать
    private $brand_id;       // Ссылка на справочник брендов
    private $priority;       //Приоритет от 1 до 10

    private $arr_discount;   //массив объектов класса discount



    public function __construct(){
        $this->_db = db::getInstance();
        //новый если нет параметров
        if(func_num_args()==0){
            $this->id           = 'NULL';
            $this->article      = '';
            $this->name         = '';
            $this->description  = '';
            $this->type         = 'уни';
            $this->discount     = 0;
            $this->is_present   = 0;
            $this->price        = 0;
            $this->photo        = '';
            $this->video        = '';
            $this->show         = 0;
            $this->arr_discount = '';
            $this->brand_id     = 0;
            $this->priority     = 0;
        }
        else if(func_num_args()==1) { // если один параметр то по id
            $args=func_get_args();
            $this->set_product($args[0]);
        }
        else { //иначе то заполняем все поля для парсера по очереди
            $args=func_get_args();
            $this->id           = $args[0];
            $this->article      = $args[1];
            $this->name         = $args[2];
            $this->description  = $args[3];
            $this->type         = $args[4];
            $this->discount     = $args[5];
            $this->is_present   = $args[6];
            $this->price        = $args[7];
            $this->photo        = $args[8];
            $this->video        = $args[9];
            $this->show         = $args[10];
            $this->arr_discount = $args[11];
            $this->brand_id     = $args[12];
            $this->priority     = $args[13];
        }
    }

    private function set_product($id){
        if($id>0){
            $sql="SELECT * FROM products WHERE id=".$id;
            $this->_db->query($sql);
            $res = $this->_db->getRow();
            if(empty($res)){
                return false;
            }
            else{
                $this->id            = $res['id'];
                $this->article       = $res['article'];
                $this->name          = $res['name'];
                $this->description   = $res['description'];
                $this->type          = $res['type'];
                $this->discount      = $res['discount'];
                $this->is_present    = $res['is_present'];
                $this->price         = $res['price'];
                $this->photo         = $res['photo'];
                $this->video         = $res['video'];
                $this->show          = $res['show'];
                $this->arr_discount  = '';
                $this->brand_id      = $res['brand_id'];
                $this->priority      = $res['priority'];
            }
        }
    }


    //get-методы струкрура get_+название переменной

    public function get_id(){
        return $this->id;
    }

    public function get_article(){
        return $this->article;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_description(){
        return $this->description;
    }

    public function get_type(){
        return $this->type;
    }

    public function get_discount(){
        return $this->discount;
    }

    public function get_is_present(){
        return $this->is_present;
    }

    public function get_price(){
        return $this->price;
    }

    public function get_photo(){
        return $this->photo;
    }

    public function get_video(){
        return $this->video;
    }

    public function get_show(){
        return $this->show;
    }

    public function get_arr_discount(){
        return $this->arr_discount;
    }

    public function get_brand_id(){
        return $this->brand_id;
    }

    public function get_priority(){
        return $this->priority;
    }

    public function get_brand_name_eng(){
        $db = $this->_db;
        $sql = "SELECT name_eng FROM brands WHERE id=".$this->brand_id;
        $db->query($sql);
        if($db->getCount()>0){
            $val = $db->getValue();
            return $val;
        }
    }

    public function get_brand_name(){
        $db = $this->_db;
        $sql = "SELECT name FROM brands WHERE id=".$this->brand_id;
        $db->query($sql);
        if($db->getCount()>0){
            $val = $db->getValue();
            return $val;
        }
    }


    //set-методы струкрура set_+название переменной


}