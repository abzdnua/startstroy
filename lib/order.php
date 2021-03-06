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
    $mess  .= '<tr>
        <td align="left" style="border-right:none"><br><a href="http://'.$_SERVER['SERVER_NAME'].'"><img src="http://'.$_SERVER['SERVER_NAME'].'/img/logo.png" alt="Logo" title="На главную"></a><br><br></td>
        <td align="right" style="border-left:none;font: bold 18px/22px arial;">+380 (95) 384-89-99<br>+380 (66) 908-66-63</td>
    </tr>';

    $mess .= '<tr>';
    $mess .= '<td colspan="2" style="font-weight: bold">Заказ № '.$idGen.'</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Время заказа</td>';
    $mess .= '<td style="width:200px">'.date('d.m.Y H:i:s').'</td>';
    $mess .= '</tr>';

    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Товар</td>';
    $mess .= '<td style="width:200px"><img src="http://'.$_SERVER['SERVER_NAME'].'/img/products/'.((is_file($_SERVER['DOCUMENT_ROOT'].'/img/products/m_'.$p->get_img()))?'m_'.$p->get_img():'no_prod_min.png').'" style="float:left" ><div style="clear:both"></div>'.$p->get_name().'</td>';
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
    mail('abz@inbox.ru', $subject, $mess, $headers);
    if($email) mail($email, $subject, $mess, $headers);
    mail('artygeneration@gmail.com', $subject, $mess, $headers);

    $sms = new sms();
    $sms->setLogin('abz');
    $sms->setPass('zayaccool');
    if($sms->auth())
    {
//        $sms->sendsms('StartStroy','','Заказ с сайта на покупку часов. Проверьте почту');
        $sms->sendsms('abz.dn.ua','+380954570088','Новый заказ на сайте. Проверьте почту');
        if(date('G') >= 10 and date('G') < 18)
    {
        $textUser = "Заказ №".$idGen."\nОжидайте звонка менеджера\nБлагодарим за покупку";
    }else{
        if(date('G') >= 5 and date('G') < 10)
        {
            $textUser = "Заказ №".$idGen."\nОжидайте звонка менеджера после 10:00\nБлагодарим за покупку";//"Спасибо за Вашу заявку №$idGen\nМы свяжемся с Вами после 10:00.";
        }
        else
        {
            $textUser = "Заказ №".$idGen."\nОжидайте звонка менеджера завтра после 10:00\nБлагодарим за покупку";//"Спасибо за Вашу заявку №$idGen\nМы свяжемся с Вами завтра после 10:00.";
        }
    }
    $sms -> sendsms('abz.dn.ua',$phone,$textUser);
    }
    echo json_encode(array('err'=>''));
}