$(document).ready(function(){
    $(document).on('click','#add_new',function(){
        $('#form').show()
        $('#form input').val('')
        $('#editor_title').text('Добавление нового производителя')
    }).on('click','[name=save]',function(){
            console.log('123')
            if($('[name=firm_name]').val()==''){
                $('[name=firm_name]').css('border','1px solid red')
                return false
            }else{
                var data = {
                    url: 'views/admin/ajax/firms/save.php',
                    beforeSubmit: function(jqForm){
                        $(this).attr('disabled','disabled')
                        console.log(jqForm)
                    },
                    success: function(responseText){
                        console.log(responseText)
                        if(responseText.indexOf('error') == -1)
                        {
                            $('#form').before(responseText);
                        }
                        else{
                            alert(responseText)
                        }
                        $(this).removeAttr('disabled')
                    }
                }

                $(this).parents('form').ajaxSubmit(data)
            }
        }).on('click','.edit',function(){
            $('#form').show().focus()
            $('[name=id]').val($(this).data('id'))
            $('[name=firm_name]').val($(this).data('name'))
            $('#editor_title').text('Редактирование производителя')
        }).on('click','.del',function(){
            if(confirm('Удалить производителя?'))
            {
                var th = $(this)
                var id=th.data('id')
                console.log(id)
                $.ajax({
                    type:"POST",
                    url: 'views/admin/ajax/firms/delete.php',
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