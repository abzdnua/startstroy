$(document).ready(function(){
    $('.del').live('click',function(){
        var id = $('input[type=hidden]',$(this).parent().parent()).val();
        var th = $(this)
        if(confirm('Вы действительно хотите удалить этот отзыв?'))
        {
            $.ajax({
                type:"POST",
                url:"views/admin/ajax/reviews/delete.php",
                data:{id:id},
                success:function(data){
                    th.parent().parent().remove()
                }
            })
        }
        else
        {
            return false
        }
    })

    $('.edit').live('click', function(){
        var id = $(this).data('id');
        $.ajax({
            type:"POST",
            url:"views/admin/ajax/reviews/getReview.php",
            data:{id:id},
            success:function(data){
                    $('#form').html(data).show()


            }
        })
    })

    $(document).on('click','[name=save]',function(){
        console.log('123')
        if($('[name=name]').val()=='')  {
            $('[name=name]').css('border','1px solid red')
            return false
        }else{
            $('[name=product_name]').css('border','none')
        }

        if($('[name=review]').val()=='')  {
            $('[name=review]').css('border','1px solid red')
            return false
        }else{
            $('[name=product_priceforsale]').css('border','none')
        }
        {
            var data = {
                url: 'views/admin/ajax/reviews/save.php',
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
    })

    $('#add_rw').live('click', function(){
        $('#form').show();
        $('#form_edit').hide();
    })


})