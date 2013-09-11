<?
require_once 'class.invis.db.php';
$db = db::getInstance();

if($_POST){
    $phone   = preg_replace('/[\s\(\)]/','',$_POST['phone']);
    $db->query("SELECT name,email FROM clients WHERE phone = '{$phone}'");
    $client = $db->getRow();
    if($client){
        echo json_encode(array('name'=>$client['name'],'email'=>$client['email'],'phone'=>$phone));
    }else{
        echo json_encode(array('name'=>'','email'=>'','phone'=>$phone));
    }
}