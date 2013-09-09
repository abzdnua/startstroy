<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.dll.php';
require_once $root.'/lib/class.invis.db.php';

require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/img/products/';
$db = db::getInstance();

if(!empty($_POST)){

    $name = $_POST['product_name'];
    $des = $_POST['product_des'];
    $price = ($_POST['product_price'])?$_POST['product_price']:0;
    $priceForSale = $_POST['product_priceforsale'];
    $user = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');
    $category_id = $_POST['category_id'];
    $subcategory_id = $_POST['subCategory_id'];
    $material_id = $_POST['material'];
    $firm_id = $_POST['firm'];
    $show = ($_POST['show']=='on')?1:0;
    if($_POST['id']!=''){
        $id = $_POST['id'];
        $sql = "UPDATE products SET
                name = '{$name}',
                des = '{$des}',
                price = {$price},
                priceForSale = {$priceForSale},
                category_id = {$category_id},
                subCategory_id = {$subcategory_id},
                material_id = {$material_id},
                firm_id = {$firm_id},
                `show` = {$show},
                userUpdate = {$user},
                dateUpdate = '{$date}'
                WHERE id = {$id}";
     //  echo "error: ".$sql;
        $db->query($sql);

    }else{
        $sql = "INSERT INTO products
                (name,des,price,priceForSale,category_id,subCategory_id,material_id,firm_id,`show`,userCreate,dateCreate)
                VALUES
                ('{$name}','{$des}',{$price},{$priceForSale},{$category_id},{$subcategory_id},{$material_id},{$firm_id},{$show},{$user},'{$date}')";
       echo "error: ".$sql;
        $db->query($sql);
        $id = $db->last();




    }

    if(!empty($_FILES['product_img']['name'])!=''){
        $img = new Upload($_FILES['product_img']);

        if($img->image_src_x > 330 AND $img->image_src_y > 330)
        {
            echo "error: Размер картинки должен быть 330*330";
            exit();
        }
        $uniq_img = uniqid();

        $img -> file_new_name_body = $uniq_img;
        $img -> jpeg_quality = 100;
        $img -> process($pathToSaveImg);
        $img_str =  $uniq_img.'.'.$img->image_src_type;

        $img -> file_new_name_body = 'm_'.$uniq_img;
        $img -> jpeg_quality = 100;
        $img -> image_x = 180;
        $img -> image_ratio_y = true;
        $img ->image_resize = true;
        $img -> process($pathToSaveImg);
        $thumb_str = 'm_'.$uniq_img.'.'.$img->image_src_type;

        $sql = "UPDATE products SET
                img = '{$img_str}'
                WHERE id = {$id}";
     //   echo "error: ".$sql;
        $db->query($sql);
    }
    if($_POST['char_count'] > 0)
    {


            $sql = "DELETE FROM characteristics WHERE product_id =".$id;
            $db->query($sql);

        for($i = 1; $i <= $_POST['char_count']; $i++){
            if(trim($_POST['c_name_'.$i]) != '' AND trim($_POST['c_value_'.$i]) != '')
            {

                $c_name = addslashes($_POST['c_name_'.$i]);
                $c_value = addslashes($_POST['c_value_'.$i]);
                $sql_char = "INSERT INTO characteristics(product_id, name, `value`) VALUES ('".$id."','".$c_name."','".$c_value."')";
                $db->query($sql_char);


            }
        }

    }

}
else
{
    echo 'error: Пустые параметры';
}