$(document).ready(function(){

    $('.submit').live('click', function(){
        var th = $(this);
        var send={
            url:'views/admin/ajax/banners/saveBanner.php',
            beforeSubmit: function(jqForm){
                console.log(jqForm)
            },
            success:function(data){
                console.log(data);
                if(data.indexOf('Ошибка') == -1)
                {
                    $('.for_banner', th.parent('form')).empty().append('<img src="sc_img/banners/'+data+'.png">')
                }
                else
                {
                    alert(data)
                }
            }
        }
        $(this).parent('form').ajaxSubmit(send);
        return false;
    })
})