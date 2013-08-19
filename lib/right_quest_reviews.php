<?
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
$db = db::getInstance();

?>

<div class="contact_right f-r" style="margin-top: 38px;">
    <p class="f-l" style="font:30px mpsb; color:white">Есть вопросы ?</p><img src="/sc_img/arrow_reviews.png" style="padding-top: 5px;padding-right:15px;"class="f-r" />
    <div style="clear: both;"></div>
    <form name="question" method="post" >
        <p class="form_right_p" >Введите имя<input name="my_name" type="text" size="40"class=" input_rev f-r" placeholder="Введите имя"> </p>
        <p class="form_right_p"  >E-mail<input name="email" type="text" size="40" class=" input_rev f-r" placeholder="Введите е-mail"> </p>
        <p class="form_right_p"  >Вопрос
            <textarea name="question" cols="40" style="width:147px" rows="4" class="height_60 input_rev f-r" placeholder="Введите вопрос"></textarea></p>
        <p>
        <div style="clear: both;"></div>
        <input type="submit" value="Спросить" class="f-r" style="margin-right: 18px;margin-top: 8px;">

    </form>
    <div style="clear: both;"></div>
    <div style="width:270px;">
        <p style="font:18px mpsb;margin: 40px 0 10px 0;">Последние отзывы</p>

        <?
        $sql = "SELECT * FROM reviews WHERE `show` = 1 ORDER BY date_create DESC LIMIT 0,3";
        $db->query($sql);
        if($db->getCount()>0){
            $arr = $db->getArray();
            foreach($arr as $key=>$val){
                if(strlen($val['comment'])>50)
                {
                    $a = '<a href="/reviews#'.$val['id'].'">Читать дальше</a>';
                }
                else
                {
                    $a ='';
                }
                $text = $DLL->substrText($val['comment'],50);
                echo '<p class="reviews_cont">'.$text['text'].' '.$a.'</p>';
                echo '<p class="f-r reviews_cont_author"> '.$val['name'];
                echo ($val['city'] != '')?', г. '.$val['city'].'</p>':'</p>';
                echo '<div style="clear: both;"></div>';
            }
        }
        ?>
        <div class=" contact_reviews_send f-l" ><a style="cursor: pointer" class="review_add_bottom">Оставить отзыв</a></div>
        <div class=" contact_reviews_all f-r"><a href="/reviews">Все отзывы</a></div>
    </div>
</div>