$(document).ready(function(){
    $(document).on('click','#add_new',function(){
        $('#form').show()
    }).on('click','[name=save]',function(){

            if($('[name=name]').val()=='')  {
                $('[name=name]').css('border','1px solid red')
                return false
            }

            else
            {
                $('[name=name]').css('border','none')
            }
            if($('[name=partner_img_val]').val()=='')  {
                $('[name=partner_img]').css('color','red')
                return false
            }
            else
            {
                $('[name=partner_img]').css('color','black')
            }
            {
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
            $.post('/views/admin/ajax/partners/getPartner.php',{id:$(this).data('id')},function(data){
                $('#form').html(data).show()
                $(window).scrollTop(0)
            })



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
        }).on('change','[name=partner_img]',function(){
            $('[name=partner_img_val]').val($('[name=partner_img]').val())

        })
})