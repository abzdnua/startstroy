<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.product.php';
require_once $root.'/lib/class.article.php';
require_once $root.'/lib/class.characteristic.php';
require_once $root.'/lib/class.banner.php';
require_once $root.'/lib/class.partner.php';
require_once $root.'/lib/class.review.php';
require_once $root.'/lib/class.readyObject.php';
require_once $root.'/lib/class.category.php';
require_once $root.'/lib/class.firm.php';

class db_manager
{
    private $_db;         //БД

    public function __construct(){
        $this->_db = db::getInstance();
    }

    //Получить список товаров для админки
    //функция возвращает массив объектов класса product
    public function getProductsArray($category, $subCategory='', $start = '', $limit = ''){
        $db = $this->_db;
        if($start == '' AND $limit == '')
        {
            $l = '';
        }
        else
        {
            $l = " LIMIT ".$start." ,".$limit;
        }
        $and_cat = " AND category = ".$category;
        if($subCategory != '')
        $and_cat .= " AND subCategory = ".$subCategory;

        $sql = "SELECT id FROM products WHERE  `show` = 1 ".$and_cat." AND deleted = 0 ORDER BY dateUpdate DESC ".$l;
        $db->query($sql);
        $out = array();
        $products = $db->getArray();
        foreach($products as $product){
            $out[] = new product($product['id']);
        }
        return $out;
    }

    //Получить характеристики товара
    public function getProductCharacteristics($id){
        $sql = "SELECT name,value FROM characteristics AS ch, products AS p
                WHERE
                p.id = ch.product_id
                AND ch.product_id = ".$id."
                AND ch.deleted = 0
                ORDER BY ch.id";

        $db = $this->_db;
        $db->query($sql);
        if($db->getCount()>0)
        {
            $arr = $db->getArray();
            return $arr;
        }
        else
        {
            $a = array();
            return $a;
        }
    }
    //получить название материала
    public function getMaterialName($id){
        $sql = "SELECT name FROM materials WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }

    public function getFirmName($id){
        $sql = "SELECT name FROM firms WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }

    public function getCategoryName($id){
        $sql = "SELECT name FROM categories WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }

    public function getUserName($id){
        $sql = "SELECT name FROM admin WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }

    public function getProductCount(){
        $sql = "SELECT * FROM products WHERE show = 1 AND deleted = 0";
        $this->_db->query($sql);
        return $this->_db->getValue();
    }

    public function getFirmSelect(){
        $sql = "SELECT * FROM firms WHERE deleted = 0";
        $this->_db->query($sql);
        $firms = $this->_db->getArray();
        $list = '<select name="firm">';
        $list .='<option value="0">Выберите производителя</option>';
        if(count($firms)>0){
            foreach($firms as $firm){
                $list .= '<option value="'.$firm['id'].'">'.$firm['name'].'</option>';
            }
        }
        $list = '</select>';
        return $list;
    }

    public function getCategorySelect($name, $parent = 0){
        $sql = "SELECT * FROM categories WHERE parent_id = ".$parent." AND deleted = 0";
        $this->_db->query($sql);
        $list = '<select name="'.$name.'">';
        $list .='<option value="0">Выберите категорию</option>';
        $cats = $this->_db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $list .= '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
            }
        }
        $list .= '</select>';
        return $list;
    }

    public function getAllCategories(){
        $db = $this->_db;
        $sql = "SELECT id FROM categories WHERE deleted = 0 ORDER BY parent_id DESC";
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new category($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }
}
?>