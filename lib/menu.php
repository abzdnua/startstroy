<div style="text-align: center;cursor:default;">Вы вошли как  <strong><?=($DLL -> getUser($_SESSION['userID']))?$DLL -> getUser($_SESSION['userID']):'<span style="color:red">unknown</span>';?></strong> | <a href='/admin/in' title='выход'>Выход</a></div>

<div class='bottom_menu'>
    &ensp;
    <?=($controller -> is('admin','room'))? "<span": "<a";?> 
    style='line-height:20px' href='/admin/room' title='' <?php echo ($tut == 'room') ? "class='tut'" : ""; ?> >Номера
    <?=($tut=='room') ? "</span>" : "</a>";?>    

    &ensp;
    <?=($tut == 'reviews')? "<span": "<a";?> 
    style='line-height:20px' href='/admin/' title='' <?php echo ($tut == 'reviews') ? "class='tut'" : ""; ?> >Отзывы
    <?=($tut=='reviews') ? "</span>" : "</a>";?> 
</div>sadsdasd