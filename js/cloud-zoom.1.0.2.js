//////////////////////////////////////////////////////////////////////////////////
// Cloud Zoom V1.0.2
// (c) 2010 by R Cecco. <http://www.professorcloud.com>
// MIT License
//
// Please retain this copyright header in all versions of the software
//////////////////////////////////////////////////////////////////////////////////
(function ($) {

    $(document).ready(function () {
        $('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
    });



    function CloudZoom(jWin, opts) {


}

    $.fn.CloudZoom = function (options) {

        try {

        } catch (e) {}
        this.each(function () {
			var	relOpts, opts;

			eval('var	a = {' + $(this).attr('rel') + '}');
			relOpts = a;
       if ($(this).is('.cloud-zoom-gallery')) {
                opts = $.extend({}, relOpts, options);
                $(this).data('relOpts', opts);
           var temp = +
           $('.left').bind('click', $('.active').parent(), function (event) {
               $('#zoom1 img').attr('src', event.data.data('relOpts').next);




               return false;
           });

                $(this).bind('click', $(this), function (event) {
                    $('#zoom1 img').attr('src', event.data.data('relOpts').smallImage);
                    $('#zoom1 img').attr('title', event.data.data('relOpts').title_img);
                    return false;
                });
            }
        });

        return this;
    };



})(jQuery);