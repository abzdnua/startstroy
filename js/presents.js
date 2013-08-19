$(document).ready(function(){

    $('#present_bt, .surprize').live('click', function(){
        var id = $(this).data('id')
        $.ajax({
            type: "POST",
            url: "lib/getPresentImg.php",
            data:{id:id},
            success: function(data){
                $('#popup_bg_present').show()
                $('#for_present').empty().append(data)
            }
        })
    })

    $('.bt_present_close').click(function(){
        document.getElementById('popup_bg_present').style.display = "none";

    })
})