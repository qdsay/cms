// JavaScript Document
$().ready(function() {
    $(window).scroll( function() { 
        var scrollValue = $(window).scrollTop();
        scrollValue > 100 ? $("#scrollTop").fadeIn() : $("#scrollTop").fadeOut();
    } );    
    $('#scrollTop').click(function(){
        $("html,body").animate({scrollTop:0},200);  
    }); 
});
