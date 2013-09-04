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
                        <div style="margin-bottom:10px;font:10pt Verdana;">Добавить новый объект</div>
                        <form method="post">
                            <input type="hidden" name="id" value="'.$obj['id'].'">
                            <table align="center" border="none">
                                <tr>
                                    <div style="margin:7px">
                                        Отображать <input type="checkbox" name="show" '.$checked.' style="position: "/><br />
                                    </div>
                                    <td align="right">Название</td>
                                    <td style="width: 350px"><input type="text" value="'.$obj['name'].'" style="width: 100%"name="objects_name"></td>
                                    <td style="vertical-align:middle" rowspan="4"><button type="button" name="save">Сохранить</button> </td>
                                </tr>
                                <tr>
                                    <td align="right">Дата</td>
                                    <td style="width: 350px"><input type="text" value="'.$obj['objectDate'].'" style="width: 100%"name="objects_date"></td>

                                </tr>

                                <tr>
                                    <td align="right">Изображение</td>
                                    <td style="width: 350px"><input type="file" style="width: 100%"name="objects_img">
                                        <input type="hidden" name="objects_img_val">
                                         <img src="/img/objects/'.$obj['img'].'" width="204" height="72"/>
                                    </td>

                                </tr>


                            </table>
                        </form>
                    </td>
                </tr>';
}