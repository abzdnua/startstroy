$(document).ready(function(){




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
            if($('[name=product_img_val]').val()=='')  {
                $('[name=product_img]').css('color','red')
                return false
            }
            else
            {
                $('[name=product_img]').css('color','black')
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

        })

})