<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();
if($_POST){
    $id = $_POST['id'];
$db->query("SELECT * FROM objects WHERE id = ".$id);
$obj = $db->getRow();
    $checked = ($obj['show'] == 1)?' checked':'';
echo '
 <tr id="form" style="display:none;" >
                   <td colspan="6" style="padding: 10px;">
                        <div id="editor_title" style="font:10pt Verdana;">Добавить новый объект</div>
                        <div class="silver">Поля отмеченные <span class="required">*</span> обязательны к заполнению</div>
                        <form method="post">
                            <input type="hidden" name="id" value="'.$obj['id'].'">
                            <table align="center" border="none" width="100%">
                                <tr>
                                    <td align="right">Название<span class="required">*</span></td>
                                    <td style="width: 630px"><input type="text" value="'.$obj['name'].'" style="width: 100%"name="objects_name"></td>
                                    <td style="vertical-align:middle" rowspan="4"><button type="button" name="save">Сохранить</button> </td>
                                </tr>
                                <tr>
                                    <td align="right">Отображать</td>
                                    <td style="width: 350px"><input type="checkbox" name="show" '.(($obj['show'])?"checked=checked":"").'/></td>

                                </tr>
                                <tr>
                                    <td align="right">Дата<span class="required">*</span></td>
                                    <td style="width: 350px"><input type="text" placeholder="гггг-мм-дд" value="'.$obj['objectDate'].'" style="width: 100%"name="objects_date"></td>

                                </tr>

                                <tr>
                                    <td align="right">Изображение<span class="required">*</span></td>
                                    <td style="width: 350px"><input type="file" style="width: 100%"name="objects_img">
                                        <input type="hidden" name="objects_img_val" value="'.$obj['img'].'">
                                         <img src="/img/objects/'.$obj['img'].'" width="600"/>
                                    </td>

                                </tr>


                            </table>
                        </form>
                    </td>
                </tr>';
}