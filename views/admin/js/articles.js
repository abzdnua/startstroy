$(document).ready(function(){
    $(document).on('click','#add_new',function(){
        $('#form').show()
    }).on('click','[name=save]',function(){
            console.log('123')
            if($('[name=article_name]').val()=='')  {
                $('[name=article_name]').css('border','1px solid red')
                return false
            }

            else
            {
                $('[name=article_name]').css('border','none')
            }
            if($('[name=article_thumb_val]').val()=='')  {
                $('[name=article_thumb]').css('color','red')
                return false
            }
            else
            {
                $('[name=article_thumb]').css('color','black')
            }
            {
                var data = {
                    url: 'views/admin/ajax/articles/save.php',
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
            $.post('/views/admin/ajax/articles/getArticle.php',{id:$(this).data('id')},function(data){
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
                    url: 'views/admin/ajax/articles/delete.php',
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

        })
})