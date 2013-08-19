/*Created by Sergey Brilenko*/
(function( $ ){
	$.fn.ini = function(options){
       var istouch,ishover, arrowis;
       if((!!('ontouchstart' in window)))
       {
            istouch='touchend';
            ishover='focusout';
            arrowis='touchstart'
       }
       else
       {
            istouch='click';
            ishover='focusout';
            arrowis='click'
       }
		var ini={
		    ok:function(th)
            {
                $('input[type="submit"]',th.parent()).remove()
                $("<input type='submit' class='okinput' value='Ок'/>").insertBefore(th)
            },
		    init:function($this)
            {
            },
            ajaxsender:function(ajaxdata,f_)
            {
                $.ajax({
    			url: "/ajax.php",
    			type: "post",
                dataType: 'json',
                data:ajaxdata,
    			async: false,
    			success:f_
		      })
            }
		}
        this.on(istouch,function(){ console.log($(this).attr('readonly')); ini.init($(this))}).attr('value','').mask("+38 (999) 999 99 99",{completed:function()
                 {
                    ini.ok($(this))
                    
                 }});
        this.on('keyup',function()
        {
            if($(this).val().indexOf('_')!=-1)
            {
                $('input[type="submit"]',$(this).parent()).remove()
            }
        })
        this.on('keydown',function(e)
        {
            if(e.keyCode==13)
            {
                if($('.okinput').length!=0)
                {
                    $('.okinput').trigger('click')
                }
                 e.stopPropagation()
                 e.preventDefault() 
                 return false
            }
        })
        this.on('paste',function()
        {
            var t=$(this)
            setTimeout(function() {
                (t.val().indexOf('_')!=-1)?$('input[type="submit"]',t.parent()).remove():ini.ok(t)
            },100)
            
            
        })
        $(document).on('click','.okinput',function()
        {
            var th=$(this);
            var okinput=
            {
                url:'/in.php',
                beforeSubmit: function(jqForm) 
                {
                    var ob=new Object(); ob.name='l';ob.value=window.location.pathname;jqForm.push(ob);
                },
                success: function(responseText) 
                { 
                    responseText=$.parseJSON(responseText);
                    if(responseText.err)
                    {
                        $('.after-disc-card-text-before-err').remove()
                        $("<div class='after-disc-card-text-before-err'>"+responseText.err+"</div>").insertBefore('.after-disc-card-text')
                    }
                    else
                    if(responseText.i)
                    {
                        location.href=responseText.lo
                    }
                }
            };
            th.parent().ajaxSubmit(okinput); 
            return false; 
        })
        $('.after-disc-card-text').on(istouch,'.dotted',function()
        {
            var dotted=$('.dotted',$(this).parent())
            var nodotted=$('.nodotted',$(this).parent())
            dotted.addClass('nodotted').removeClass('dotted')
            nodotted.addClass('dotted').removeClass('nodotted')
            if($('.thiso').hasClass('dotted'))
            {
                 $('input[name=in]').attr('value','').mask("9999 9999 9999 9999",{completed:function()
                 {
                    ini.ok($(this))
                 }
                 });
            }
            else
            {
                $("input[name=in]").attr('value','').mask("+38 (999) 999 99 99",{completed:function()
                 {
                    ini.ok($(this))
                 }});
            }
            
        })
	}
})(jQuery);
$(function()
{
    $('input[name=in]').ini()
})		