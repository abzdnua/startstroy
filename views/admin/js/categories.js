$(document).ready(function(){
    $(document).on('click','#add_cat',function(){
        $('#form').show()
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
        $('#form').show()
        $('[name=id]').val($(this).data('id'))
        $('[name=category_name]').val($(this).data('name'))
        $('[name=parent_id]').val($(this).data('parent'))
    })
})