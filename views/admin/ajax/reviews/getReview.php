<?php
$root = $_SERVER[DOCUMENT_ROOT];


require_once $root."/lib/class.invis.db.php";
require_once $root."/lib/class.db.manager.php";
require_once $root."/lib/class.dll.php";
$db = db::getInstance();
$dm = new db_manager();


if($_POST){
    $id = $_POST['id'];
    $sql = "SELECT * FROM reviews WHERE id = ".$id;
    $db->query($sql);
    if($db->getCount()>0){
        $row = $db->getRow();
        $checked = ($row['show'] == 1)?' checked':'';
        echo '
        <td colspan="6">
        <div id="editor_title" style="font:10pt Verdana;">Добавление нового отзыва</div>
                        <div class="silver">Поля отмеченные <span class="required">*</span> обязательны к заполнению</div>
                        <form method="post" name="add_review">
                            <input type="hidden" name="id" value="'.$row['id'].'">
                            <table align="center" border="none" width="100%">
                                <tr>
                                    <td align="right">Имя<span class="required">*</span></td>
                                    <td style="width: 630px">
                                    <input style="width:100%" type="text" name="name" value="'.$dm->getClientName($row['client_id']).'" />
                                    <input type="hidden" name="client_id" value="'.$row['client_id'].'">
                                    </td>
                                    <td style="vertical-align:middle" rowspan="3"><button type="button" name="save">Сохранить</button></td>
                                </tr>
                                <tr>
                                    <td align="right">Отзыв<span class="required">*</span></td>
                                    <td style="width: 630px"><textarea name="text"  rows="8" cols="80">'.$row['text'].'</textarea></td>
                                </tr>
                                <tr>
                                    <td align="right">Отображать</td>
                                    <td style="width: 630px"><input type="checkbox" name="show" '.(($row['show'])?"checked=checked":"").'/></td>
                                </tr>
                            </table>
                        </form>
                        </td>
                        ';
    }
}
