<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.db.manager.php';
require_once $root.'/lib/class.sms.php';
$dm = new db_manager();

if($_POST)
{
    $name = trim($_POST['name_cb']);
    if($name == ''){
        echo json_encode(array('err'=>'Укажите ваше имя'));
        exit;
    }
    $phone = preg_replace('/[\s()]/','',$_POST['phone_cb']);
    if($phone == '' OR strpos('_',$_POST['phone_cb']))
    {
        echo json_encode(array('err'=>'Введите номер телефона'));
        exit;
    }
    $time = trim($_POST['time']);

    $mess  = '<table style="width:615px; background: #fff; padding: 10px;" border="1">';
    $mess .= '<tr>';
    $mess .= '<td colspan="2" style="font-weight: bold">Заявка на обратный звонок</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Время подачи заявки</td>';
    $mess .= '<td style="width:200px">'.date('d.m.Y H:i:s').'</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Имя</td>';
    $mess .= '<td style="width:200px">'.$name.'</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Номер телефона</td>';
    $mess .= '<td style="width:200px">'.$_POST['phone_cb'].'</td>';
    $mess .= '</tr>';
    if($time != ''){
        $mess .= '<tr>';
        $mess .= '<td style="width:200px">Удобное время для звонка</td>';
        $mess .= '<td style="width:200px">'.$time.'</td>';
        $mess .= '</tr>';
    }
    $mess .= '</table>';

    $subject = '=?utf-8?B?'.base64_encode("Заявка на обратный звонок").'?=';
    $headers = "Content-type: text/html; charset=utf-8 \r\n";
    $headers .= 'From:' .'=?utf-8?B?'.base64_encode("STOCK-CLOCK ").'?='. '<support@stock-clock.com.ua>' . "\r\n" ;
    mail('laetrile@yandex.ua', $subject, $mess, $headers);
    mail('abz@inbox.ru', $subject, $mess, $headers);

    $sms = new sms();
    $sms->setLogin('stockclock');
    $sms->setPass('+380501327370');
    if($sms->auth())
    {
        $sms->sendsms('stock-clock','+380501327370','Заявка на обратный звонок. '.$name.' номер: '.$phone);
        $sms->sendsms('stock-clock','+380954570088','Заявка на обратный звонок. '.$name.' номер: '.$phone);
        //$sms->sendsms('abz.dn.ua',$phone,'Спасибо за заявку, ожидайте звонка менеджера');
    }

    echo json_encode(array('mess'=>'ok'));
}