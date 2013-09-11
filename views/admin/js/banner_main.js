$(document).ready(function(){




    $(document).on('click','#add_new',function(){
        $('#form').show()
        $('#form input').val('')
    }).on('click','[name=save]',function(){

            if($('[name=str1]').val()=='')  {
                $('[name=str1]').css('border','1px solid red')
                return false
            }
            else
            {
                $('[name=str1]').css('border','')
            }
            if($('[name=banner_img_val]').val()=='')  {
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
                $('#form').html(data).show()
                $(window).scrollTop(0)
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
        }).on('change','[name=banner_img]',function(){
            $('[name=banner_img_val]').val($('[name=banner_img]').val())
        })

})