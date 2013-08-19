<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.db.manager.php';
$dm = new db_manager();

if($_POST)
{
    $products = $dm->getProductsObjArray(false, $_POST['type_of_show'], $_POST['type_of_type'], $_POST['brand'], $_POST['from'], 10);

    if($products){
        //print_r($products);
        for($i = 0; $i<count($products); $i++){
            $c = $products[$i];
            $disp = ($i>9)?" display-none":'';
            switch($c->get_type()){
                case 'муж':
                    $type = 'man';
                    break;
                case 'дет':
                    $type = 'child';
                    break;
                case 'жен':
                    $type = 'woman';
                    break;
                case 'уни':
                    $type = 'unisex';
                    break;
            }

            $mar = (($i+1) % 2 == 0)?' n_m_r':'';
            echo '<li class="main_page_li '.$mar.$disp.'">';
            echo '<div class="text_hide_2"><p class="title_main_li">'.$c->get_name().'</p> </div>';
            echo '<div class="hide_text"></div>';
            echo '<div class="sex_clock '.$type.'"><a style="cursor:pointer">'.$c->get_type().'</a></div>';
            echo '<div class="img_main_li"><p><a href="/more/clock/'.$dm->getTypeOfShow($c->get_id()).'/'.$type.'/'.$c->get_brand_name_eng().'/'.$c->get_id().'"> <img src="/sc_img/product/'.$c->get_photo().'_m.jpg" /></a></p></div>';
            echo '<div class="text_main_li" >';
            echo '<p class="old_price">'.$c->get_price().'грн</p>';
            $price = $c->get_price()*(1-$dm->getProductFullDiscount($c->get_id())/100);
            echo '<p class="new_price">'.floor($price).' <span> грн.</span></p>';
            echo '<p class="text_price">Скидка составляет: <span>'.$dm->getProductFullDiscount($c->get_id()).'%</span></p>';
            echo '<p class="text_price">Вы экономите: <span>'.($c->get_price() - floor($price)).' грн.</span></p>';
            if($dm->hasTimer($c->get_id()) && $dm->hasCount($c->get_id()))
            {
                $t = $dm->getFullInfoAboutTimerByProductId($c->get_id());
                $cd = $dm->getFullInfoAboutCountByProductId($c->get_id());
                if(!$t->get_timer()->isTimeout() OR !$t->get_timer2()->isTimeout())
                {
                    echo '<p class="text_price">Осталось товара: <span class="green_text" data-id="'.$c->get_id().'">'.($cd->get_available() - $cd->get_sold()).' ед.</span></p>';
                }
            }
            else
            {
                if($dm->hasPresent($c->get_id()))
                {
                    $pd = $dm->getAllInfoAboutPresentByProductId($c->get_id());
                    if($pd->showPresents()){
                        echo '<div class="surprize" data-id="'.$pd->get_present_id().'"></div><p class="arial_gray red">При покупке этого товара, Вы получаете подарок! :-)</p>';
                    }
                    else{
                        if($dm->hasTimer($c->get_id())){
                            $t = $dm->getFullInfoAboutTimerByProductId($c->get_id());
                            if(!$t->get_timer()->isTimeout() OR !$t->get_timer2()->isTimeout()){
                                echo '<p class="arial_gray mar_top_15">Спешите! Срок акции ограничен!</p>';
                            }
                        }

                        if($dm->hasCount($c->get_id())){
                            $cd = $dm->getFullInfoAboutCountByProductId($c->get_id());
                            if($cd->is_rest()){
                                echo '<p class="arial_gray center">Спешите! Разбирают, как <br/> горячие пирожки!</p>';
                            }
                        }
                    }
                }
                else
                {
                    if($dm->hasTimer($c->get_id())){
                        $t = $dm->getFullInfoAboutTimerByProductId($c->get_id());
                        if(!$t->get_timer()->isTimeout() OR !$t->get_timer2()->isTimeout()){
                            echo '<p class="arial_gray mar_top_15">Спешите! Срок акции ограничен!</p>';
                        }
                    }

                    if($dm->hasCount($c->get_id())){
                        $cd = $dm->getFullInfoAboutCountByProductId($c->get_id());
                        if($cd->is_rest()){
                            echo '<p class="arial_gray center">Спешите! Разбирают, как <br/> горячие пирожки!</p>';
                        }
                    }
                }
            }

            if($dm->hasTimer($c->get_id())){
                $t = $dm->getFullInfoAboutTimerByProductId($c->get_id());
                if($t->get_timer()->get_time_start_in_seconds() > time())
                {
                    echo '<div class="clock_main" style="display:none" data-until="'.($t->get_timer()->get_time_start_in_seconds()-time()).'" data-period="0" data-id="'.$c->get_id().'"></div>';
                }
                else
                {
                    if(!$t->get_timer()->isTimeout())
                    {
                        $dur = $t->get_timer()->GetTimeLeft();
                        echo '<div class="clock_main"  data-until="'.$dur.'" data-period="1" data-id="'.$c->get_id().'"></div>';
                    }
                    else
                    {
                        if(!$t->get_timer2()->isTimeout())
                        {
                            $dur = $t->get_timer2()->GetTimeLeft();
                            echo '<div class="clock_main"  data-until="'.$dur.'" data-period="2" data-id="'.$c->get_id().'"></div>';
                        }
                    }
                }
            }
            else{
                if($dm->hasCount($c->get_id())){
                    $cd = $dm->getFullInfoAboutCountByProductId($c->get_id());
                    if($cd->is_rest()){
                        echo '<div class="star_main" data-id="'.$c->get_id().'">Осталось:   '.($cd->get_available() - $cd->get_sold()).' ед.</div>';
                    }
                }
            }
            echo '<div class="href_main"><a href="/more/clock/'.$dm->getTypeOfShow($c->get_id()).'/'.$type.'/'.$c->get_brand_name_eng().'/'.$c->get_id().'">Просмотреть</a></div></div>';
            echo '</li>';
        }
    }
}
