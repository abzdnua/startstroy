<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
$db = db::getInstance();
if($_POST['partner_name']){
    $name = $_POST['partner_name'];
    $des = $_POST['partner_des'];
    $img = $_POST['partner_img'];
    $link = $_POST['partner_link'];
    $user = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');
    if($_POST['id']!=''){
        $id = $_POST['id'];
        $sql = "UPDATE partners SET
                name = '{$name}',
                des = '{$des}',
                img = '{$img}',
                link = '{$link}',
                userUpdate = {$user},
                dateUpdate = '{$date}'
                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);
        echo '<script>
        window.location.reload()
        </script>';
    }else{
        $sql = "INSERT INTO partners
                (name,des,img,link,userCreate,dateCreate)
                VALUES
                ('{$name}','{$des}','{$img}','{$link}',{$user},'{$date}')";
//        echo "error: ".$sql;
        $db->query($sql);

        echo '<script>
        window.location.reload()
        </script>';
    }
}else{
    echo 'error: Пустые параметры';
}?>