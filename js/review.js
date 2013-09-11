$(function(){

    $('[name=phone]').mask('+38 (999) 999 99 99')
    var review = {
        url: "/lib/review.php",

        beforeSubmit: function(jqForm){
            console.log(jqForm)
        },
        success:function(responseText){
            console.log(responseText)
            responseText = $.parseJSON(responseText)
            console.log(responseText)
            if(!responseText['err'])
            {
                $("<div>Спасибо за Ваш отзыв<br>Он появится на сайте после проверки администратором</div>").dialog({
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
            $('#add_rw').removeClass('disabled')
        }
    }

    $('#add_rw').live('click', function(){
        var th = $(this)
        if(th.hasClass('disabled')){
            return false;
        }
        th.addClass('disabled')
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
        $('[name=review_full]').ajaxSubmit(review)
        return false;
    })








})