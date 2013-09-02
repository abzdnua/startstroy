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
 <tr id="form" style="display:none;" >


                    <td colspan="6" style="padding: 10px;">
                        <div style="margin-bottom:10px;font:10pt Verdana;">Добавить новый баннер</div>
                        <form method="post">
                            <input type="hidden" name="id" value="">
                            <table align="center" border="none">
                                <div style="margin:7px">
                                    Отображать <input type="checkbox" name="show" '.$checked.' style="position: "/><br />
                                </div>
                                <tr>
                                    <td align="right">Строка 1</td>
                                    <td style="width: 350px"><input value="'.$ban['firstStr'].'"type="text" style="width: 100%"name="str1"></td>

                                </tr>
                                <tr>
                                    <td align="right">Строка 2</td>
                                    <td style="width: 350px"><input value="'.$ban['secondStr'].'" type="text" style="width: 100%"name="str2"></td>

                                </tr>
                                <tr>
                                    <td align="right">Строка 3</td>
                                    <td style="width: 350px"><input type="text" value="'.$ban['thirdStr'].'"  style="width: 100%"name="str3"></td>
                                    <td style="vertical-align:middle" rowspan="4"><button type="button" name="save">Сохранить</button> </td>
                                </tr>




                                <tr>
                                    <td align="right">Изображение</td>
                                    <td style="width: 350px"><input type="file" style="width: 100%"name="banner_img">
                                    <img src="/img/banner/'.$ban['img'].'" width="204" height="72"/>
                                    </td>

                                </tr>


                            </table>
                        </form>
                    </td>
                </tr>';
}