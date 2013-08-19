function getRest(){
    var a = []
    $('.star_main, .ost_tovara').each(function(){
        if($(this).data('id'))
        {
            a.push($(this).data('id'))
        }

    })
    //console.log(a);
    if(a.length > 0)
    {
        $.ajax({
            type:'POST',
            url:'lib/rest.php',
            data:{a:a},
            async:true,
            success:function(data){
                data = $.parseJSON(data)
                console.log(data)
                var i
                var l = data.length
                for(i = 0; i< l; i++){
                    $('.star_main[data-id='+data[i]['id']+']').empty().append(data[i]['rest']+' ед.');
                    $('.ost_tovara[data-id='+data[i]['id']+']').empty().append('Осталось товара: <span>'+data[i]['rest']+' ед.</span>');
                    if(data[i]['rest'] == 0)
                    {
                        $('.buy_button').unbind('click').addClass('buy_button_disabled');
                        $('form[name=one_click] input[type=submit]').attr('disabled', 'disabled');
                        $('form[name=full_order] .bt_buy').unbind('click').addClass('bt_buy_disabled');
                    }
                }
            }

        })
    }
}

setInterval(getRest,1000)

$(document).ready(function(){
    $('.buy_button_disabled').unbind('click')
})

