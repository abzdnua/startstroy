$(function(){
    $('form[name=question] input[type=submit]').live('click',function(){
        var th = $(this)
        var send = {
            url:"lib/question.php",
            beforeSubmit:function(jqForm){
                th.attr('disabled','disabled')
            },
            success: function(responseText){
                var a = $.parseJSON(responseText)
                if(a['err'])
                {
                    $('<div id="secret"><div class="title_popup" style="text-align: left;margin: 3px 0 0 10px;">Ошибка</div> <div class="popup_buy_table" style="margin-bottom: 17px;">'+a['err']+'<div></div>').dialog({modal:true,resizable:false,draggable:false,width:'250',buttons:[{text:'',click:function() { $( this ).remove();} }], close: function( event, ui ) {$( this ).remove();},open: function(){$('.ui-button').blur()} })
                }
                else
                {
                    $('<div id="secret"><div class="title_popup" style="text-align: left;margin: 3px 0 0 10px;">Вопрос принят! :-)</div> <div class="popup_buy_table" style="margin-bottom: 17px;">Ожидайте ответ на указанный Вами e-mail в ближайшее время<div></div>').dialog({modal:true,resizable:false,draggable:false,width:'250',buttons:[{text:'',click:function() { $( this ).remove();} }], close: function( event, ui ) {$( this ).remove();},open: function(){$('.ui-button').blur()} })
                }
                th.removeAttr('disabled')
            }
        }
        $('form[name=question]').ajaxSubmit(send)
        return false;
    })
})