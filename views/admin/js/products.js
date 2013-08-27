$(document).ready(function(){
//Добавление характеристики
    $('#add_char').live('click', function(){
        var count = $('.char',$(this).parents('td')).length;


        $(this).before('<div class="char">Наименование: <input style="width: 150px;margin-right: 29px;" name="c_name_'+(count+1)+'" type="text"  class="name"/> Значение: <input style="width: 252px;" name="c_value_'+(count+1)+'" type="text" class="value"/><div class="del_char" title="Удалить характеристику"><img src="img/admin/remove.png" /></div></div>')
        $('input[name=char_count]').val(count+1);
    })

    //удаление характеристики
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



    $(document).on('click','#add_new',function(){
        $('#form').show()
    }).on('click','[name=save]',function(){
            console.log('123')
            if($('[name=product_name]').val()=='')  {
                $('[name=product_name]').css('border','1px solid red')
                return false
            }

            else
            {
                $('[name=product_name]').css('border','none')
            }
            if($('[name=product_priceforsale]').val()=='')  {
                $('[name=product_priceforsale]').css('border','1px solid red')
                return false
            }

            else
            {
                $('[name=product_priceforsale]').css('border','none')
            }
            if($('[name=product_img_val]').val()=='')  {
                $('[name=product_img]').css('color','red')
                return false
            }
            else
            {
                $('[name=product_img]').css('color','black')
            }

            if($('[name=category_id]').val()=='')  {
                $('[name=category_id]').css('color','red')
                return false
            }
            else
            {
                $('[name=category_id]').css('color','black')
            }


            {
                var data = {
                    url: 'views/admin/ajax/products/save.php',
                    beforeSubmit: function(jqForm){
                        $(this).attr('disabled','disabled')
                        console.log(jqForm)
                    },
                    success: function(responseText){
                        console.log(responseText)
                        if(responseText.indexOf('error') == -1)
                        {
                            location.reload();
                        }
                        else{
                            alert(responseText)
                        }
                        $(this).removeAttr('disabled')
                    }
                }

                $(this).parents('form').ajaxSubmit(data)
                return false;
            }
        }).on('click','.edit',function(){
            $.post('/views/admin/ajax/products/getProduct.php',{id:$(this).data('id')},function(data){
//                alert(data)
                $('#form').replaceWith(data)
                $('#form').show()
            })



        }).on('click','.del',function(){
            if(confirm('Удалить товар??'))
            {
                var th = $(this)
                var id=th.data('id')
                console.log(id)
                $.ajax({
                    type:"POST",
                    url: 'views/admin/ajax/products/delete.php',
                    data:{id:id},
                    success:(function(responseText){
                        console.log(responseText)
                        if(responseText.indexOf('error') == -1){
                            th.parent().parent().remove();
                        }
                    })
                })
            }
        }).on('change','[name=product_img]',function(){
            $('[name=product_img_val]').val($('[name=product_img]').val())

        }).on('change','[name=category_id]',function(){
            var id = $(this).val()
            console.log(id)
            var th=$(this)
            $.post('views/admin/ajax/products/getSelect.php',{id:id},function(data){
                $('[name=subCategory_id]').parent().parent().remove()
                th.parent().parent().after('<tr><td>Подкатегория</td><td>'+data+'</td></tr>')
            })
        })

})