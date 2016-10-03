$(document).ready(function() {
             /*checkWidthForToogle();

             $('#menu_toggle').click(function(e){
				e.preventDefault();
				if( $('#izquierda').is(":visible") ){
				    //alert('Elemento visible');
				    $("#izquierda").css({
                	'display':'none'
	                });
	                $("#centro").css({
                	'margin-left':'0px'
	                });
				}else{
				    //alert('Elemento oculto');
				    $("#izquierda").css({
                	'display':'block'
	                });
	                if($(window).width()>=1024){
	                	$("#centro").css({
	                	'margin-left':'230px'
		                });
	                }
				}
			 });*/

			 $(".user-profile.dropdown-toggle").click(function(e) {
			  $( ".dropdown-usermenu" ).toggle();
			});

			 $(".tooltip").tooltip();
            
});


$(window).resize(function(){
	//checkWidthForToogle();
});

function checkWidthForToogle() {
	    var $window = $(window);
        var windowsize = $window.width();
        var controlWidth01 = 1024;

        if ( (windowsize >= controlWidth01) && ($('#izquierda').is(":visible")) ) {
           //$("#izquierda").removeAttr( "style" );
           //$("#centro").removeAttr( "style" );
           
            //$("#izquierda").css('top', '');
		
			$("#centro").css('margin-left','');
           
        }
        if (windowsize < controlWidth01) {
           $("#centro").removeAttr( "style" );
        }
}

(function($)
{
    $.fn.removeStyle = function(style)
    {
        var search = new RegExp(style + '[^;]+;?', 'g');

        return this.each(function()
        {
            $(this).attr('style', function(i, style)
            {
                return style.replace(search, '');
            });
        });
    };
}(jQuery));
//$('#element').removeStyle('display');