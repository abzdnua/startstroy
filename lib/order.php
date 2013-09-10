<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.db.manager.php';
require_once $root.'/lib/class.sms.php';
require_once $root.'/lib/class.product.php';
require_once $root.'/lib/class.dll.php';
$dm = new db_manager();
$db=db::getInstance();

if(isset($_POST))
{
    $id = $_POST['prod_id'];
    $name = trim($_POST['name']);
    if($name == ''){
        echo json_encode(array('err' => 'Введите имя'));
        exit;
    }

    $phone   = preg_replace('/[\s\(\)]/','',$_POST['phone']);
    if($phone == '' OR strpos('_',$_POST['phone'])){
        echo json_encode(array('err' => 'Введите номер телефона'));
        exit;
    }
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $idGen = $DLL->idGen();
    $db->query("SELECT id FROM clients WHERE phone = {$phone}");

    if($db->getCount()==0){
        $db->query("INSERT INTO clients (name,phone,email) VALUES ('{$name}','{$phone}','{$email}')");
        $client_id = $db->last();
    }else{
        $client_id =$db->getValue();
        $db->query("UPDATE clients SET name='{$name}', email = '{$email}' WHERE id={$client_id}");
    }
    $now = date('Y-m-d H:i:s');
    $db->query("INSERT INTO orders (`No`,client_id,product_id, comment, order_time) VALUES ({$idGen},{$client_id},{$id},'{$comment}','{$now}')");
    $p = new product($id);


    $mess  = '<table style="width:615px; background: #fff; padding: 10px; color:#333; border-collapse:collapse" border="1">';
    $mess .= '<tr>';
    $mess .= '<td colspan="2" style="font-weight: bold">Заказ № '.$idGen.'</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Время заказа</td>';
    $mess .= '<td style="width:200px">'.date('d.m.Y H:i:s').'</td>';
    $mess .= '</tr>';

    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Наименование</td>';
    $mess .= '<td style="width:200px"><img src="'.$path.'/img/product/'.$p->get_img().'" style="float:left" >'.$p->get_name().'</td>';
    $mess .= '</tr>';

    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Стоимость за единицу товара</td>';
    $mess .= '<td style="width:200px">'.$p->get_priceForSale().' грн.</td>';
    $mess .= '</tr>';

    $mess .= '<tr>';
    $mess .= '<td colspan ="2" style="font-weight: bold">';
    $mess .= 'Контактное лицо';
    $mess .= '</td>';
    $mess .= '</tr>';

    $mess .= '<tr>';
    $mess .= '<td >Имя</td>';
    $mess .= '<td>'.$name.'</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td >Номер телефона</td>';
    $mess .= '<td>'.$phone.'</td>';
    $mess .= '</tr>';
    if($comment != '')
    {
        $mess .= '<tr>';
        $mess .= '<td>Комментарий</td>';
        $mess .= '<td>'.$comment.'</td>';
        $mess .= '</tr>';
    }
    $mess .= '</table>';

//echo $mess;
    $subject = '=?utf-8?B?'.base64_encode("Заказ").'?=';
    $headers = "Content-type: text/html; charset=utf-8 \r\n";
    $headers .= 'From:' .'=?utf-8?B?'.base64_encode("StartStroy ").'?='. '<support@startstroy.com.ua>' . "\r\n" ;
//    mail('abz@inbox.ru', $subject, $mess, $headers);
    if($email) mail($email, $subject, $mess, $headers);
    mail('artygeneration@gmail.com', $subject, $mess, $headers);

//    $sms = new sms();
//    $sms->setLogin('stockclock');
//    $sms->setPass('+380501327370');
//    if($sms->auth())
//    {
//        $sms->sendsms('stock-clock','+380501327370','Заказ с сайта на покупку часов. Проверьте почту');
//        $sms->sendsms('stock-clock','+380954570088','Заказ с сайта на покупку часов. Проверьте почту');
//        $sms->sendsms('stock-clock',$phone,'Спасибо за заказ! Ожидайте звонка менеджера');
//    }
//    if($a)
//    {
//        echo json_encode(array('mess' => 'ok'));
//    }



}