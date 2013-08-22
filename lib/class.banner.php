<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';

class banner
{

    private $_db;

    private $id;                //id
    private $img;               //баннер
    private $firstStr;          //первая строка
    private $secondStr;         //вторая строка
    private $thirdStr;          //третья строка
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
            $this->img          = '';
            $this->firstStr     = '';
            $this->secondStr    = '';
            $this->thirdStr     = '';
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
            $this->img          = $args[1];
            $this->firstStr     = $args[2];
            $this->secondStr    = $args[3];
            $this->thirdStr     = $args[4];
            $this->show         = $args[5];
            $this->dateCreate   = $args[6];
            $this->userCreate   = $args[7];
            $this->dateUpdate   = $args[8];
            $this->userUpdate   = $args[9];
            $this->deleted      = $args[10];

        }
    }

    private function set_product($id){
        if($id>0){
            $sql="SELECT * FROM banners WHERE id=".$id;
            $this->_db->query($sql);
            $res = $this->_db->getRow();
            if(empty($res)){
                return false;
            }
            else{
                $this->id           = $res['id'];
                $this->img          = $res['img'];
                $this->firstStr     = $res['firstStr'];
                $this->secondStr    = $res['secondStr'];
                $this->thirdStr     = $res['thirdStr'];
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

    public function get_img(){
        return $this->img;
    }

    public function get_firstStr(){
        return $this->firstStr;
    }

    public function get_secondStr(){
        return $this->secondStr;
    }

    public function get_thirdStr(){
        return $this->thirdStr;
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

    public function set_img($value){
        $this->img = $value;
    }

    public function set_firstStr($value){
        $this->firstStr = $value;
    }

    public function set_secondStr($value){
       $this->secondStr = $value;
    }

    public function set_thirdStr($value){
        $this->thirdStr = $value;
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