$(document).ready(function(){

	$("#login-form").validate({
		rules: {
			contrasena: {
				required: true,
			},
			usuario: {
				required: true
				
			},
		},
		messages: {
			contrasena:{
			  required: "Por favor ingresa tu contraseña"
			 },
			usuario: {
			  required: "Por favor ingresa tu usuario"
			 },
		},
		submitHandler: submitForm	
	});	


	function submitForm() {		
		var data = $("#login-form").serialize();
		$.ajax({				
			type : 'POST',
			url  : 'indFunc.php?action=login',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Enviando ...');
			},
			success : function(response){			
				if($.trim(response) === "1"){
					console.log('dddd');									
					$("#login-submit").html('Ingresando ...');
					setTimeout(' window.location.href = "main.php"; ',2000);
				} else {									
					$("#error").fadeIn(1000, function(){						
						$("#error").html(response).show();
					});
				}
			}
		});
		return false;
	}

	function logout() {
		console.log('fdfdf');
		$.ajax({				
			type : 'POST',
			url  : 'indFunc.php?action=logout',
			data : data,
			success : function(response){
				window.location.href = "/index.php";
			}
		});
		return false;
	}   
});