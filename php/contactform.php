<?php

 // ++++++++++++++++++++++++++++++++++++
//error_reporting(0);

$conn = new mysqli("localhost", "root", "", "megamergado_registro");

if (mysqli_connect_errno()) {
die("No se puede conectar a la base de datos:" . mysqli_connect_error());
}else{

	// Correo principal
	$correo_it_to = "luis@ovalles.net";

	$nombre=$_POST['nombre'];
	$correo=$_POST['correo'];
	$empresa=$_POST['empresa'];
	$mensaje=$_POST['mensaje'];
	
	// Verificamos si existe el registro
	$check = mysqli_query("SELECT * FROM registro WHERE empresa='$empresa'");
	$num_rows = mysqli_num_rows($check);

	if (count($num_rows) == 0) {
		
		//Creamos la consulta de inserción.
		$query = "INSERT INTO `registro` (`nombre`, `correo`, `empresa`, `mensaje`) VALUES ('$nombre', '$correo', '$empresa', '$mensaje');";

		//Para ejecutar la consulta necesitamos escribir el siguiente código.
		$resultado = $conn->query($query);

		// Preparacion de la salida
		if($resultado){

			// Realizamos la excepcion para verificar errores  producidos en el envio
			try {
			    echo "OK";
			    send_email($nombre, $correo, $empresa, $mensaje, $correo_it_to);
			} catch (Exception $e) {
			    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			}
		}
	} else {
		echo "EXISTE";
	}
}

$conn->close();


// Funcion para el envio de email
function send_email($nombre, $correo, $empresa, $mensaje, $correo_it_to)
{
	 // configuration

	$error_message = "Por favor complete el formulario primero";

	  
	if(!isset($nombre) || !isset($correo) || !isset($empresa) || !isset($mensaje)) {
		echo $error_message;
	    die();
	}


	$empresa = stripslashes($empresa);
	$correo_from = $correo;

	$correo_message = "Mensaje enviado por '".stripslashes($nombre)."', correo:".$correo_from;
	$correo_message .=" en ".date("d/m/Y")."\n\n";
	$correo_message .= stripslashes($mensaje);
	$correo_message .="\n\n";

	// Always set content-type when sending HTML correo


	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8". "\r\n";
	$headers .= 'From: '.stripslashes($nombre);

	//$headers .= 'From: <'.$correo_from.'>' . "\r\n";

	mail($correo_it_to,$empresa,$correo_message,$headers);

}


?>
