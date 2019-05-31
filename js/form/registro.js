$(function () {

    // Documento caracteristica
    $("input.send-form-data").click(function () {
        $.post('php/contactform.php', $('#contactform').serialize(), function (response) {
        	if(response == "EXISTE"){
        		$("span.sms-title").text("Se encuentra registrado la Empresa");
        	}else if(response == "OK"){
        		$("span.sms-title").text("Se ha registrado con exito");
        		$("#nombre, #correo, #empresa, #mensaje").val("");
        	}
    	});
    });
    
});