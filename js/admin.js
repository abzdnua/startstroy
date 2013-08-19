 
//------------------------------------------------
// Функция передает параметры скрипту на pfuhepre категорий
//------------------------------------------------
function promtLink(obj, action) {
	
    var link = prompt('Введите url', "http://");

    if (link != null) {
        replaceSelectedText(obj, action, link)
    }

}


//------------------------------------------------
// Функция вставляет псевдотеги
//------------------------------------------------
function replaceSelectedText(obj, action, url)
{
	var obj = document.getElementById(obj);
	var rs, add_count;
	obj.focus();
	if (document.selection) 
	{
		var s = document.selection.createRange(); 
		if (s.text)
		{
			switch (action) {
				case "bold": 
						s.text = "[strong]" + s.text + "[/strong]";
						break;
                                case "cursiv": 
						s.text = "[em]" + s.text + "[/em]";
						break;
					
				case "color": 	
						s.text = "[color]" + s.text + "[/color]";
						break;
				
				case "url": 	
						s.text = "[url=" + url + "]" + s.text + "[/url]";
						break;
			}
			
			return true;
		}
	}
	else
		if (typeof(obj.selectionStart)=="number")
 		{
			if (obj.selectionStart != obj.selectionEnd)
			{
				var start = obj.selectionStart;
				var end = obj.selectionEnd;
				
				switch (action) {
					case "bold": 
							rs = "[strong]" + obj.value.substr(start, end - start) + "[/strong]";
							add_count = 17; 
							break;
                                                        
					case "cursiv": 
							rs = "[em]" + obj.value.substr(start, end - start) + "[/em]";
							add_count = 9; 
							break;
						
					case "color": 	
							rs = "[color]" + obj.value.substr(start, end - start) + "[/color]";
							add_count = 15; 
							break;

					case "url": 	
							rs = "[url=" + url + "]" + obj.value.substr(start, end - start) + "[/url]";
							add_count = 12 + url.length; 
							break;
				}
				obj.value = obj.value.substr(0, start) + rs + obj.value.substr(end);
				obj.setSelectionRange(end + add_count, end + add_count);
			}
			return true;
		}

	return false;
}
function validate(e,reg) 
{
    var theEvent = e || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = new RegExp (reg);
    if( !regex.test(key) ) 
    {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}
function validateBlur($this,reg)
{
    $this.blur(function(){
         
        var val = $this.val();
        var regex = new RegExp (reg);
        if (!regex.test(val)) $this.val('')
    })
}

$(function(){
    var hash = (location.hash) ? location.hash : null;

    $('.validNumbers').keypress(function(e){
        validate(e,'[0-9]');
    })
    
    $('.validTime').keypress(function(e){
        validate(e,'[0-9]|:');
        validateBlur($(this),'[0-9]{1}:[0-9]{2}|[0-9]{2}:[0-9]{2}');
    })
    




    $('.addRow').click(function(){
        var id = $(this).attr('id')
        //alert(id)
        var row = $('#table\\:'+id+' tr.hidden').html()
        $('#table\\:'+id+' .btnRow').before('<tr>'+row+'</tr>')

        return false;
    })

    $('.del').live('click',function(){
        $(this).parent().parent().remove()
    })


    $('#phone').keypress(function(e){
        validate(e,'\\+|[0-9]| ');
        validateBlur($(this),'^\\+');
    })















    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('#dateReview').datepicker();
    //$('#phoneReview').mask('+389999999999');
    $('input[name="save"]').click(function(){
        var error = '';
        if (!$('#txtReview').val().replace(/ /g,' ')) error += '   Текст отзыва!\n';
        if (!$('#nameReview').val().replace(/ /g,' ')) error += '   Ваше имя!\n';
        if (!$('#dateReview').val().replace(/ /g,' ')) error += '   Дата!\n';
        if (error) 
        {
            alert('Введите следующие обязательные данные:\n'+error);
            return false;
        }
    })

    if (location.hash == '#ok')
    {
        alert('Сохранено!');
        location.hash = '';
    }
 

})