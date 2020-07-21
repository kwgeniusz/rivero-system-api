
(function(){
	
//funciona para submits de un formulario
	$('.form-prevent-multiple-submits').on('submit', function(){
		$('.button-prevent-multiple-submits').attr('disabled','true')
	})

//funciona para botones links
    $('.link-prevent-multiple-submits').on('click', function(){
		$('.link-prevent-multiple-submits').attr('disabled','true')
	})

})();

$(function() {
    // Set idle time
    $( document ).idleTimer( 7200000 );
});

$(function() {
    $( document ).on( "idle.idleTimer", function(event, elem, obj){
        window.location.href = "example.com/login"
    });  
});