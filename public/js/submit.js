
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
