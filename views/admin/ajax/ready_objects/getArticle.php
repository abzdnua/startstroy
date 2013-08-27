<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();
if($_POST){
    $id = $_POST['id'];
$db->query("SELECT * FROM articles WHERE id = ".$id);
$art = $db->getRow();
echo '
 <tr id="form" style="display:none;" >
                    <td colspan="6" style="padding: 10px;">
                        <div style="margin-bottom:10px;font:10pt Verdana;">Добавить новую статью</div>
<form method="post">
                            <input type="hidden" name="id" value="'.$art['id'].'">
                            <table align="center" border="none">
                                <tr>
                                    <td align="right">Название</td>
                                    <td style="width: 350px"><input type="text" style="width: 100%"name="article_name" value="'.$art['name'].'"></td>
                                </tr>
                                <tr>
                                    <td align="right">Короткое описание</td>
                                    <td style="width: 350px"><textarea rows=3  type="text" style="width: 100%"name="article_shortdes">'.$art['short_des'].'</textarea></td>
                                </tr>

                                <tr>
                                    <td align="right">Текст статьи</td>
                                    <td style="width: 350px">

                                        <button style="width: 32%;" type="button" class="b" title="Жирный"><b>B</b></button>
                                        <button style="width: 32%;" type="button"" class="i" title="Курсив"><i style="font-family: times new roman;">I</i></button>    <button style="width: 32%;" type="button" class="l" title="Cсылка">URL</button>
  <textarea rows=7 style="width: 100%"name="article_text">'.$art['text'].'</textarea>



                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Превью</td>
                                    <td style="width: 350px"><input type="file" style="width: 100%"name="article_thumb" value="'.$art['thumb'].'">
                                                       <input type="hidden" name="article_thumb_val" value="'.$art['thumb'].'">
                                        <img id="id_img_edit" style="display:none"/>
                                    </td>
                                    <td style="vertical-align:middle" rowspan="2"><button type="button" name="save">Сохранить</button> </td>
                                </tr>

                            </table>
                        </form>
                         </td>
                </tr>';
}