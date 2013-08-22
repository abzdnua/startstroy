<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';


require_once $root."/lib/class.db.manager.php";

$dm = new db_manager();
$db = db::getInstance();
if($_POST){
    $id = $_POST['id'];
    $db->query("SELECT * FROM products WHERE id = ".$id);
$art = $db->getRow();
echo '
 <tr id="form" style="display:none;" >
                    <td colspan="6" style="padding: 10px;">
                        <div style="margin-bottom:10px;font:10pt Verdana;">Добавить новый товар</div>
                        <form method="post">
                            <input type="hidden" name="id" value="">
                            <table align="center" border="none">
                                <tr>
                                    <td align="right">Название</td>
                                    <td style="width: 350px"><input type="text" style="width: 100%"name="product_name" value="'.$art['name'].'"></td>
                                    <td style="vertical-align:middle" rowspan="4"><button type="button" name="save">Сохранить</button> </td>
                                </tr>
                                <tr>
                                    <td align="right">Описание</td>
                                    <td style="width: 350px"><textarea rows=3  type="text" style="width: 100%"name="product_des">'.$art['des'].'</textarea></td>
                                </tr>

                                <tr>
                                    <td align="right">Цена</td>
                                    <td style="width: 350px"><input type="text" style="width: 100%"name="product_price" value="'.$art['price'].'"></td>
                                </tr>
                                <tr>
                                    <td align="right">Новая цена</td>
                                    <td style="width: 350px"><input type="text" style="width: 100%"name="product_priceforsale" value="'.$art['priceForSale'].'"></td>
                                </tr>
                                <tr>
                                    <td align="right">Изображение</td>
                                    <td style="width: 350px"><input type="file" style="width: 100%"name="product_img" >
                                        <input type="hidden" name="product_img_val" value="'.$art['img'].'"/>
                                        <img id="id_img_edit_img" style="display:none"/>
                                    </td>

                                </tr>
                                <tr>
                                    <td align="right">Категория</td>
                                    <td>
                                        '.$dm -> getCategorySelect("category_id",-1).'
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Выбирете производителя</td>
                                    <td>
                                     '.$dm -> getFirmSelect().'
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Тип материала</td>
                                    <td>
                                      '.$dm -> getMaterialSelect().'
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>';
}