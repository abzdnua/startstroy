<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
$db = db::getInstance();
if($_POST['category_name']){
    $name = $_POST['category_name'];
    $link = $DLL->linkInBD($name);
    $parent_id = $_POST['parent_id'];
    $user = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');

    if($_POST['id']!=''){
        $id = $_POST['id'];
        $sql = "UPDATE categories SET
                name = '{$name}',
                link = '{$link}',
                parent_id = {$parent_id},
                userUpdate = {$user},
                dateUpdate = '{$date}'
                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);
        echo '<script>
        window.location.reload()
        </script>';
    }else{
        $sql = "INSERT INTO categories
                (name,link,parent_id,userCreate,dateCreate)
                VALUES
                ('{$name}','{$link}',{$parent_id},{$user},'{$date}')";
//        echo "error: ".$sql;
        $db->query($sql);
        echo '<script>
        window.location.reload()
        </script>';
    }
}else{
    echo 'error: Пустые параметры';
}