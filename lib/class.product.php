<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';

class product
{

    private $_db;

    private $id;                //id
    private $name;              //название товара
    private $price;             //цена
    private $priceForSale;      //акутальная цена
    private $material;          //ссылка на таблицу материалов
    private $firm;              //ссылка на таблицу фирм
    private $category;          //главная категория
    private $subCategory;       //подкатегория    // ссылки на таблицу категорий
    private $img;               //крупное фото товара
    private $thumb;             //маленькое фото товара
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
            $this->price        = 0;
            $this->priceForSale = 0;
            $this->material     = 0;
            $this->firm         = 0;
            $this->category     = 0;
            $this->subCategory  = 0;
            $this->des  = '';
            $this->img      = '';
            $this->thumb        = '';
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
            $this->price        = $args[2];
            $this->priceForSale = $args[3];
            $this->material     = $args[4];
            $this->firm         = $args[5];
            $this->category     = $args[6];
            $this->subCategory  = $args[7];
            $this->img      = $args[8];
            $this->thumb        = 'm_'.$args[8];
            $this->show         = $args[9];
            $this->dateCreate   = $args[10];
            $this->userCreate   = $args[11];
            $this->dateUpdate   = $args[12];
            $this->userUpdate   = $args[13];
            $this->deleted      = $args[14];

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
                $this->id           = $res['id'];
                $this->name         = $res['name'];
                $this->price        = $res['price'];
                $this->priceForSale = $res['priceForSale'];
                $this->material     = $res['material'];
                $this->firm         = $res['firm'];
                $this->category     = $res['category_id'];
                $this->subCategory  = $res['subCategory_id'];
                $this->img      = $res['img'];
                $this->des      = $res['des'];
                $this->thumb        = 'm_'.$res['img'];
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

    public function get_price(){
        return $this->price;
    }

    public function get_priceForSale(){
        return $this->priceForSale;
    }

    public function get_material_id(){
        return $this->material;
    }

    public function get_firm_id(){
        return $this->firm;
    }


    public function get_category_id(){
        return $this->category;
    }

    public function get_subCategory_id(){
        return $this->subCategory;
    }

    public function get_img(){
        return $this->img;
    }

    public function get_thumb(){
        return $this->thumb;
    }

    public function get_show(){
        return $this->show;
    }
    public function get_des(){
        return $this->des;
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

    public function set_price($value){
        $this->price = $value;
    }

    public function set_priceForSale($value){
        $this->priceForSale = $value;
    }

    public function set_material_id($value){
        $this->material = $value;
    }

    public function set_firm_id($value){
        $this->firm = $value;
    }

    public function set_category_id($value){
        $this->category = $value;
    }

    public function set_subCategory_id($value){
        $this->subCategory = $value;
    }

    public function set_img($value){
        $this->img = $value;
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