<?php
	require_once ("conectar_base.php");		// traigo el codigo de conexion
	$conexion = new conexion;				// instancio conexion

	$usuarioEnviado = $_POST['user'];		// Variable de usuario desde el form
	$passwordEnviado = $_POST['pass'];		// Variable de password desde el form

	// Conexion a db
	if(!mysqli_connect_error()) {
		// Consulta a la db
		$consulta  = "SELECT * FROM usuario WHERE nombre_usuario = '$usuarioEnviado' and pass_usuario = '$passwordEnviado'";
		$respuesta = mysqli_query($conexion->conectado,$consulta);	// Respues de la db con la conexion y la consulta

		if(mysqli_num_rows($respuesta) > 0) {
			while ($obj = mysqli_fetch_object($respuesta)) {
				$matriz = array("id" => $obj->id_usuario, "usuario" => utf8_encode($obj->nombre_usuario));
				session_start();
				$_SESSION["id"] = $obj->id_usuario;
			}
			$data = json_encode($matriz); 	// Pasa a JSON los datos
		} else {
			$data = json_encode(1); 		// En caso de no encontrar coincidencia
		}
	} else {
		$data = json_encode(2); 			// En caso de fallar la conexion
	}
	echo $data;								// Envio la data
?>