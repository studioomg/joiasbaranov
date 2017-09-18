//var $ = jQuery.noConflict();

(function ( $ ) {

    $.fn.swapImages = function( options ) {

        var settings = $.extend({
            fade: 1000
        }, options );
        
        
        var activeTeam = $(this).find('.active');
        var nextTeam = ($(this).find('.active').next().length > 0) ? $(this).find('.active').next() : $(this).find('img:first');
        activeTeam.fadeOut(settings.fade, function(){
            activeTeam.removeClass('active');
            nextTeam.fadeIn(settings.fade).addClass('active');
        });
    };
    
}( jQuery ));