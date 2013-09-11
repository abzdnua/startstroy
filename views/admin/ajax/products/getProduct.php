<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';


require_once $root."/lib/class.db.manager.php";

$dm = new db_manager();
$db = db::getInstance();
if($_POST){
    $id = $_POST['id'];
    $db->query("SELECT * FROM products WHERE id = ".$id);
$art = $db->getRow();




        $db->query("SELECT * FROM characteristics WHERE product_id = ".$id);
        $char = $db->getArray();
echo '
 <tr id="form" style="display:none;" >
                    <td colspan="11" style="padding: 10px;">
                        <div id="editor_title" style="margin-bottom:10px;font:10pt Verdana;">Редактирование товара</div>
                        <div class="silver">Поля отмеченные <span class="required">*</span> обязательны к заполнению</div>
                        <form method="post">
                            <input type="hidden" name="id" value="'.(($_POST['type']=='edit')?$id:'').'">
                            <table align="center" border="none">
                                <tr>
                                    <td align="right">Название<span class="required">*</span></td>
                                    <td style="width: 635px"><input type="text" style="width: 100%"name="product_name" value="'.$art['name'].'"></td>
                                    <td style="vertical-align:middle;width:85px" rowspan="11"><button type="button" name="save">Сохранить</button> </td>
                                </tr>
                                <tr>
                                    <td align="right">Отображать на сайте</td>
                                    <td style="width: 350px"><input type="checkbox" name="show" '.(($art['show'])?"checked=checked":"").'/></td>
                                </tr>
                                <tr>
                                    <td align="right">Отображать на главной</td>
                                    <td style="width: 350px"><input type="checkbox" name="top" '.(($art['top'])?"checked=checked":"").'/></td>
                                </tr>
                                <tr>
                                    <td align="right">Описание</td>
                                    <td style="width: 350px"><textarea rows=3  type="text" style="width: 100%"name="product_des">'.$art['des'].'</textarea></td>
                                </tr>

                                <tr>
                                    <td align="right">Старая цена</td>
                                    <td style="width: 350px"><input type="text" style="width: 100%"name="product_price" value="'.$art['price'].'"></td>
                                </tr>
                                <tr>
                                    <td align="right">Цена продажи<span class="required">*</span></td>
                                    <td style="width: 350px"><input type="text" style="width: 100%"name="product_priceforsale" value="'.$art['priceForSale'].'"></td>
                                </tr>
                                <tr>
                                    <td align="right">Изображение<span class="required">*</span>
                                    <div class="silver">Изображение должно быть не менее 330px по большей стороне и не более '.ini_get('upload_max_filesize').'</div></td>
                                    <td style="width: 350px"><input type="file" style="width: 100%"name="product_img" >
                                        <input type="hidden" name="product_img_val" value="'.$art['img'].'"/>
                                        <img id="id_img_edit_img" src="/img/products/'.$art['img'].'"/>
                                    </td>

                                </tr>
                                <tr>
                                    <td align="right">Категория<span class="required">*</span></td>
                                    <td>
                                        '.$dm -> getCategorySelect("category_id",$art['category_id']).'
                                    </td>
                                </tr>
                                   <tr>
                                    <td align="right">Подкатегория<span class="required">*</span></td>
                                    <td>
                                        '.$dm -> getCategorySelect("subCategory_id",$art['subCategory_id'],$art['category_id']).'
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Выбирете производителя</td>
                                    <td>
                                     '.$dm -> getFirmSelect("firm",$art['firm_id']).'
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Тип материала</td>
                                    <td>
                                      '.$dm -> getMaterialSelect("material",$art['material_id']).'
                                    </td>




                                </tr>

                                 <tr>
                                    <td align="right">Характеристики</td>
                                    <td>
                                        <input type="hidden" name="char_count" value="'.count($char).'">';
                                           if (count($char) >0 )
                                           {
                                            for($i=1;$i<=count($char);$i++)
                                                 {
                                                echo '<div class="char"><div class="del_char" title="Удалить характеристику"><img src="img/admin/remove.png" /></div>Наименование: <input style="width: 150px;margin-right: 29px;" name="c_name_'.$i.'" type="text"  value="'.$char[$i-1]['name'].'" class="name"/> Значение: <input style="width: 240px;" name="c_value_'.$i.'" type="text"  value="'.$char[$i-1]['value'].'"  class="value"/><div style="clear:both"></div></div>';

                                                 }
                                           }

    echo '
                                        <button type="button" id="add_char">Добавить характеристику</button>
                                    </td>
                                </tr>


                            </table>
                        </form>
                    </td>
                </tr>';
}