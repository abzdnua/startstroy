<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();
if($_POST){
    $id = $_POST['id'];
$db->query("SELECT * FROM banners WHERE id = ".$id);
$ban = $db->getRow();
    $checked = ($ban['show'] == 1)?' checked':'';

echo '
 <td colspan="8" style="padding: 10px;">
                        <div style="font:10pt Verdana;">Редактирование баннера</div>
                        <div class="silver">Поля отмеченные <span class="required">*</span> обязательны к заполнению</div>
                        <form method="post">
                            <input type="hidden" name="id" value="'.$ban['id'].'">
                            <table align="center" border="none" width="100%">
                                <tr>
                                    <td align="right">Строка 1<span class="required">*</span></td>
                                    <td style="width: 630px"><input type="text" style="width: 100%" name="str1" value="'.$ban['firstStr'].'"></td>
                                    <td style="vertical-align:middle;width:85px" rowspan="5"><button type="button" name="save">Сохранить</button> </td>
                                </tr>
                                <tr>
                                    <td align="right">Строка 2</td>
                                    <td style="width: 350px"><input type="text" style="width: 100%" name="str2" value="'.$ban['secondStr'].'"></td>

                                </tr>
                                <tr>
                                    <td align="right">Строка 3</td>
                                    <td style="width: 350px"><input type="text" style="width: 100%" name="str3" value="'.$ban['thirdStr'].'"></td>

                                </tr>
                                <tr>
                                    <td align="right">Отображать</td>
                                    <td style="width: 350px"><input type="checkbox" name="show" '.(($ban['show'])?"checked=checked":"").'/></td>

                                </tr>
                                <tr>
                                    <td align="right">Изображение<span class="required">*</span>
                                    <div class="silver">Изображение размером 1024*360рх</div></td>
                                    <td style="width: 350px"><input type="file" style="width: 100%" name="banner_img">
                                    <img src="/img/banner/'.$ban['img'].'" style="width:600px"/>
                                    <input type="hidden" name="banner_img_val" value="'.$ban['img'].'">
                                    </td>

                                </tr>


                            </table>
                        </form>
                    </td>';
}