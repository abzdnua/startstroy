<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if(!empty($_POST))
{
    if($_POST['hours_start'] == $_POST['hours_end'] && $_POST['minutes_start'] == $_POST['minutes_end'])
    {
        echo json_encode(array('err' => 'Нельзя, чтобы время начала и окончания периода совпадали'));
        exit;
    }
    else
    {
        if(!is_numeric($_POST['percent']))
        {
            echo json_encode(array('err' => 'Размер скидки должен быть числом'));
        }
        else
        {
            if($_POST['percent'] > 100 OR $_POST['percent'] < 0)
            {
                echo json_encode(array('err' => 'Размер скидки должен быть числом от 0 до 100'));
            }
            else
            {
                $time_start = $_POST['hours_start'].":".$_POST['minutes_start'].":00";
                $time_end   = $_POST['hours_end'].":".$_POST['minutes_end'].":00";
                $percent    = $_POST['percent'];

                $sql = "UPDATE night_discount SET time_start = '".$time_start."', time_end = '".$time_end."', percent = '".$percent."' WHERE id = 1";
                $success = $db->query($sql);
                if($success){
                    echo json_encode(array('mess' => 'ok'));
                }
                else{
                    echo json_encode(array('err'=>'Ошибка соединения с БД'));
                }
            }
        }
    }
}
else
{
    echo json_encode(array('err'=>'Заполните все поля'));
}