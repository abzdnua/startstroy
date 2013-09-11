$(document).ready(function(){
    $(document).on('click','#add_new',function(){
        $('#form').show()
        $('#form input').val('')
        $('#editor_title').text('Добавление нового типа материала')
    }).on('click','[name=save]',function(){
            console.log('123')
            if($('[name=material_name]').val()==''){
                $('[name=material_name]').css('border','1px solid red')
                return false
            }else{
                var data = {
                    url: 'views/admin/ajax/material/save.php',
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
            $('[name=material_name]').val($(this).data('name'))
            $('#editor_title').text('Редактирование типа материала')
        }).on('click','.del',function(){
            if(confirm('Удалить материал?'))
            {
                var th = $(this)
                var id=th.data('id')
                console.log(id)
                $.ajax({
                    type:"POST",
                    url: 'views/admin/ajax/material/delete.php',
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