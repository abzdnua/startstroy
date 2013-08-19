<?php
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
$db = db::getInstance();

if(isset($_POST['new_brand'])){
    $name = $_POST['new_brand'];
    $name_eng = $DLL->linkInBD($name);
    $sql = "INSERT INTO brands(name,name_eng) VALUES ('".$name."','".$name_eng."')";
    $db->query($sql);
    $last = $db->last();
    $sql = "SELECT * FROM brands";
    $db->query($sql);
    $c = $db->getCount();
    echo '<tr>';
    echo '<td>';
    echo $c;
    echo '</td>';
    echo '<td class="brand_info">';
    echo '<input type = "text" name = "brand" value="'.$name.'" style="width:500px"/>';
    echo '<input type = "hidden" name = "brand_id" value="'.$last.'" />';
    echo '</td>';
    echo '<td>';
    echo '<input type = "button" class="refresh" value="Обновить"';
    echo '</td>';
    echo '<td>';
    echo '<img class="del_brand" src="sc_img/admin/b_drop.png" title="Удалить">';
    echo '</td>';
}else{
    echo 'error';
}