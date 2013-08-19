<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if(!empty($_POST))
{

       $is_present     = $_POST['is_present'] == 'on'?1:0;
       $show           = $_POST['show'] == 'on'?1:0;
       $article        = $_POST['article'];
       $description    = addslashes($_POST['description']);
       $photo          = $_POST['photo'];

       $name           = addslashes(trim($_POST['name']));
       if($name == ''){
           echo json_encode(array('err' => 'Название товара - обязательно поле'));
           exit;
       }

       //ПОДАРОК ЭТО ИЛИ ОБЫЧНЫЙ ТОВАР
       if($is_present == 1)
       {
           if($_POST['action'] == 'add')
           {
               $sql_prod = "INSERT INTO products(article,name,description,type,is_present,price, discount, photo,video,`show`,date_update,brand_id,priority) VALUES ('".$article."', '".$name."', '".$description."', 'под', ".$is_present.",'','', '".$photo."', '', 1, NOW(), '', '')";
           }elseif($_POST['action'] == 'edit')
           {
               $sql_prod = "UPDATE products SET article = '".$article."', name = '".$name."', description = '".$description."',type = 'под',is_present = ".$is_present.", price = '', discount = '', photo = '".$photo."', video = '', date_update = NOW()  WHERE id=".$_POST['id'];
           }


           $is_timer      = false;
           $with_present  = false;
           $is_count      = false;
       }
       else
       {
               $type           = $_POST['type'];
               $discount       = $_POST['const_discount'];

               $price          = trim($_POST['price']);
               if(!is_numeric($price) OR $price == ''){
                   echo json_encode(array('err' => 'Цена товара - обязательно поле'));
                   exit;
               }


               $video          = $_POST['video'];
               $brand_id       = $_POST['brand']==0?1:$_POST['brand'];
               $priority       = $_POST['priority'];

           if($_POST['action'] == 'add')
           {
               $sql_prod = "INSERT INTO products(
                   article,
                   name,
                   description,
                   type,
                   is_present,
                   price,
                   discount,
                   photo,
                   video,
                   `show`,
                   date_update,
                   brand_id,
                   priority)
                   VALUES (
                   '".$article."',
                   '".$name."',
                   '".$description."',
                   '".$type."',
                   ".$is_present.",
                   '".$price."',
                   '".$discount."',
                   '".$photo."',
                   '".$video."',
                   ".$show.",
                   NOW(),
                   ".$brand_id.",
                   ".$priority.")";
           }elseif($_POST['action'] == 'edit')
           {
               $sql_prod = "UPDATE products SET article = '".$article."', name = '".$name."', description = '".$description."', type = '".$type."', is_present = ".$is_present.", price = '".$price."', discount = '".$discount."', photo = '".$photo."', video = '".$video."', `show` = ".$show.", date_update = NOW(), brand_id='".$brand_id."', priority = '".$priority."' WHERE id=".$_POST['id'];
           }



           //Проверка на наличие таймера
           if(isset($_POST['with_timer_discount']))
           {
               $duration = 60*60*24*$_POST['days_d'] + 60*60*$_POST['hours_d'] + 60*$_POST['minutes_d'];
               if($duration == 0){
                   echo json_encode(array('err' => 'Длительность таймера не может быть равной нулю'));
                   exit;
               }
               $duration2 = 60*60*24*$_POST['days_d2'] + 60*60*$_POST['hours_d2'] + 60*$_POST['minutes_d2'];
               if($duration2 == 0){
                   echo json_encode(array('err' => 'Длительность таймера не может быть равной нулю'));
                   exit;
               }

               $date_get = explode('.',$_POST['date_start']);
               $date_start = $date_get[2]."-".$date_get[1]."-".$date_get[0]." ".$_POST['start_hours'].":".$_POST['minutes_start'].":00";

               $percent1 = $_POST['percent_d1'];
               if(!is_numeric($percent1)){
                   echo json_encode(array('err' => 'Скидка должна быть числом от 0 до 100'));
                   exit;
               }

               $percent2 = $_POST['percent_d2'];
               if(!is_numeric($percent2)){
                   echo json_encode(array('err' => 'Скидка должна быть числом от 0 до 100'));
                   exit;
               }

               $on_timer = $_POST['on_timer'] == 'on'?0:1;
               $ringed = $_POST['ring_timer'] == 'on'?1:0;

               $is_timer = true;
           }
           else
           {
               if($_POST['action'] == 'edit'){
                   $sql = "DELETE FROM timers WHERE product_id=".$_POST['id'];
                   $db->query($sql);
               }
               $is_timer = false;
           }


           //Проверка на наличие скидки по количеству товара
           if(isset($_POST['with_count_discount']))
           {
               $count           = $_POST['count_prod'];
               $count_percent   = $_POST['percent_cd'];

               if(trim($count) == '' )
               {
                   echo json_encode(array('err' => 'Количество товара - обязательное поле для данного типа скидки'));
                   exit;
               }

               if(!is_numeric($count_percent))
               {
                   echo json_encode(array('err' => 'Скидка должна быть числом от 0 до 100'));
                   exit;
               }

               $on_count = $_POST['on_count'] == 'on'?0:1;

               $is_count = true;
           }
           else
           {
               if($_POST['action'] == 'edit'){
                   $sql = "DELETE FROM restriction_by_count_discount WHERE product_id=".$_POST['id'];
                   $db->query($sql);
               }
               $is_count = false;
           }

           //Проверка на наличие подарка
           if(isset($_POST['with_present']))
           {
               $present_id = $_POST['present_id'];
               $present_count = $_POST['present_count'];
               if(!is_numeric($present_count) OR $present_count == 0){
                   echo json_encode(array('err' => 'Введите количество подарков'));
                   exit;
               }
               $on_present = $_POST['on_present'] == 'on'?0:1;
               $with_present = true;
           }
           else
           {
               if($_POST['action'] == 'edit'){
                   $sql = "DELETE FROM presents WHERE product_id=".$_POST['id'];
                   $db->query($sql);
               }
               $with_present = false;
           }
       }

  // ЗАПИСТЬ В БД ТОВАРА И ВСЕХ ЕГО ХАРАКТЕРИСТИК
   // echo json_encode(array('mess' => $sql_prod));
   //exit;
       $prod = $db->query($sql_prod);

       if($prod)
       {
           $last = $db->last();


           //Проверка на наличие фотоконтента
           if(isset($_POST['gallery'])){
               if($_POST['action'] == 'edit'){
                   $last = $_POST['id'];
               }
               if(!empty($_POST['gallery'])){
                   $gallery = explode(',',$_POST['gallery']);
                   foreach($gallery as $photo)
                   {
                       $sql = "SELECT id FROM photo_gallery WHERE photo ='".$photo."'";
                       $db->query($sql);
                       if($db->getCount() == 0){
                           $sql_gal = "INSERT INTO photo_gallery(product_id,photo) VALUES ('".$last."','".$photo."')";
                           $db->query($sql_gal);
                       }
                   }
               }
           }

           if($is_timer)
           {
               if($_POST['action'] == 'add'){
                   $sql_timer = "INSERT INTO timers(id,product_id,duration,duration2,percent,percent2,start_time,`on`, ringed) VALUES (NULL,'".$last."','".$duration."','".$duration2."','".$percent1."','".$percent2."','".$date_start."','".$on_timer."','".$ringed."')";
               }
               elseif($_POST['action'] == 'edit'){
                   $sql = "SELECT id FROM timers where product_id = ".$_POST['id'];
                   $db->query($sql);
                   if($db->getCount()>0){
                       $sql_timer = "UPDATE timers SET duration = '".$duration."',duration2 = '".$duration2."',percent = '".$percent1."',percent2 = '".$percent2."',start_time = '".$date_start."',`on` = '".$on_timer."',ringed = '".$ringed."' WHERE product_id =".$_POST['id'];
                   }else{
                       $sql_timer = "INSERT INTO timers(id,product_id,duration,duration2,percent,percent2,start_time,`on`, ringed) VALUES (NULL,'".$_POST['id']."','".$duration."','".$duration2."','".$percent1."','".$percent2."','".$date_start."','".$on_timer."','".$ringed."')";
                   }
               }


               $db->query($sql_timer);
           }

           if($is_count)
           {
               if($_POST['action'] == 'add'){
               $sql_count = "INSERT INTO restriction_by_count_discount(id,percent,available,sold,`on`,product_id) VALUES (NULL,'".$count_percent."','".$count."',0,'".$on_count."','".$last."')";
               }elseif($_POST['action'] == 'edit'){
                   $sql = "SELECT id FROM restriction_by_count_discount where product_id = ".$_POST['id'];
                   $db->query($sql);
                   if($db->getCount()>0){
                       $sql_count = "UPDATE restriction_by_count_discount SET percent ='".$count_percent."',available ='".$count."',`on`='".$on_count."' WHERE product_id=".$_POST['id'];
                   }else{
                       $sql_count = "INSERT INTO restriction_by_count_discount(id,percent,available,sold,`on`,product_id) VALUES (NULL,'".$count_percent."','".$count."',0,'".$on_count."','".$_POST['id']."')";
                   }
               }
                   $db->query($sql_count);
           }

           if($with_present)
           {
               if($_POST['action'] == 'add'){
               $sql_present = "INSERT INTO presents(product_id,present_id,available,sold,`on`) VALUES ('".$last."','".$present_id."','".$present_count."',0,'".$on_present."')";
               }elseif($_POST['action'] == 'edit'){
                   $sql = "SELECT id FROM presents where product_id = ".$_POST['id'];
                   $db->query($sql);
                   if($db->getCount()>0){
                   $sql_present = "UPDATE presents SET present_id ='".$present_id."',available ='".$present_count."',`on`='".$on_present."' WHERE product_id=".$_POST['id'];
                   }else{
                       $sql_present = "INSERT INTO presents(product_id,present_id,available,sold,`on`) VALUES ('".$_POST['id']."','".$present_id."','".$present_count."',0,'".$on_present."')";
                   }
               }
                   $db->query($sql_present);
           }

       //Проверка на наличие характеристик
           if($_POST['char_count'] > 0)
           {
               if($_POST['action'] == 'edit'){
                   $sql = "DELETE FROM product_items WHERE product_id =".$_POST['id'];
                   $db->query($sql);
                   $last = $_POST['id'];
               }
                   for($i = 1; $i <= $_POST['char_count']; $i++){
                       if(trim($_POST['c_name_'.$i]) != '' AND trim($_POST['c_value_'.$i]) != '')
                       {
                           $c_name = addslashes($_POST['c_name_'.$i]);
                           $c_value = addslashes($_POST['c_value_'.$i]);
                           $sql_char = "INSERT INTO product_items(product_id, title, `text`) VALUES ('".$last."','".$c_name."','".$c_value."')";
                           $db->query($sql_char);
                       }
                   }

           }
           echo json_encode(array('mess' => 'ok'));
       }

}
else
{
    echo json_encode(array('err' => 'Ошибка получения данных'));
    exit;
}