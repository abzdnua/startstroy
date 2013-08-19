

$(document).ready(function(){



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
                        console.log(resposneText)
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

    $('.clock_more').each(function(){
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
                        if(resposneText['period'] == 0){
                            th.hide()
                            th.prev().hide();
                        }
                        else{
                            th.show()
                            th.prev().show();
                            th.data('until',resposneText['duration']);
                            th.data('period',resposneText['period']);
                            th.countdown('option',{until:th.data('until')})
                        }
                        $('.price_more').empty().append(resposneText['newprice']+'<span>грн.</span>')
                        $('#price').empty().append(resposneText['newprice'])
                        $('#itogo').empty().append(resposneText['newprice'])
                        $('form[name=full_order] input[type=radio]:eq(0)').attr('checked','checked');
                        $('.sales_more:eq(0)').empty().append('Скидка составляет: <span>'+resposneText['discount']+'%</span>')
                        $('.sales_more:eq(1)').empty().append('Вы экономите: <span>'+resposneText['economy']+' грн.</span>')
                    }
                })
            }
        });
    })
})
