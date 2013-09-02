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
        echo '<td colspan="5">
                        <span>Редактировать отзыв</span>
                        <form method="post" name="edit_review">
                            <div style="float: right">
                                ОТЗЫВ<br/>
                                <textarea name="review"  rows="8" cols="80">'.$row['text'].'</textarea>
                                <input type="hidden" name="action" value="edit" />
                                <input type="hidden" name="id" value="'.$row['id'].'" />
                            </div>
                            <div style="width:200px; text-align: right">
                                <div style="margin:7px">
                                    Отображать <input type="checkbox" name="show" style="position: " '.$checked.'/><br />
                                </div>
                                <div style="margin:7px">
                                    Имя: <input type="text" name="name" value="'.$dm->getClientName($row['client_id']) .'" /><br />
                                </div>


                            </div>
                            <div style="clear: both"></div>
                            <div style="text-align: center">
                                <input type="submit" class="sbm" value="Сохранить"  style="margin:10px;width:150px"/>
                            </div>
                        </form>
                    </td>';
    }
}
