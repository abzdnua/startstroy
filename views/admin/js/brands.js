$(document).ready(function(){
    $('#add_brand').live('click', function(){
        console.log(123);
        var th = $(this)
        var br = {
            url: 'views/admin/ajax/brands/add_brand.php',
            beforeSubmit: function(jqForm){
                th.attr('disabled','disabled')
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
                th.removeAttr('disabled')
            }
        }

        th.parents('form').ajaxSubmit(br)
        return false
    })

    $('.refresh').live('click', function(){
        var name = $('input[name=brand]', $(this).parent('td').prev('.brand_info')).val();
        var id = $('input[name=brand_id]', $(this).parent('td').prev('.brand_info')).val();
        $.ajax({
            type:"POST",
            url: 'views/admin/ajax/brands/refresh.php',
            data:{id:id, name:name},
            success:(function(responseText){
                console.log(responseText);
            })
        })
    })

    $('.del_brand').live('click',function(){
        var id =  $('input[name=brand_id]', $(this).parent('td').prev().prev('.brand_info')).val();
        var th = $(this);
        if(confirm('Удалить бренд?'))
        {
            $.ajax({
                type:"POST",
                url: 'views/admin/ajax/brands/delete.php',
                data:{id:id},
                success:(function(responseText){
                    if(responseText.indexOf('error') == -1){
                        th.parent().parent().remove();
                    }
                })
            })
        }
        else
        {
            return false;
        }
    })
})
