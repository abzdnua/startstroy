$(document).ready(function(){
    $('.del_review').live('click',function(){
        var id = $('input[type=hidden]',$(this).parent().parent()).val();
        var th = $(this)
        if(confirm('Вы действительно хотите удалить этот отзыв?'))
        {
            $.ajax({
                type:"POST",
                url:"views/admin/ajax/reviews/delete.php",
                data:{id:id},
                success:function(data){
                    th.parent().parent().remove()
                }
            })
        }
        else
        {
            return false
        }
    })

    $('.edit_review').live('click', function(){
        var id = $('input[type=hidden]',$(this).parent().parent()).val();
        $.ajax({
            type:"POST",
            url:"views/admin/ajax/reviews/getReview.php",
            data:{id:id},
            success:function(data){
                    $('#form_edit').empty().append(data);
            }
        })
    })

    $('.sbm').live('click',function(){
        var th = $(this)
        var send = {
            url:"views/admin/ajax/reviews/save.php",
            beforeSubmit: function(jqForm){
                th.attr('disabled','disabled')
                console.log(jqForm)
            },
            success: function(data){
                th.parents('form').hide();
                window.location.reload()
            }
        }
        th.parents('form').ajaxSubmit(send);
        return false;
    })

    $('#add_rw').live('click', function(){
        $('#form').show();
    })


})