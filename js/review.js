$(function(){
    var review = {
        url: "/lib/review.php",

        beforeSubmit: function(jqForm){
            console.log(jqForm)
        },
        success:function(responseText){
            console.log(responseText)
            responseText = $.parseJSON(responseText)

            if(!responseText['err'])
            {
                $('<div id="secret"><div class="title_popup" style="text-align: left;margin: 3px 0 0 10px;">Спасибо за отзыв.</div> <div class="popup_buy_table" style="margin-bottom: 17px;">Ваш отзыв принят и будет опубликован сразу же после проверки администратором<div></div>').dialog({modal:true,resizable:false,draggable:false,width:'250',buttons:[{text:'',click:function() { $( this ).remove(); } }], close: function( event, ui ) {$( this ).remove(); },open: function(){$('.ui-button').blur()} })
               // $('#popup_bg_add_reviews').hide()
            }
            else
            {
                $('<div id="secret"><div class="title_popup" style="text-align: left;margin: 3px 0 0 10px;">Ошибка</div> <div class="popup_buy_table" style="margin-bottom: 17px;">'+responseText['err']+'<div></div>').dialog({modal:true,resizable:false,draggable:false,width:'250',buttons:[{text:'',click:function() { $( this ).remove();} }], close: function( event, ui ) {$( this ).remove();},open: function(){$('.ui-button').blur()} })
                //$('#popup_bg_add_reviews').hide()
                   //alert(responseText['err']);
            }
        }
    }

    $('#add_rw_full , #add_rw').live('click', function(){
        console.log('sfdffd')
        $('[name=review_full]').ajaxSubmit(review)
        return false;
    })



})