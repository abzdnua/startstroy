<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
$db = db::getInstance();

if($_POST){
    $name = $_POST['name'];
    $text = $_POST['text'];
    $show = ($_POST['show'] == 'on')?1:0;
    $now = date('Y-m-d H:i:s');
    if($_POST['id']){
        $id = $_POST['id'];
        $user = $_SESSION['userID'];
        $client_id = $_POST['client_id'];
        $db->query("UPDATE reviews SET text = '{$text}', `show` = {$show}, userUpdate={$user}, dateUpdate = '{$now}' WHERE id={$id}");
        $db->query("SELECT name FROM clients WHERE id={$client_id}");
        if($db->getCount()){
            $db->query("UPDATE clients SET name='{$name}' WHERE id={$client_id}");
        }else{
            $db->query("INSERT INTO clients (name) VALUES ('{$name}')");
            $last = $db->last();
            $db->query("UPDATE reviews SET client_id = {$last} WHERE id={$id}");
        }
    }else{
        $db->query("INSERT INTO clients (name) VALUES ('{$name}')");
        $last = $db->last();
        $db->query("INSERT INTO reviews (client_id,`text`,`show`,dateCreate) VALUES ({$last},'{$text}',{$show},'{$now}')");
    }


}