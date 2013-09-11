$(document).ready(function(){
    function client(){
        if($('[name=phone]').val().indexOf('_')==-1){
            $.post('lib/getClient.php',{phone:$('[name=phone]').val()},function(data){
                data = $.parseJSON(data)
                if($('[name=name]').val().length==0)$('[name=name]').val(data['name'])
                if($('[name=email]').val().length==0)$('[name=email]').val(data['email'])
            })
        }
    }
    $('[name=phone]').mask('+38 (999) 999 99 99',{completed:function(){
        client()
    }})
    $(document).on('paste','[name=phone]',function(){
        console.log($(this).val())
        client()
    })
    $('[name=phone]').on('contextmenu',function(){
        return false
    })


    var order = {
        url: "/lib/order.php",

        beforeSubmit: function(jqForm){
            console.log(jqForm)
        },
        success:function(responseText){
            console.log(responseText)
//            $('body').html(responseText)

            responseText = $.parseJSON(responseText)




            if(!responseText['err'])
            {
                $("<div>Ваш заказ прият<br>Мы свяжемся с Вами в ближайшее время</div>").dialog({
                    dialogClass: "style-dialog",
                    modal:true,
                    width: 500,
                    title: "Спасибо",
                    resizable:false,
                    position: { my: "center", at: "center", of: window },
                    open:function(){$('.ui-button').blur(); $(this).css({Height:'auto',minHeight:0})},
                    buttons:[
                        { text: "OK", click: function() {
                            $(this).dialog( "close" );
                            location.href="/"
                        } }]
                })

            }
            else
            {
                $("<div>"+responseText['err']+"</div>").dialog({
                    dialogClass: "style-dialog",
                    modal:true,
                    width: 500,
                    title: "Ошибка",
                    resizable:false,
                    position: { my: "center", at: "center", of: window },
                    open:function(){$('.ui-button').blur(); $(this).css({Height:'auto',minHeight:0})},
                    buttons:[
                        { text: "OK", click: function() {
                            $(this).dialog( "close" );
                        } }]
                })
            }
        }
    }

    $('#make_order').on('click',function(){
        var th = $(this)
        if(th.hasClass('disabled')){
            return false;
        }
        th.addClass('disabled')
//        console.log('sd')
        var error = ""
        if($('[name=name]').val()=='')
            error +='Поле "Ваше имя" не может быть пустым<br>'
        if($('[name=phone]').val()=='')
            error +='Поле "Телефон" не может быть пустым'

        if(error!=''){
            $("<div>"+error+"</div>").dialog({
                    dialogClass: "style-dialog",
                    modal:true,
                    width: 500,
                    title: "Предупреждение",
                    resizable:false,
                    position: { my: "center", at: "center", of: window },
                    open:function(){$('.ui-button').blur(); $(this).css({Height:'auto',minHeight:0})},
                    buttons:[
                        { text: "OK", click: function() {
                            $(this).dialog( "close" );
                        } }]
                }
            )
            th.removeClass('disabled')
            return false;
        }

        $('[name=order]').ajaxSubmit(order)
        return false;
    })


})