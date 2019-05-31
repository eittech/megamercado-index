$(function () {

    // Documento caracteristica
    $("input.send-form-data").click(function () {

    	var nombre = $("#nombre");
    	var correo = $("#correo");
    	var empresa = $("#empresa");
    	var mensaje = $("#mensaje");

    	if(nombre.val() == "" && correo.val() == "" && empresa.val() == "" && mensaje.val() == ""){
    		$("span.sms-title").text("Campo obligatorio");
    	}else{
	        $.post('php/contactform.php', $('#contactform').serialize(), function (response) {
	        	if(response == "EXISTE"){
	        		$("span.sms-title").text("Se encuentra registrado la Empresa");
	        	}else if(response == "OK"){
	        		$("span.sms-title").text("Se ha registrado con exito");
	        		$("#nombre, #correo, #empresa, #mensaje").val("");
	        	}
	    	});
    	}

    });
    
});