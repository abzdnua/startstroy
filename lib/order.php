<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.db.manager.php';
require_once $root.'/lib/class.sms.php';
$dm = new db_manager();

if(isset($_POST))
{
    $id = $_POST['clock_id'];
    switch($_POST['warranty']){
        case 12:
            $add = 0;
            break;
        case 24:
            $add = 199;
            break;
        case 36:
            $add = 299;
            break;
    }

    $name = trim($_POST['name_ord']);
    if($name == ''){
        echo json_encode(array('err' => 'Введите имя'));
        exit;
    }

    $phone   = preg_replace('/[\s()]/','',$_POST['phone']);
    if($phone == '' OR strpos('_',$_POST['phone'])){
        echo json_encode(array('err' => 'Введите номер телефона'));
        exit;
    }
    $comment = $_POST['comment'];

    $c = $dm->getProductById($id);


    $mess  = '<table style="width:615px; background: #fff; padding: 10px;" border="1">';
    $mess .= '<tr>';
    $mess .= '<td colspan="2" style="font-weight: bold">Заказ</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Время заказа</td>';
    $mess .= '<td style="width:200px">'.date('d.m.Y H:i:s').'</td>';
    $mess .= '</tr>';

    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Наименование</td>';
    $mess .= '<td style="width:200px"><img src="http://stockclock.com.ua/sc_img/product/'.$c->get_photo().'_o.jpg" style="float:left" >'.$c->get_name().'</td>';
    $mess .= '</tr>';

    if($dm->hasPresent($c->get_id()))
    {
    $pd = $dm->getAllInfoAboutPresentByProductId($c->get_id());
        if($pd->showPresents())
        {
            $mess .= '<tr>';
            $mess .= '<td style="width:200px">Подарок</td>';
            $mess .= '<td style="width:200px"><img src="http://stockclock.com.ua/sc_img/surprize.png" style="float:left" >'.$dm->getProductNameById($pd->get_present_id()).'</td>';
            $mess .= '</tr>';
        }
    }

    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Гарантия</td>';
    $mess .= '<td style="width:200px">'.$_POST['warranty'].' мес.</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Начальная цена</td>';
    $mess .= '<td style="width:200px">'.$c->get_price().' грн.</td>';
    $mess .= '</tr>';
    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Скидки</td>';
    $mess .= '<td style="width:200px">';

    if($dm->hasNightDiscount())
    {
        $n = new night_discount();
        $mess .= 'Ночная скидка - '.$n->getDiscount().' %<br/>';
    }

    if($dm->hasWeekendDiscount())
    {
        $n = new day_of_week_discount();
        $mess .= 'Скидка выходного дня - '.$n->getDiscount().' %<br/>';
    }

    if($dm->hasTimer($c->get_id()))
    {
        $t = $dm->getFullInfoAboutTimerByProductId($c->get_id());
        if(!$t->get_timer()->isTimeout() OR !$t->get_timer2()->isTimeout())
        {
            $mess .= 'Скидка по таймеру - '.$t->getDiscount().' %<br/>';
        }
        else
        {
            $mess .= 'Постоянная скидка - '.$c->get_discount().' %<br/>';
        }
    }
    else
    {
        if($dm->hasCount($c->get_id()))
        {
            $cd = $dm->getFullInfoAboutCountByProductId($id);
            if($cd->is_rest())
            {
                $mess .= 'Скидка по количеству товара - '.$cd->getDiscount().' %<br/>';
            }
            else
            {
                $mess .= 'Постоянная скидка - '.$c->get_discount().' %<br/>';
            }
        }
        else
        {
            $mess .= 'Постоянная скидка - '.$c->get_discount().' %<br/>';
        }
    }
    $mess .= '</td>';
    $mess .= '</tr>';

    $mess .= '<tr>';
    $mess .= '<td style="width:200px">Итого<br />(с учетом всех скидок и гарантии)</td>';
    $itogo = $c->get_price()*(1 - $dm->getProductFullDiscount($c->get_id())/100) + $add;
    $mess .= '<td style="width:200px">'.floor($itogo).' грн.</td>';
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
    $mess .= '<td>'.$_POST['phone'].'</td>';
    $mess .= '</tr>';
    if($comment != '')
    {
        $mess .= '<tr>';
        $mess .= '<td>Комментарий</td>';
        $mess .= '<td>'.$comment.'</td>';
        $mess .= '</tr>';
    }
    $mess .= '</table>';


    $subject = '=?utf-8?B?'.base64_encode("Заказ").'?=';
    $headers = "Content-type: text/html; charset=utf-8 \r\n";
    $headers .= 'From:' .'=?utf-8?B?'.base64_encode("STOCK-CLOCK ").'?='. '<support@stock-clock.com.ua>' . "\r\n" ;
    $a = mail('laetrile@yandex.ua', $subject, $mess, $headers);
    mail('abz@inbox.ru', $subject, $mess, $headers);
    $dm->sellProduct($c->get_id());
    $dm->sellPresent($c->get_id());

    $sms = new sms();
    $sms->setLogin('stockclock');
    $sms->setPass('+380501327370');
    if($sms->auth())
    {
        $sms->sendsms('stock-clock','+380501327370','Заказ с сайта на покупку часов. Проверьте почту');
        $sms->sendsms('stock-clock','+380954570088','Заказ с сайта на покупку часов. Проверьте почту');
        $sms->sendsms('stock-clock',$phone,'Спасибо за заказ! Ожидайте звонка менеджера');
    }
    if($a)
    {
        echo json_encode(array('mess' => 'ok'));
    }



}