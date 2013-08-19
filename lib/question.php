<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.db.manager.php';
require_once $root.'/lib/class.sms.php';
$dm = new db_manager();

if($_POST)
{
    $name = trim($_POST['my_name']);
    if($name == ''){
        echo json_encode(array('err'=>'Укажите ваше имя'));
        exit;
    }
    $mail = trim($_POST['email']);
    if($mail == ''){
        echo json_encode(array('err'=>'Введите свой адрес электронной почты'));
        exit;
    }
    $question = trim($_POST['question']);
    if($question == ''){
        echo json_encode(array('err'=>'Введите ваш вопрос'));
        exit;
    }

    $mess  = '<table style="width:615px; background: #fff; padding: 10px;" border="1">';
    $mess .= '<tr>';
    $mess .= '<td colspan="2" style="font-weight: bold">Вопрос от посетителя сайта</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Время подачи вопроса</td>';
    $mess .= '<td style="width:200px">'.date('d.m.Y H:i:s').'</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Имя</td>';
    $mess .= '<td style="width:200px">'.$name.'</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Адрес эл. почты</td>';
    $mess .= '<td style="width:200px">'.$mail.'</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Вопрос</td>';
    $mess .= '<td style="width:200px">'.$question.'</td>';
    $mess .= '</tr>';
    $mess .= '</table>';

    $subject = '=?utf-8?B?'.base64_encode("Вопрос пользователя сайта").'?=';
    $headers = "Content-type: text/html; charset=utf-8 \r\n";
    $headers .= 'From:' .'=?utf-8?B?'.base64_encode("STOCK-CLOCK ").'?='. '<support@stock-clock.com.ua>' . "\r\n" ;
    mail('laetrile@yandex.ua', $subject, $mess, $headers);
    mail('abz@inbox.ru', $subject, $mess, $headers);

    $sms = new sms();
    $sms->setLogin('stockclock');
    $sms->setPass('+380501327370');
    if($sms->auth())
    {
        $sms->sendsms('stock-clock','+380501327370','Вопрос на сайте. Проверьте почту');
        $sms->sendsms('stock-clock','+380954570088','Вопрос на сайте. Проверьте почту');
    }

    echo json_encode(array('mess'=>'ok'));
}