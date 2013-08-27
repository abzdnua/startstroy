$(document).ready(function(){




    $(document).on('click','#add_new',function(){
        $('#form').show()
    }).on('click','[name=save]',function(){

            if($('[name=objects_name]').val()=='')  {
                $('[name=objects_name]').css('border','1px solid red')
                return false
            }

            else
            {
                $('[name=objects_name]').css('border','none')
            }
            if($('[name=objects_date]').val()=='')  {
                $('[name=objects_date]').css('border','1px solid red')
                return false
            }

            else
            {
                $('[name=objects_date]').css('border','none')
            }
          /*  if($('[name=objects_img_val]').val()=='')  {
                $('[name=objects_img]').css('color','red')
                return false
            }
            else
            {
                $('[name=objects_img]').css('color','black')
            }*/
            {
                var data = {
                    url: 'views/admin/ajax/ready_objects/save.php',
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
            $.post('/views/admin/ajax/ready_objects/getArticle.php',{id:$(this).data('id')},function(data){
//                alert(data)
                $('#form').replaceWith(data)
                $('#form').show()
            })



        }).on('click','.del',function(){
            if(confirm('Удалить статью?'))
            {
                var th = $(this)
                var id=th.data('id')
                console.log(id)
                $.ajax({
                    type:"POST",
                    url: 'views/admin/ajax/ready_objects/delete.php',
                    data:{id:id},
                    success:(function(responseText){
                        console.log(responseText)
                        if(responseText.indexOf('error') == -1){
                            th.parent().parent().remove();
                        }
                    })
                })
            }
        }).on('change','[name=article_thumb]',function(){
            $('[name=article_thumb_val]').val($('[name=article_thumb]').val())

        }).on('change','[name=article_img]',function(){
            $('[name=article_img_val]').val($('[name=article_img]').val())

        })

})