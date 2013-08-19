<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if(!empty($_POST['present']))
{
    $sql = "SELECT name FROM products WHERE id=".$_POST['present'];
    $db->query($sql);
    if($db->getCount()>0)
    {
        $p = $db->getValue();
        echo '<div class="del_present" title="Удалить подарок"><img src="sc_img/admin/remove.png" /></div>';
        echo '<div style="margin: 20px 0;"><img src="sc_img/surprize.png"> Подарок: '.$p.'</div>';
        echo '<input type="hidden" name="with_present" value="1" />';
        echo '<input type="hidden" name="present_id" value="'.$_POST['present'].'" />';
        echo '<div style="margin-bottom: 3px;font-weight: bold;">Количество подарков</div>';
        echo '<div><input type="text" name="present_count" value=""/> шт.</div>';
        echo '<div style="margin-top: 20px;font-weight: bold;color: rgb(114, 19, 19);">Временно приостановить выдачу подарков
              <input type="checkbox" name="on_present" title="В данном случае скидка будет отключена, но вы сможете восстановить ее действие"/>
              </div>';
    }
    else
    {
        echo '<div>Подарок не найден в базе данных</div>';
    }
}
else
{
    echo 0;
}