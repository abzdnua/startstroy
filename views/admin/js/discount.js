$(document).ready(function(){
    var night_discount;
    night_discount = {
        url: 'views/admin/ajax/discount/night_discount.php',
        beforeSubmit: function () {
            $('form[name=night_discount] input[type = button]').attr('disabled','disabled')
        },
        success: function (data) {
            data = $.parseJSON(data)
            console.log(data)
            if(data['err'])
            {
                alert(data['err'])
                $('form[name=night_discount] input[type = button]').removeAttr('disabled')
            }
            else
            {
                alert('Данные успешно обновлены')
                $('form[name=night_discount] input[type = button]').removeAttr('disabled')
            }
        }
    }

    var dw_discount;
    dw_discount = {
        url: "views/admin/ajax/discount/dw_discount.php",
        beforeSubmit: function(jqForm){
            console.log(jqForm)
            $('form[name=dw_discount] input[type = button]').attr('disabled','disabled')
        },
        success: function(data){
            data = $.parseJSON(data)
            if(data['err'])
            {
                alert(data['err'])
                $('form[name=dw_discount] input[type = button]').removeAttr('disabled')
            }
            else
            {
                alert('Данные успешно обновлены')
                $('form[name=dw_discount] input[type = button]').removeAttr('disabled')
            }
        }

    }



    $("form[name=night_discount] input[type=button]").on('click',function(){
        $("form[name=night_discount]").ajaxSubmit(night_discount)
    })

    $("form[name=dw_discount] input[type=button]").on('click',function(){
        $("form[name=dw_discount]").ajaxSubmit(dw_discount)
    })
})
