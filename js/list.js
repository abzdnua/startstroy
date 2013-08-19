function getRest(){
    var a = []
    $('.star_main, .green_text').each(function(){
        a.push($(this).data('id'))
    })
    if(a.length != 0)
    {
        $.ajax({
            type:'POST',
            url:'lib/rest.php',
            data:{a:a},
            async:true,
            success:function(data){
                data = $.parseJSON(data)
                //console.log(data)
                var i
                var l = data.length
                for(i = 0; i< l; i++){
                    $('.star_main[data-id='+data[i]['id']+']').empty().append('Осталось: '+data[i]['rest']+' ед.');
                    $('.green_text[data-id='+data[i]['id']+']').empty().append(data[i]['rest']+' ед.');
                }
            }

        })
    }
}

setInterval(getRest,1000)
$(document).ready(function(){

    /*$(window).scroll(function(){
        if ($(document).height() - $(window).height() <= $(window).scrollTop() + 50) {
            console.log($(window).height())
            setTimeout(
                function(){
                    $('#product_list li:hidden:lt(4)').show()
                },
                350
            )

        }
    })*/





    $('select[name=brands]').live('change', function(){
        var i = $(this).val();
        if(i != 0){
            if(location.href.indexOf('all') != -1
                || location.href.indexOf('man') != -1
                || location.href.indexOf('woman') != -1
                || location.href.indexOf('unisex') != -1
                || location.href.indexOf('child') != -1)
            {
                window.location.href = window.location.href.slice(0,window.location.href.lastIndexOf('/')+1)+i
            }
            else
            {
                window.location.href = '/index/clock/all/all/'+i
            }
            //
        }
        else
        {
            window.location.href = window.location.href.slice(0,window.location.href.lastIndexOf('/')+1)
        }
    })

   $('.more_href_main').live('click', function(){
       var brand = $(this).data('brand');
       var type_of_show = $(this).data('type_of_show');
       var type_of_type = $(this).data('type_of_type');
       var from = $('.main_page_li').length;
       var count = $(this).data('count');
       var th = $(this)
       console.log(from)
       $.ajax({
           type:"POST",
           url: 'lib/loadProducts.php',
           data: {
               brand:brand,
               type_of_show:type_of_show,
               type_of_type:type_of_type,
               from:from
           },
           success: function(data){
               $('#product_list').append(data)
               $('.clock_main').each(function(){
                   var th = $(this)
                   $(this).countdown({
                       until: $(this).data('until'),
                       layout: '{dn}д : {hn}ч : {mn}мин : {sn}сек',
                       onExpiry: function(){
                           $.ajax({
                               type:"POST",
                               url: 'lib/timeout.php',
                               data:{id:th.data('id'),
                                   period:th.data('period')},
                               success:function(resposneText){
                                   resposneText = $.parseJSON(resposneText);
                                   //console.log(resposneText)
                                   if(resposneText['period'] == 0){
                                       th.hide()
                                   }
                                   else{
                                       th.show()
                                       th.data('until',resposneText['duration']);
                                       th.data('period',resposneText['period']);
                                       th.countdown('option',{until:th.data('until')})
                                   }
                                   /*th.hide();
                                    th.next().show();*/
                                   $('.new_price',th.parents('.text_main_li') ).empty().append(resposneText['newprice']+'<span>грн.</span>')
                                   $('.text_price:eq(0)',th.parents('.text_main_li')).empty().append('Скидка составляет: <span>'+resposneText['discount']+'%</span>')
                                   $('.text_price:eq(1)',th.parents('.text_main_li')).empty().append('Вы экономите: <span>'+resposneText['economy']+' грн.</span>')
                               }
                           })
                       }
                   });
               })
               if($('.main_page_li').length >= count)
               {
                   th.parent().hide();
               }
           }
       })
       if(from >= count)
       {
           th.parent().hide();
       }


   })
})
