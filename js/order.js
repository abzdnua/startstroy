$(document).ready(function(){
    $('input[type=radio]').live('change',function(){
        var w = $(this).val();
        var price = parseFloat($('#price').text())
        if(w == 24)
        {
            $('#itogo').empty().text(price+199)
        }
        if(w == 36)
        {
            $('#itogo').empty().text(price+299)
        }
        if(w == 12)
        {
            $('#itogo').empty().text(price)
        }
    })

    $('input[name=phone_one_click],input[name=phone_cb]').mask('+38 (999) 999 99 99')


    $('#bt_buy:not(.bt_buy_disabled)').live('click', function(){
        var th = $(this);
        console.log('order')
        var ord={
            url:'/lib/order.php',
            beforeSubmit:function(jqForm){
                console.log(jqForm)
                th.attr('disabled','disabled')
            },
            success:function(responseText){
                console.log(responseText)
                responseText = $.parseJSON(responseText)
                if(responseText['err'])
                {
                    $('<div id="secret"><div class="title_popup" style="text-align: left;margin: 3px 0 0 10px;">Ошибка</div> <div class="popup_buy_table" style="margin-bottom: 17px;">'+responseText['err']+'<div></div>').dialog({modal:true,resizable:false,draggable:false,width:'250',buttons:[{text:'',click:function() { $( this ).remove();} }], close: function( event, ui ) {$( this ).remove();},open: function(){$('.ui-button').blur()} })
                    $('#popup_bg').hide()
                }
                else
                {
                    $('<div id="secret"><div class="title_popup" style="text-align: left;margin: 3px 0 0 10px;">Спасибо за заказ! :-)</div> <div class="popup_buy_table" style="margin-bottom: 17px;">Ваш заказ принят! Дождитесь SMS сообщения на Ваш мобильный телефон с деталями заказа. Наши менеджеры свяжутся с Вами как можно скорее<div></div>').dialog({modal:true,resizable:false,draggable:false,width:'250',buttons:[{text:'',click:function() { $( this ).remove();} }], close: function( event, ui ) {$( this ).remove();},open: function(){$('.ui-button').blur()} })
                    $('#popup_bg').hide()

                }
                th.removeAttr('disabled')
            }
        }
        $('form[name=full_order]').ajaxSubmit(ord);
        return false;
    })




    $('input[name=phone]').mask('+38 (999) 999 99 99', {completed: function(){
        var number = $(this).val();
        if(number.indexOf('_') == -1)
        {
            $('.bt_buy').removeClass('bt_buy_disabled')
            validFields()
        }
        else
        {
            $('.bt_buy').addClass('bt_buy_disabled')
            validFields()
        }
    }
    })

    $('input[name=phone]').on('keyup',function(ev)
    {
        if(ev.keyCode!=37 && ev.keyCode!=38 && ev.keyCode!=40 && ev.keyCode!=39 && ev.keyCode!=101)
        {
            if($(this).val().indexOf('_')==-1)
            {
                $('.bt_buy').removeClass('bt_buy_disabled')
                validFields()
            }
            else {
                $('.bt_buy').addClass('bt_buy_disabled')
                validFields()
            }
        }
    }).on('input paste',function(e)
        {
            if($(this).val().indexOf('_')!=-1)
            {
                $('.bt_buy').removeClass('bt_buy_disabled')
                validFields()
            }
            else
            {
                $('.bt_buy').addClass('bt_buy_disabled')
                validFields()
            }

        })

    $('input[name=name_ord]').on('keyup',function(ev){
        if(ev.keyCode!=37 && ev.keyCode!=38 && ev.keyCode!=40 && ev.keyCode!=39 && ev.keyCode!=101)
        {
            if($(this).val().length>0)
            {
                $('.bt_buy').removeClass('bt_buy_disabled')
                validFields()
            }
            else
            {
                $('.bt_buy').addClass('bt_buy_disabled')
                validFields()
            }
        }
    })




})

function validFields(){
    if( $('input[name = phone]').val().indexOf('_') == -1 && $('input[name=name_ord]').val().length>0 && $('input[name=phone]').val().length>0)
    {
        $('.bt_buy').removeClass('bt_buy_disabled')
    }
    else
    {
        $('.bt_buy').addClass('bt_buy_disabled')
    }
}
