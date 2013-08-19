<?php
class discount
{
    private $id;             //id из БД
    private $product_id;     //id товара
    private $percent;        //Размер скидки

    //Получить размер скидки
    public function GetPercent(){
        return $this -> percent;
    }
}
?>