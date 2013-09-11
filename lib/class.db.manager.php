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
    //получить название материала
    public function getClientName($id){
        $sql = "SELECT name FROM clients WHERE id = ".$id;
        $this->_db->query($sql);
        return (($this->_db->getCount())?($this->_db->getValue()):"");
    }

    public function getFirmName($id){
        $sql = "SELECT name FROM firms WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }

    public function getCategoryName($id){
        if($id == 0)
            return 'НЕТ';
        $sql = "SELECT name FROM categories WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }

    public function getUserName($id){
        $sql = "SELECT name FROM admin WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }


    public function getImgClient($id){
        $sql = "SELECT img FROM clients WHERE id = ".$id;
        $this->_db->query($sql);
        if(is_file($_SERVER['DOCUMENT_ROOT'].'/img/client/m_'.$this->_db->getValue())){
            return 'm_'.$this->_db->getValue();
        }else{
            return 'ava_default.jpg';
        }
    }

    public function getCategory_link($id){
        $sql = "SELECT link FROM categories WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }

    public function getSubCategory_link($id){
        $sql = "SELECT link FROM categories WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }
    public function getSubCategory_name($id){
        $sql = "SELECT name FROM categories WHERE id = ".$id;
        $this->_db->query($sql);
        return $this->_db->getValue();
    }
    public function getProductCount(){
        $sql = "SELECT * FROM products WHERE show = 1 AND deleted = 0";
        $this->_db->query($sql);
        return $this->_db->getValue();
    }

    public function getFirmSelect($name,$select_id=0){
        $sql = "SELECT * FROM firms WHERE deleted = 0";
        $this->_db->query($sql);
        $firms = $this->_db->getArray();
        $list = '<select name="'.$name.'">';
        $list .='<option value="0">Выберите производителя</option>';
        if(count($firms)>0){
            foreach($firms as $firm){
                $sel = ($select_id==$firm['id'])?"selected=selected":"";
                $list .= '<option '.$sel.' value="'.$firm['id'].'">'.$firm['name'].'</option>';
            }
        }
        $list .= '</select>';
        return $list;
    }

    public function getMaterialSelect($name,$select_id=0){
        $sql = "SELECT * FROM materials WHERE deleted = 0";
        $this->_db->query($sql);
        $materials = $this->_db->getArray();
        $list = '<select name="'.$name.'">';
        $list .='<option value="0">Выберите тип материала</option>';
        if(count($materials)>0){
            foreach($materials as $material){
                $sel = ($select_id==$material['id'])?"selected=selected":"";
                $list .= '<option '.$sel.' value="'.$material['id'].'">'.$material['name'].'</option>';
            }
        }
        $list .= '</select>';
        return $list;
    }


    public function getCategorySelect($name,$select_id=0,$parent = 0){
        if($parent==-1){
            $sql = "SELECT * FROM categories WHERE deleted = 0";
        }else
        $sql = "SELECT * FROM categories WHERE parent_id = ".$parent." AND deleted = 0";
        $this->_db->query($sql);
        $list = '<select name="'.$name.'">';
        $list .='<option value="0">Выберите категорию</option>';
        $cats = $this->_db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $sel = ($select_id==$cat['id'])?"selected=selected":"";
                $list .= '<option '.$sel.' value="'.$cat['id'].'">'.$cat['name'].'</option>';
            }
        }
        $list .= '</select>';
        return $list;
    }

    public function getAllCategories(){
        $db = $this->_db;
        $sql = "SELECT id FROM categories WHERE deleted = 0 ORDER BY parent_id ASC";
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
    public function getAllCharacteristic(){
        $db = $this->_db;
        $sql = "SELECT id FROM characteristics WHERE deleted = 0 ";
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new characteristic($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }

    public function getAllPartners(){
        $db = $this->_db;
        $sql = "SELECT id FROM partners WHERE deleted = 0 ";
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new partner($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }


    public function getAllArticles($from,$count){
        $db = $this->_db;
        $sql = "SELECT id FROM articles WHERE `show`=1 AND deleted = 0 LIMIT {$from}, {$count}";
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new article($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }


    public function getAllProducts($from=0, $count=0, $cat=null){
        $db = $this->_db;
        $lim = ($count!=0)? "LIMIT ".$from.', '.$count:"";
        if($cat){
            $sql = "SELECT id FROM products WHERE (category_id={$cat} OR subCategory_id={$cat}) AND `show` = 1 AND deleted = 0 {$lim}";
        }else{
            $sql = "SELECT id FROM products WHERE `show` = 1 AND deleted = 0 {$lim}";
        }
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new product($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }
public function getTopProducts($from=0, $count=0, $cat=null){
        $db = $this->_db;
        $lim = ($count!=0)? "LIMIT ".$from.', '.$count:"";
        $sql = "SELECT id FROM products WHERE top =1 AND `show` = 1 AND deleted = 0 {$lim}";
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new product($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }
    public function getAllBanners(){
        $db = $this->_db;
        $sql = "SELECT id FROM banners WHERE deleted = 0 AND `show`=1 ";
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new banner($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }
    public function getAllReviews(){
        $db = $this->_db;
        $sql = "SELECT id FROM reviews WHERE deleted = 0 ";
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new review($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }
    public function getAllReviewsShow($from,$count){
        $db = $this->_db;
        $sql = "SELECT id FROM reviews WHERE `show` = 1 AND deleted=0 LIMIT {$from}, {$count}";
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new review($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }

    public function getAllObjects(){
        $db = $this->_db;
        $sql = "SELECT id FROM objects WHERE deleted = 0 AND `show`=1 ";
        $db->query($sql);
        $out = array();
        $cats = $db->getArray();
        if(count($cats)>0){
            foreach($cats as $cat){
                $tmp =  new readyObject($cat['id']);
                array_push($out,$tmp);
            }
        }
        return $out;
    }

}
?>