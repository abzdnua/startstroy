$(document).ready(function(){




    $(document).on('click','#add_new',function(){
        $('#form').show()
    }).on('click','[name=save]',function(){


            if($('[name=banner_img]').val()=='')  {
                $('[name=banner_img]').css('color','red')
                return false
            }
            else
            {
                $('[name=banner_img]').css('color','black')
            }
            {
                var data = {
                    url: 'views/admin/ajax/banner_main/save.php',
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
            $.post('/views/admin/ajax/banner_main/getArticle.php',{id:$(this).data('id')},function(data){
//                alert(data)
                $('#form').replaceWith(data)
                $('#form').show()
            })



        }).on('click','.del',function(){
            if(confirm('Удалить баннер?'))
            {
                var th = $(this)
                var id=th.data('id')
                console.log(id)
                $.ajax({
                    type:"POST",
                    url: 'views/admin/ajax/banner_main/delete.php',
                    data:{id:id},
                    success:(function(responseText){
                        console.log(responseText)
                        if(responseText.indexOf('error') == -1){
                            th.parent().parent().remove();
                        }
                    })
                })
            }
        })

})