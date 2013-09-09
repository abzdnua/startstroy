<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';


require_once $root."/lib/class.db.manager.php";

$dm = new db_manager();
$db = db::getInstance();
if($_POST){
    $id = $_POST['id'];
    $db->query("SELECT * FROM partners WHERE id = ".$id);
    $p = $db->getRow();
    echo '<td colspan="8" style="padding: 10px;">
    <div style="font:10pt Verdana;">Добавить нового партнера</div>
    <div class="silver">Поля отмеченные <span class="required">*</span> обязательны к заполнению</div>
    <form method="post">
        <input type="hidden" name="id" value="'.$p['id'].'">
        <table align="center" border="none" width="100%">
            <tr>
                <td align="right">Название<span class="required">*</span></td>
                <td style="width: 630px"><input type="text" style="width: 100%"name="partner_name" value="'.$p['name'].'"></td>
                <td style="vertical-align:middle" rowspan="5"><button type="button" name="save">Сохранить</button> </td>
            </tr>
            <tr>
                <td align="right">Отображать на сайте</td>
                <td><input type="checkbox" name="show" '.(($p['show'])?"checked=checked":"").'/></td>

            </tr>
            <tr>
                <td align="right">Описание<span class="required">*</span></td>
                <td style="width: 350px"><textarea rows=3 style="width: 100%"name="partner_des">'.$p['des'].'</textarea></td>
            </tr>
            <tr>
                <td align="right">Картинка<span class="required">*</span></td>
                <td style="width: 350px"><input type="file" style="width: 100%"name="partner_img">
                    <input type="hidden" name="partner_img_val" value="'.$p['img'].'">
                    <img id="id_img_edit" src="/img/partners/'.$p['img'].'"/>
                </td>
            </tr>
            <tr>
                <td align="right">Ссылка</td>
                <td style="width: 350px"><input type="text" style="width: 100%" name="partner_link" value="'.$p['link'].'"></td>

            </tr>
        </table>
    </form>
</td>';
}