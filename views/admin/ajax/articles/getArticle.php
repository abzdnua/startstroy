<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();
if($_POST){
    $id = $_POST['id'];
$db->query("SELECT * FROM articles WHERE id = ".$id);
$art = $db->getRow();
echo '
 <td colspan="6" style="padding: 10px;">
                        <div style="font:10pt Verdana;">Добавить новую статью</div>
                        <div class="silver">Поля отмеченные <span class="required">*</span> обязательны к заполнению</div>
                        <form method="post">
                            <input type="hidden" name="id" value="'.$art['id'].'">
                            <table align="center" border="none" width="100%">
                                <tr>
                                    <td align="right">Название<span class="required">*</span></td>
                                    <td style="width: 630px"><input type="text" style="width: 100%" name="article_name" value="'.$art['name'].'"></td>
                                    <td style="vertical-align:middle" rowspan="6"><button type="button" name="save">Сохранить</button> </td>
                                </tr>
                                <tr>
                                    <td align="right">Отображать на сайте</td>
                                    <td><input type="checkbox" name="show"  '.(($art['show'])?"checked=checked":"").'/></td>
                                </tr>
                                <tr>
                                    <td align="right">Короткое описание</td>
                                    <td style="width: 350px"><textarea rows=3  type="text" style="width: 99%"name="article_shortdes">'.$art['shortDes'].'</textarea></td>
                                </tr>

                                <tr>
                                    <td align="right">Текст статьи<span class="required">*</span></td>
                                    <td style="width: 350px">
                                        <button style="width: 32%;" type="button" class="b" title="Жирный"><b>B</b></button>
                                        <button style="width: 32%;" type="button" class="i" title="Курсив"><i style="font-family: times new roman;">I</i></button>
                                        <button style="width: 32%;" type="button" class="l" title="Cсылка">URL</button>
                                        <textarea rows=45 style="width: 99%"name="article_text">'.$art['text'].'</textarea>


                                    </td>
                                </tr>

                                <tr>
                                    <td align="right">Изображение<span class="required">*</span></td>
                                    <td style="width: 350px"><input type="file" style="width: 100%"name="article_img">
                                        <input type="hidden" name="article_img_val" value="'.$art['img'].'">
                                        <img id="id_img_edit_img" style="width:600px" src="/img/articles/'.$art['img'].'"/>
                                    </td>

                                </tr>
                                <tr>
                                    <td align="right">Превью</td>
                                    <td style="width: 350px"><input type="file" style="width: 100%"name="article_thumb">
                                                       <input type="hidden" name="article_thumb_val" value="'.$art['thumb'].'">
                                        <img id="id_img_edit"  src="/img/articles/'.$art['thumb'].'"/>
                                    </td>

                                </tr>

                            </table>
                        </form>
                    </td>';
}