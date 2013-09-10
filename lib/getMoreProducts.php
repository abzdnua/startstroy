<?
require_once 'class.invis.db.php';
require_once 'class.db.manager.php';
require_once 'class.dll.php';
$db = db::getInstance();
$dm = new db_manager();

if($_POST){
    $from = $_POST['from'];
    $count = $_POST['count'];
    $cat = $_POST['cat'];
    $prods = $dm->getAllProducts($from,$count,$cat);
    $html = "";
    $k = $from+1;
    foreach($prods as $prod){?>
        <li class="<?=($k%4==1)?"no_mar_left":""?>">
                    <a href="catalog/product/<?=$DLL->linkInBD($prod->get_name(),$prod->get_id())?>">
                        <div class="max_height">      <div class="img"><div><img src="../img/products/m_<?=$prod->get_img()?>"/></div></div></div>
                    <div class="text"><?=$prod->get_name()?></div>

        <div class="price_block">
            <div class="vert_align">
                <div class="old_price" <?echo ($prod->get_price()==0)?"style='display:none'":""?>  ><? echo $prod->get_price()?> грн.</div>
                <div class="new_price <?echo ($prod->get_price()==0)?"":"red"?>"><? echo $prod->get_priceForSale()?> грн.</div>
            </div>
        </div>
        </a>
        <a href="/buy/p/<?=$DLL->linkInBD($prod->get_name(),$prod->get_id())?>" class="buy">ЗАКАЗАТЬ</a>
        </li>
    <?$k++;
    }



}
