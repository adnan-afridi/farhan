
//Slide menu function
function menuSlide(){
	// if($(window).width() < 768){
	// 	$('.wrapper').addClass('menu-on');
	// }else{
	// 	$('.wrapper').removeClass('menu-on');
	// }
};
$('.navbar-minimalize').click(function(e){
		e.preventDefault();
		$('body').toggleClass('menu-active');
	});
menuSlide();
$(window).resize(function(){
	menuSlide();
});

$( function() {
    $( "#tabs" ).tabs();
  } );
