<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root."/lib/class.db.manager.php";
$dm = new db_manager();
$db = db::getInstance();
if($_POST){
    $id = $_POST['id'];
    $db->query("SELECT * FROM categories WHERE id = ".$id);
    $cat = $db->getRow();
    echo '<tr id="form" style="display:none;" >
                    <td colspan="6" style="padding: 10px;">
                        <div style="margin-bottom:10px;font:10pt Verdana;">Добавить новую категорию</div>
                        <form method="post">
                            <input type="hidden" name="id" value="'.$cat['id'].'">
                            <table align="center" border="none">
                                <tr>
                                    <td align="right">Название</td>
                                    <td style="width: 350px"><input type="text" style="width: 100%"name="category_name" value="'.$cat['name'].'"></td>
                                    <td style="vertical-align:middle" rowspan="4"><button type="button" name="save">Сохранить</button> </td>
                                </tr>
                                <tr>
                                    <td align="right">Родительская категория</td>
                                    <td style="width: 350px">'.$dm->getCategorySelect('parent_id',$cat['parent_id']).'</td>
                                </tr>
                                <tr class="forParent">
                                    <td align="right">Колонка меню</td>
                                    <td style="width: 350px"><select name="col">';
                                            for($i=1;$i<=3;$i++){
                                                echo '<option '.(($i==$cat['col'])?'selected=selected':'').' value="'.$i.'">'.$i.'</option>';
                                            }
                                    echo '</select></td>
                                </tr>
                                <tr class="forParent">
                                    <td align="right">Строка меню</td>
                                    <td style="width: 350px"><select name="row">';
                                        for($i=1;$i<=10;$i++){
                                            echo '<option '.(($i==$cat['row'])?'selected=selected':'').' value="'.$i.'">'.$i.'</option>';
                                        }
                                        echo '</select></td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>';
}