
(function($) {
	$.fn.gal = function(options){
        var current=0;
        var length=$('.gal').size();
        var istouch;
        var total=0,totaldeliv=0;
        if(options) $.extend(settings, options);
        var folder,type="png",img,img_delim="~",ajax=false,prefolder;
        var next,prev;
        if((!!('ontouchstart' in window)))
        {
            istouch='touchstart';
        }
        else
        {
            istouch='click';
        }
	   
            var fungal={
                ajaxs:function(data,f)
                {
                     $.ajax({
                        type: "POST",
            			url: "../s/img.php",
            			data: data,
            			success: f
                		});
                },
                fsizegalch:function()
                {
                    var size =('innerWidth' in window) ? window.innerWidth : document.body.offsetWidth;
                    if (size<=1200) {css='sgal1';prefolder="size1";}
                    else
                	if (size>1200 && size<1600) {css='sgal2';prefolder="size2";}
                    else {css='sgal3';prefolder="size3";}
                   	document.getElementById('galsize').setAttribute('href', 'css/'+css+'.css');
                    return prefolder;
                },
                left:function()
                {
                   if(length>1 && $('.gallery img:animated').length==0)
                    {
                        if(current<1)
                        {
                            current=length-1;
                        }
                        else
                        {
                            current--;
                        }
                        $('.preloader').css('background-image','')
                        $('#viewImg').fadeOut(500,function()
                        {
                            //$(this).remove();
                            $('#viewImg').attr('src',folder+fungal.fsizegalch()+'/'+img[current]);
                            //$('#for-map').append('<img id="viewImg" style="display:none" src="'+folder+fungal.fsizegalch()+'/'+img[current]+'"/>');
                            $('#viewImg').load(function(){
                                $('#for-map img').fadeIn(500)
                                $('.preloader').css('background-image','none')
                            })
                        })
                        
                        $('#count').text((current+1)+' / '+length)
                    }
                },
                right:function()
                {
                    if(length>1 && $('.gallery img:animated').length==0)
                    {

                        current++;
                        if(current>length-1)
                        {
                            current=0;
                        }    
                        $('.preloader').css('background-image','')
                        $('#viewImg').fadeOut(500,function()
                        {
                            //$(this).remove();
                            $('#viewImg').attr('src',folder+fungal.fsizegalch()+'/'+img[current]);
                            //$('#for-map').append('<img id="viewImg" style="display:none" src="'+folder+fungal.fsizegalch()+'/'+img[current]+'"/>');
                            $('#viewImg').load(function(){
                                $('#for-map img').fadeIn(500);
                                $('.preloader').css('background-image','none')
                            })
                            
                        })
                        $('#count').text((current+1)+' / '+length)
                        
                    }
                }
            }
            fungal.fsizegalch();
            $(this).on(istouch,function()
            {
                db=$(this).data('db');
                folder=$(this).data('folder')
                type=(typeof($(this).data('type'))!=="undefined")?$(this).data('type'):type;
                current=(typeof($(this).data('current'))!=="undefined")?$(this).data('current'):current;
                //console.log(current)
                ajax= $(this).data('ajax') 
                //alert( current)
                if(ajax != "undefined") {
                    fungal.ajaxs({dir:folder,db:db},function(data)
                    {
                        current -= 1;
                        img=eval(data)
                        length=img.length;

                        if(current>length-1) current = length 

                        var src = folder+fungal.fsizegalch()+'/'+img[current];
                         
                        $('.preloader').css('background-image','')
                        $('#for-map').append('<img id="viewImg" style="display:none" src="'+src+'"/>').fadeIn(500);
                        $('#viewImg').load(function(){
                            $('#for-map img').fadeIn(500)
                            $('.preloader').css('background-image','none')
                        })

                        //$('#for-map').append('<img src="'+folder+fungal.fsizegalch()+'/'+img[current]+'"/>');
                        $('#count').text((current+1)+' / '+length)
                        //console.log(img )
                         
                    })
                   
                }
                else
                {
                    img_delim=(typeof($(this).data('img-delim'))!=="undefined")?$(this).data('img-delim'):img_delim
                    img=$(this).data('img');
                    if(img.indexOf(img_delim)==-1)
                    {
                        img=[$(this).data('img')];
                    }
                    else
                    {
                        img=img.split(img_delim);
                    }
                     
                     length=img.length
                     current=length-1
                    

                    var src = folder+fungal.fsizegalch()+'/'+img[current];
                    $('.preloader').css('background-image','')
                    $('#for-map').append('<img id="viewImg" style="display:none" src="'+src+'"/>').fadeIn(500);
                    $('#viewImg').load(function(){
                            $('#for-map img').fadeIn(500)
                            $('.preloader').css('background-image','none')
                        })

                    //$('#for-map').append('<img src="'+folder+fungal.fsizegalch()+'/'+img[current]+'"/>');
                    $('#count').text(current+1+' / '+length)              
                }
                
                $('.gallery').removeClass('display-none')
                 return false;
            })  
        
            $('.top_right_arrow').on(istouch,function()
            {
                fungal.right();
            })
            $('.top_left_arrow').on(istouch,function()
            {
                fungal.left();
            })
            $('.galery_back,.close_photos_gal').on(istouch,function(){
			console.log('qw');
                $('#viewImg').remove()
                $('.gallery').addClass('display-none')
                 
            })
            
            $(window).resize(function()
            {
                $('.galery_back').trigger('click');
                fungal.fsizegalch();
            })
            $(document).keydown(function(e)
            {
                if(e.keyCode==27)
                {
                    $('.galery_back').trigger('click')
                }
                if(e.keyCode==39)
                {
                    //ïðàâî
                    fungal.right()
                }
                if(e.keyCode==37)
                {
                    //ëåâî
                    fungal.left()
                }
                
            })
       
	  
	}
})(jQuery);
$(function()
{
	$('.gal').gal();
})
