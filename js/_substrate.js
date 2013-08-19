function substrateAdd()
{
    $('body').prepend('<div id="substrateByFunction" style="' +
        'position:fixed;' +
        'z-index:10000000;' +
        'width:100%;' +
        'height:100%;' +
        'display:none;' +
        'background-color:#dbf1fb;"></div>');
    $('#substrateByFunction').css('opacity','0.5').fadeIn('fast');
}

function substrateRemove()
{
     $('#substrateByFunction').fadeOut('fast').remove();
}