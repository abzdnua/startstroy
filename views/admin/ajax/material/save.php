<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
$db = db::getInstance();
if($_POST['material_name']){
    $name = $_POST['material_name'];

    $user = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');

    if($_POST['id']!=''){
        $id = $_POST['id'];

        $sql = "UPDATE materials SET
                name = '{$name}',
                userUpdate = {$user},
                dateUpdate = '{$date}'
                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);
        echo '<script>
        window.location.reload()
        </script>';
    }else{
        $sql = "INSERT INTO materials
                (name,userCreate,dateCreate)
                VALUES
                ('{$name}',{$user},'{$date}')";
//        echo "error: ".$sql;
        $db->query($sql);

        echo '<script>
        window.location.reload()
        </script>';
    }
}else{
    echo 'error: Пустые параметры';
}?>