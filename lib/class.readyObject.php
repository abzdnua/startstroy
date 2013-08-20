<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';

class readyObject
{

    private $_db;

    private $id;                //id
    private $name;              //название
    private $img;               //фото
    private $objectDate;        //дата сдачи обьекта
    private $show;              // 1 - отображать на сайте; 0 - скрывать
    private $dateCreate;        //дата создания
    private $userCreate;        //пользователь создавший
    private $dateUpdate;        //дата изменения
    private $userUpdate;        //пользователь изменивший
    private $deleted;           //помечен на удаление






    public function __construct(){
        $this->_db = db::getInstance();
        //новый если нет параметров
        if(func_num_args()==0){
            $this->id           = 'NULL';
            $this->name         = '';
            $this->img          = '';
            $this->objectDate   = '';
            $this->show         = 0;
            $this->dateCreate   = 0;
            $this->userCreate   = 0;
            $this->dateUpdate   = 0;
            $this->userUpdate   = 0;
            $this->deleted      = 0;


        }
        else if(func_num_args()==1) { // если один параметр то по id
            $args=func_get_args();
            $this->set_product($args[0]);
        }
        else { //иначе то заполняем все поля для парсера по очереди
            $args=func_get_args();
            $this->id           = $args[0];
            $this->name         = $args[1];
            $this->img          = $args[2];
            $this->objectDate   = $args[3];
            $this->show         = $args[4];
            $this->dateCreate   = $args[5];
            $this->userCreate   = $args[6];
            $this->dateUpdate   = $args[7];
            $this->userUpdate   = $args[8];
            $this->deleted      = $args[9];

        }
    }

    private function set_product($id){
        if($id>0){
            $sql="SELECT * FROM objects WHERE id=".$id;
            $this->_db->query($sql);
            $res = $this->_db->getRow();
            if(empty($res)){
                return false;
            }
            else{
                $this->id           = $res['id'];
                $this->name         = $res['name'];
                $this->img          = $res['img'];
                $this->objectDate   = $res['objectDate'];
                $this->show         = $res['show'];
                $this->dateCreate   = $res['dateCreate'];
                $this->userCreate   = $res['userCreate'];
                $this->dateUpdate   = $res['dateUpdate'];
                $this->userUpdate   = $res['userUpdate'];
                $this->deleted      = $res['deleted'];

            }
        }
    }


    //get-методы струкрура get_+название переменной

    public function get_id(){
        return $this->id;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_img(){
        return $this->img;
    }

    public function get_objectDate(){
        return $this->objectDate;
    }

    public function get_show(){
        return $this->show;
    }

    public function get_dateCreate(){
        return $this->dateCreate;
    }

    public function get_userCreate_id(){
        return $this->userCreate;
    }

    public function get_dateUpdate(){
        return $this->dateCreate;
    }

    public function get_userUpdate_id(){
        return $this->userCreate;
    }

    public function get_deleted(){
        return $this->deleted;
    }



    //set-методы струкрура set_+название переменной


    public function set_id($value){
        $this->id = $value;
    }
    public function set_name($value){
        $this->name = $value;
    }

    public function set_img($value){
        $this->img = $value;
    }

    public function set_objectDate($value){
        $this->objectDate = $value;
    }

    public function set_show($value){
        $this->show = $value;
    }

    public function set_dateCreate($value){
        $this->dateCreate = $value;
    }

    public function set_userCreate_id($value){
        $this->userCreate = $value;
    }

    public function set_dateUpdate($value){
        $this->dateCreate = $value;
    }

    public function set_userUpdate_id($value){
        $this->userCreate = $value;
    }
    public function set_deleted($value){
        $this->deleted = $value;
    }

}