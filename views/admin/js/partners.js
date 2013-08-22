$(document).ready(function(){
    $(document).on('click','#add_new',function(){
        $('#form').show()
    }).on('click','[name=save]',function(){
            console.log('123')
            if($('[name=partner_name]').val()=='')  {
                $('[name=partner_name]').css('border','1px solid red')
                return false
            }

            else{
                var data = {
                    url: 'views/admin/ajax/partners/save.php',
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
            $('[name=partner_name]').val($(this).data('name'))
            $('[name=partner_des]').val($(this).data('des'))
            $('[name=partner_img]').val($(this).data('img'))
            $('[name=partner_link]').val($(this).data('link'))
        }).on('click','.del',function(){
            if(confirm('Удалить партнера?'))
            {
                var th = $(this)
                var id=th.data('id')
                console.log(id)
                $.ajax({
                    type:"POST",
                    url: 'views/admin/ajax/partners/delete.php',
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