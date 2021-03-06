<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';

class category
{

    private $_db;

    private $id;                //id
    private $name;              //название
    private $link;              //ЧПУ
    private $parent_id;         //родительская категория // 0 - основная категория
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
            $this->link         = '';
            $this->parent_id    = 0;
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
            $this->link         = $args[2];
            $this->parent_id    = $args[3];
            $this->dateCreate   = $args[4];
            $this->userCreate   = $args[5];
            $this->dateUpdate   = $args[6];
            $this->userUpdate   = $args[7];
            $this->deleted      = $args[8];

        }
    }

    private function set_product($id){
        if($id>0){
            $sql="SELECT * FROM categories WHERE id=".$id;
            $this->_db->query($sql);
            $res = $this->_db->getRow();
            if(empty($res)){
                return false;
            }
            else{
                $this->id           = $res['id'];
                $this->name         = $res['name'];
                $this->link         = $res['link'];
                $this->parent_id    = $res['parent_id'];
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

    public function get_link(){
        return $this->link;
    }

    public function get_parent_id(){
        return $this->parent_id;
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

    public function set_link($value){
        $this->link = $value;
    }

    public function set_parent_id($value){
        $this->parent_id = $value;
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