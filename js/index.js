var doit;	
$(document).ready(function() {
    var func={
        size:function()
        {
          return  ('innerWidth' in window) ? window.innerWidth : document.body.offsetWidth;
        },
        style:function(){
           	var size= func.size();
        	if (size<=1371) {css='1320';}
            else {css=1400;}
           	document.getElementById('fsize').setAttribute('href', 'css/styles_'+css+'.css');
        },
        chimg:function()
        {
            $('img').each(function() {
        	var splitin=$(this).attr('src').split('/');
        	var size=$(window).width();
    		if (size<=1371) {css='1320';}
    		if (size>1371) {css='1400';}
    		var length=$(this).attr('src').length;
    		file_name=$(this).attr('src').substr($(this).attr('src').lastIndexOf('/')+1);
    		file_name_length=file_name.length;
    		if($(this).attr('src').substr($(this).attr('src'),length-file_name_length).indexOf('1000')!=-1)
    		{
    			$(this).attr('src',$(this).attr('src').substr($(this).attr('src'),length-file_name_length).replace('1000',css)+file_name);
    		}
    		if($(this).attr('src').substr($(this).attr('src'),length-file_name_length).indexOf('1240')!=-1)
    		{
    			$(this).attr('src',$(this).attr('src').substr($(this).attr('src'),length-file_name_length).replace('1240',css)+file_name);
    		}
    		if($(this).attr('src').substr($(this).attr('src'),length-file_name_length).indexOf('1320')!=-1)
    		{
    			$(this).attr('src',$(this).attr('src').substr($(this).attr('src'),length-file_name_length).replace('1320',css)+file_name);
    		}
    		if($(this).attr('src').substr($(this).attr('src'),length-file_name_length).indexOf('1400')!=-1)
    		{
    			$(this).attr('src',$(this).attr('src').substr($(this).attr('src'),length-file_name_length).replace('1400',css)+file_name);
    		}
        });
        }
    }
    func.style();
    //func.chimg();
    $(window).bind('resize',function(){
      clearTimeout(doit);
      doit = setTimeout(function(){
      func.style();
      //func.chimg();
} , 100)
})
});

