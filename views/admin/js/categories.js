$(document).ready(function(){
    $(document).on('click','#add_cat',function(){
        $('#form').show()
        $('#form input, #form select').val('')
        $('#editor_title').text('Добавление новой категории')

    }).on('click','[name=save]',function(){
            console.log('123')
        if($('[name=category_name]').val()==''){
            $('[name=category_name]').css('border','1px solid red')
            return false
        }else{
            var data = {
                url: 'views/admin/ajax/categories/save_cat.php',
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
            $.post('/views/admin/ajax/categories/getCategory.php',{id:$(this).data('id')},function(data){
//                alert(data)
                $('#form').replaceWith(data)
                $('#form').show().focus()
            })



        }).on('click','.del',function(){
        if(confirm('Удалить категорию?'))
        {
            var th = $(this)
            var id=th.data('id')
            $.ajax({
                type:"POST",
                url: 'views/admin/ajax/categories/delete.php',
                data:{id:id},
                success:(function(responseText){
                    if(responseText.indexOf('error') == -1){
                        th.parent().parent().remove();
                    }
                })
            })
        }
    })
})