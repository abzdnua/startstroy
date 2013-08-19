<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if(!empty($_POST))
{
    if(!is_numeric($_POST['percent']))
    {
        echo json_encode(array('err' => 'Размер скидки должен быть числом'));
        exit;
    }
    else
    {
        if($_POST['percent'] > 100 OR $_POST['percent'] < 0)
        {
            echo json_encode(array('err' => 'Размер скидки должен быть числом от 0 до 100'));
            exit;
        }
        else
        {
            $sql = "UPDATE day_of_week_discount SET percent = ".$_POST['percent']." WHERE id = 1";
            $res = $db->query($sql);
            if($res)
            {
                echo json_encode(array('mess' => 'ok'));
            }
            else
            {
                echo json_encode(array('err' => 'Ошибка соединения с БД'));
            }
        }
    }
}
else
{
    echo json_encode(array('err' => 'Заполните все поля'));
}