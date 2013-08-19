$(document).ready(function(){


    $('.for_countdown').countdown({until: $('.for_countdown').data('until'),format:'DHMS',layout: '{dn} Дней {hn} Часов {mn} Минут {sn} Секунд'});

//Загрузка основного фото
    $('input[name=main_img]').live('change',function ()
    {
        var photoLoader =
        {
            url:   'views/admin/ajax/products/imgLoader.php',
            beforeSubmit:(function(jqForm){
                console.log(jqForm);
                $('#preloader').append('<img src="sc_img/admin/ajax-loader.gif" >')
            }),
            success: function(data)
            {
                $('#preloader').empty();
                console.log(data)
                if(data.indexOf('Ошибка') != -1)
                {
                    alert(data)
                }
                else
                {
                    $('#for_image').empty().append(data)
                }
            }
        };
        $(this).parents('form').ajaxSubmit(photoLoader);
        return false;
    })


//Загрузка видеоролика
    $('input[name=add_video]').live('click',function(){
        var th = $(this);
        var link = $('input[name=video_link]').val()
        if(link.length == 0){
            $('input[name=video_link]').css('border','1px solid red');
            alert('Введите ссылку на видеоролик')
        }
        else
        {
            $.ajax({
                type: "POST",
                url : 'views/admin/ajax/products/videoLoader.php',
                beforeSend: function(){
                    th.attr('disabled','disabled')
                    $('#preloader_v').append('<img src="sc_img/admin/ajax-loader.gif" >')
                },
                data:{link:link},
                success: function(data){
                    console.log(data);
                    if(data.indexOf('Ошибка') == -1){
                        $('#for_video').empty().append(data)
                    }
                    else{
                        alert(data);
                    }
                    $('#preloader_v').empty()
                    th.removeAttr('disabled')
                }
            })
        }

    })

//Загрузка фотогаллереи
    $('#load_imgs').live('click',function(){
        var th = $(this)
        var options;
        options = {
            url : 'views/admin/ajax/products/imgsLoader.php',
            beforeSubmit: function(jqForm){
                $('#preloader_g').append('<img src="sc_img/admin/ajax-loader.gif" >')
                th.attr('disabled','disabled')
            },
            success: function(responseText){
                $('#for_mistakes').prev().remove();
                $('#for_mistakes').remove();
                if(responseText.indexOf('error') != -1)
                {
                    alert(responseText);
                }
                else
                {
                    $('#for_gallery').append(responseText);
                }
                $('#preloader_g').empty();
                th.removeAttr('disabled')
            }
        }
        $(this).parents('form').ajaxSubmit(options);
        return false;
    })


    $('.del_gal_photo').live('click',function(){
        var th = $(this);
        var src = $(this).prev('img').attr('src');
        var img = src.slice(src.lastIndexOf('/')+1,src.length);
        $.ajax({
            type:"POST",
            url:'views/admin/ajax/products/delGalPhoto.php',
            data:{img : img},
            success:(function(responseText){
                console.log(responseText)
                if(responseText.indexOf('error') == -1)
                {
                    th.parents('.float_left').remove();
                }
                else
                {
                    alert(responseText);
                }

            })
        })
    })

    $('.del_video').live('click', function(){
        $(this).parents('#for_video').empty();
    })

    $('#add_char').live('click', function(){
        var count = $('.char',$(this).parents('td')).length;


        $(this).before('<div class="char">Наименование: <input style="width: 150px;margin-right: 29px;" name="c_name_'+(count+1)+'" type="text"  class="name"/> Значение: <input style="width: 252px;" name="c_value_'+(count+1)+'" type="text" class="value"/><div class="del_char" title="Удалить характеристику"><img src="sc_img/admin/remove.png" /></div></div>')
        $('input[name=char_count]').val(count+1);
    })

    $('.del_char').live('click',function(){
        var count = $('.char',$(this).parents('td')).length -1;
        $(this).parents('.char').remove();
        var i = 1;
        $('.name').each(function(){
            $(this).attr('name','c_name_'+i)
            i++
        })
        var i = 1;
        $('.value').each(function(){
            $(this).attr('name','c_value_'+i)
            i++
        })
        $('input[name=char_count]').val(count);
    })


    //Сохранить товар
    $('#save_product').live('click', function(){
        var count = $('.sm_img',$('#for_gallery')).length;
        if(count == 1)
        {
            var src = $('.sm_img',$('#for_gallery')).attr('src');
            var img = src.slice(src.lastIndexOf('/')+1,src.length);
            $(this).parents('form').append('<input type="hidden" name="gallery" value="'+img+'">')
        }
        else
        {
            img = [];
            $('.sm_img',$('#for_gallery')).each(function(){
                var src = $(this).attr('src');
                img.push(src.slice(src.lastIndexOf('/')+1,src.length));
            })
            $(this).parents('form').append('<input type="hidden" name="gallery" value="'+img+'">')
        }

        var save = {
            url:'views/admin/ajax/products/saveProduct.php',
            beforeSubmit: function(jqForm){
                console.log(jqForm)
            },
            success: function(responseText){
                console.log(responseText);
                responseText = $.parseJSON(responseText);
                console.log(responseText)
                if(responseText['err'])
                {
                    alert(responseText['err'])
                }
                else
                {
                    alert('Данные успешно сохранены')
                    document.location.href = '/admin/products'
                }
            }
        }
        $(this).parents('form').ajaxSubmit(save)
        return false;
    })

    //Выбор дополнительной скидки
    $('#add_discount').live('click', function(){
        var d_type = $('select[name=discounts]').val()
        switch (d_type){
            case 'timer':
                $('#timer_discount').show()
                $('#timer_discount').append('<input type="hidden" name="with_timer_discount" value="1">')
                break;
            case 'count':
                $('#count_discount').show()
                $('#count_discount').append('<input type="hidden" name="with_count_discount" value="1">')
                break;
        }
    })

    $('.del_discount').live('click', function(){
        $(this).parents('fieldset').hide();
        $('input[type=hidden]',$(this).parents('fieldset')).remove();
    })


    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: 'Пред',
        nextText: 'След',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
            'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
            'Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Не',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['ru']);
    $("input[name=date_start]").datepicker();
    var istouch;
    if((!!('ontouchstart' in window)))
    {
        istouch='touchend';
    }
    else
    {
        istouch='click';
    }
    $('input[name=date_start]').on(istouch,function()
    {
        $(this).datepicker('show')
    })


    $('input[name=is_present]').live('change', function(){
        if($(this).is(':checked')){
            $('tr',$(this).parents('form')).not('.for_present').hide();
        }
        else
        {
            $('tr',$(this).parents('form')).not('.for_present').show();
        }
    })

    $('#add_present').live('click',function(){
        var th = $(this);
        var present = $('select[name=presents]').val();
        if(present != 0){
            $.ajax({
                type: "POST",
                url: 'views/admin/ajax/products/getPresent.php',
                beforeSend: function(){
                        th.attr('disabled','disabled');
                    },
                data: {present : present},
                success: function(responseText){
                    if(responseText != 0)
                    {
                        $('#for_present').empty().append(responseText);
                    }
                    th.removeAttr('disabled');
                }
            })
        }
        else{
            return false;
        }
    })

    $('.del_present').live('click',function(){
        $('#for_present').empty();
    })

    $('.del_product').live('click',function(){
        var id = $(this).prev('input').val()
        if(confirm('Вы действительно делаете удалить данный товар?'))
        {
            $.ajax({
                type:"POST",
                url:"views/admin/ajax/products/delete.php",
                data:{id:id},
                success:(function(){

                })
            })
        }
        else
        {
            return false
        }
    })
})