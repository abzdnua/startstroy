<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.product.php';
require_once $root.'/lib/class.clock.php';
require_once $root.'/lib/class.timer.discount.php';
require_once $root.'/lib/class.present.discount.php';
require_once $root.'/lib/class.count.discount.php';
require_once $root.'/lib/class.timer.php';
require_once $root.'/lib/class.night.discount.php';
require_once $root.'/lib/class.day.of.week.discount.php';

class db_manager
{
    private $_db;         //БД

    public function __construct(){
        $this->_db = db::getInstance();
    }

    //Получить список товаров для админки
    //функция возвращает массив объектов класса clock
    public function getProductsObjArray($count = false,$type_of_show, $type, $brand,$start = '', $limit = ''){
        $db = $this->_db;
        if($start == '' AND $limit == '')
        {
            $l = '';
        }
        else
        {
            $l = " LIMIT ".$start." ,500";
        }
        switch($type){
            case 'all':
                $and = '';
                break;
            case 'woman':
                $and = " AND type='жен'";
                break;
            case 'man':
                $and = " AND type='муж'";
                break;
            case 'child':
                $and = " AND type='дет'";
                break;
            case 'unisex':
                $and = " AND type='уни'";
                break;
        }
        if($brand == '')
        {
            $and_b ='';
        }
        else
        {
            $sql = "SELECT id FROM brands WHERE name_eng='".$brand."'";
            $db->query($sql);
            if($db->getCount()>0);
            {
                $and_b = " AND brand_id =".$db->getValue();
            }
        }
        $sql = "SELECT * FROM products WHERE  `show` = 1 AND is_present = 0 ".$and.$and_b." ORDER BY priority DESC ".$l;
        $this->_db->query($sql);
        $out = array();
        if($this->_db->getCount()>0)
        {
            $pr = $this->_db->getArray();

            foreach($pr as $key => $val){
                switch($type_of_show){
                    case 'all':
                        $product = new clock($val['id'],$val['article'],$val['name'],$val['description'],$val['type'],$val['discount'],$val['is_present'],$val['price'],$val['photo'],$val['video'],$val['show'],'',$val['brand_id'],$val['priority']);
                        array_push($out, $product);
                        break;
                    case 'timer':
                        if($this->hasTimer($val['id']))
                        {
                            $t = $this->getFullInfoAboutTimerByProductId($val['id']);
                            if(!$t->get_timer()->isTimeout() OR !$t->get_timer2()->isTimeout())
                            {
                                $product = new clock($val['id'],$val['article'],$val['name'],$val['description'],$val['type'],$val['discount'],$val['is_present'],$val['price'],$val['photo'],$val['video'],$val['show'],'',$val['brand_id'],$val['priority']);
                                array_push($out, $product);
                            }
                        }
                        break;
                    case 'count':
                        if($this->hasCount($val['id']))
                        {
                            $cd = $this->getFullInfoAboutCountByProductId($val['id']);
                            if($cd->is_rest()){
                                $product = new clock($val['id'],$val['article'],$val['name'],$val['description'],$val['type'],$val['discount'],$val['is_present'],$val['price'],$val['photo'],$val['video'],$val['show'],'',$val['brand_id'],$val['priority']);
                                array_push($out, $product);
                            }
                        }
                        break;
                }
                if($limit != '')
                {
                    if (count($out) == $limit) break;
                }

            }

            if($count)
            {
                return $out;
                exit;
            }


            switch($type_of_show){
                case 'all':
                    break;
                case 'timer':
                    for($i = 0; $i< count($out)-1;$i++)
                    {
                        for($j = 0; $j < count($out) - 1; $j++)
                        {
                            $c  = $out[$j];
                            $t  = $this->getFullInfoAboutTimerByProductId($c->get_id());
                            if($t->get_timer()->isTimeout())
                            {
                                $time_left = $t->get_timer2()->GetTimeLeft();
                            }
                            else
                            {
                                $time_left = $t->get_timer()->GetTimeLeft();
                            }

                            $c1 = $out[$j+1];
                            $t1 = $this->getFullInfoAboutTimerByProductId($c1->get_id());
                            if($t1->get_timer()->isTimeout())
                            {
                                $time_left1 = $t1->get_timer2()->GetTimeLeft();
                            }
                            else
                            {
                                $time_left1 = $t1->get_timer()->GetTimeLeft();
                            }

                            if($time_left1<$time_left)
                            {
                                $temp = $out[$j];
                                $out[$j] = $c1;
                                $out[$j+1] = $temp;
                            }
                        }
                    }
                    break;
                case 'count':
                    for($i = 0; $i< count($out)-1;$i++)
                    {
                        for($j = 0; $j < count($out) - 1; $j++)
                        {
                            $c  = $out[$j];
                            $d  = $this->getProductFullDiscount($c->get_id());


                            $c1  = $out[$j+1];
                            $d1 = $this->getProductFullDiscount($c1->get_id());


                            if($d1>$d)
                            {
                                $temp = $out[$j];
                                $out[$j] = $c1;
                                $out[$j+1] = $temp;
                            }
                        }
                    }
                    break;
            }

            return $out;
        }
        else
        {
            return $out;
        }
    }

    //Получить полный список товаров по типу и отображению
    public function getProductList($type,$show){
        switch($show){
            case 'all':
                $and = '';
                break;
            case 'show':
                $and = ' AND `show` = 1 AND is_present = 0';
        }
        switch($type){
            case '':
                $where = '';
                break;
            case 'муж':
                $where = " AND type='муж'";
                break;
            case 'жен':
                $where = " AND type='жен'";
                break;
            case 'дет':
                $where = " AND type='дет'";
                break;
            case 'уни':
                $where = " AND type='уни'";
                break;
            case 'present':
                $where = " AND is_present=1";
                break;
        }
        $sql = "SELECT * FROM products WHERE 1 ".$where.$and." ORDER BY date_update DESC";
        $this->_db->query($sql);
        if($this->_db->getCount()>0)
        {
            $arr = $this->_db->getArray();
            return $arr;
        }
        else
        {
            return false;
        }

    }

    public function getProductsAllDiscounts($id){
        $arr = array();
        $sql = "SELECT id FROM presents WHERE product_id=".$id;
        $this->_db->query($sql);
        if($this->_db->getCount()>0){
            array_push($arr,'<span style="color: blue;">Подарок</span>');
        }

        $sql = "SELECT id FROM timers WHERE product_id=".$id;
        $this->_db->query($sql);
        if($this->_db->getCount()>0){
            array_push($arr,'<span style="color: #c77405;">Таймер</span>');
        }

        $sql = "SELECT id FROM restriction_by_count_discount WHERE product_id=".$id;
        $this->_db->query($sql);
        if($this->_db->getCount()>0){
            array_push($arr,'<span style="color: #f83831;">Кол-во товара</span>');
        }

        if(!empty($arr)){
            return implode(', ', $arr);
        }
        else{
            return '';
        }

    }

    //Получить характеристики товара
    public function getProductItems($id){
        $sql = "SELECT title,text FROM product_items AS pi, products AS p
                WHERE
                p.is_present = 0
                AND p.id = pi.product_id
                AND pi.product_id = ".$id." ORDER BY pi.id";

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


    //Функция возвращает объект класса clock
    public function getProductById($id){
        $db = $this->_db;
        $sql = "SELECT * FROM products WHERE id =".$id;
        $db->query($sql);
        if($db->getCount()>0)
        {
            $row = $db->getRow();
            $clock = new clock($id,$row['article'],$row['name'],$row['description'],$row['type'],$row['discount'],$row['is_present'],$row['price'],$row['photo'],$row['video'],$row['show'],'',$row['brand_id'],$row['priority']);
            return $clock;
        }
        else
        {
            return false;
        }
    }

    //Получить фотогаллерею товара
    public function getPhotoGal($id){
        $db = $this->_db;
        $sql = "SELECT photo FROM photo_gallery WHERE product_id =".$id." ORDER BY id";
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

//Проверяем, есть ли скидка с таймером
    public function hasTimer($id){
        $sql = "SELECT id FROM timers WHERE product_id=".$id;
        $this->_db->query($sql);
        if($this->_db->getCount()>0){
            return true;
        }
        else{
            return false;
        }
    }

    //Проверяем, есть ли скидка по количеству товара
    public function hasCount($id){
        $sql = "SELECT id FROM restriction_by_count_discount WHERE product_id=".$id;
        $this->_db->query($sql);
        if($this->_db->getCount()>0){
            return true;
        }
        else{
            return false;
        }
    }

    //Проверяем, есть ли закрепленные за товаром подарки
    public function hasPresent($id){
        $sql = "SELECT id FROM presents WHERE product_id=".$id;
        $this->_db->query($sql);
        if($this->_db->getCount()>0){
            return true;
        }
        else{
            return false;
        }
    }


    //Возвращает объект класса timer_discount
    public function getFullInfoAboutTimerByProductId($id){
        $db = $this->_db;
        $sql = "SELECT id FROM timers WHERE product_id=".$id;
        $db->query($sql);
        if($db->getCount()>0)
        {
            $timer = new timer_discount($id);
            return $timer;
        }
        else
        {
            return false;
        }
    }

    //Возвращает объект класса count_discount
    public function getFullInfoAboutCountByProductId($id){
        $db = $this->_db;
        $sql = "SELECT id FROM restriction_by_count_discount WHERE product_id=".$id;
        $db->query($sql);
        if($db->getCount()>0)
        {
            $count = new count_discount($id);
            return $count;
        }
        else
        {
            return false;
        }
    }


    //Возвращает объект класса present_discount
    public function getAllInfoAboutPresentByProductId($id){
        $db = $this->_db;
        $sql = "SELECT id FROM presents WHERE product_id=".$id;
        $db->query($sql);
        if($db->getCount()>0)
        {
            $present = new present_discount($id);
            return $present;
        }
        else
        {
            return false;
        }
    }

    //Возвращает название товара по его id
    public function getProductNameById($id){
        $db = $this->_db;
        $sql = "SELECT name FROM products WHERE id=".$id;
        $db->query($sql);
        if($db->getCount()>0)
        {
            $pr = $db->getValue();
            return $pr;
        }
        else
        {
            return false;
        }
    }

    public function getProductFullDiscount($id){
        $dw = new day_of_week_discount();
        $td = new night_discount();
        //Ночная и скидка выходного дня
        $discount = $dw->getDiscount()+$td->getDiscount();
        //вытаскивыем остальные скидки
        $cd = $this->getFullInfoAboutCountByProductId($id);
        $pr = $this->getProductById($id);
        $tid = $this->getFullInfoAboutTimerByProductId($id);
        if($this->hasTimer($id)){
            if(!$tid->get_timer()->isTimeout() OR !$tid->get_timer2()->isTimeout())
            {
                $discount += $tid->getDiscount();
            }
            else
            {
                $discount += $pr->get_discount();
            }

        }
        else
        {
            if($this->hasCount($id)){
                if($cd->is_rest())
                {
                    $discount += $cd->getDiscount();
                }
                else
                {
                    $discount += $pr->get_discount();
                }
            }
            else
            {
                $discount += $pr->get_discount();
            }
        }
        return $discount;
    }


    /** Получить тип отображения товара(напр товар с таймером или "скоро заканчиваются")*/
    public function getTypeOfShow($id){
        if($this->hasTimer($id))
        {
            $t = $this->getFullInfoAboutTimerByProductId($id);
            if(!$t->get_timer()->isTimeout() OR !$t->get_timer2()->isTimeout())
            {
                return 'timer';
            }
            else
            {
                return 'all';
            }
        }
        else
        {
            if($this->hasCount($id))
            {
                $cd = $this->getFullInfoAboutCountByProductId($id);
                if($cd->is_rest())
                {
                    return 'count';
                }
                else
                {
                    return 'all';
                }
            }
            else
            {
                return 'all';
            }
        }
    }

    /** Получить похожие товары */
    public function getProductCrosses($id,$type){
        $pr = $this->getProductById($id);
        $price = $pr->get_price();
        $db = $this->_db;
        $sql = "SELECT name, photo, id FROM products WHERE is_present = 0 AND id<>".$id." AND type = '".$type."' AND (price<".(1.5*$price)." AND price>".(0.5*$price).") ORDER BY date_update DESC LIMIT 0,3";
        $db->query($sql);
        $out = array();
        if($db->getCount()>0)
        {
            $out = $db->getArray();
        }
        return $out;
    }

    public function hasNightDiscount(){
        $n = new night_discount();
        if($n->getDiscount() == 0){
            return false;
        }else{
            return true;
        }
    }

    public function hasWeekendDiscount(){
        $n = new day_of_week_discount();
        if($n->getDiscount() == 0){
            return false;
        }else{
            return true;
        }
    }


    /** Продать товар(если количество ограничено)*/
    public function sellProduct($id){
        $db = $this->_db;
        if($this->hasCount($id))
        {
            $cd = $this->getFullInfoAboutCountByProductId($id);
            if($cd->is_rest())
            {
                $sql = "SELECT sold FROM restriction_by_count_discount WHERE product_id=".$id;
                $db->query($sql);
                $sold = $db->getValue();
                $sold += 1;
                $sql_upd = "UPDATE restriction_by_count_discount SET sold =".$sold." WHERE product_id=".$id;
                $db->query($sql_upd);
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }


    /** Функция уменьшает количество подарков закрепленным за товаром
     *при продаже товара */

    public function sellPresent($id){
        $db = $this->_db;
        if($this->hasPresent($id))
        {
            $pr = $this->getAllInfoAboutPresentByProductId($id);
            if($pr->showPresents())
            {
                $sql = "SELECT sold FROM presents WHERE product_id=".$id;
                $db->query($sql);
                $sold = $db->getValue();
                $sold += 1;
                $sql_upd = "UPDATE presents SET sold =".$sold." WHERE product_id=".$id;
                $db->query($sql_upd);
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}
?>