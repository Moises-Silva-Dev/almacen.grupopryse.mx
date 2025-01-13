<?php 
//Hacemos la clase para la conexion con la base de datos
	class Conectar{
		public function conexion() {
			//nombre del servidor de la base de datos
			$servidor = "localhost"; 
			//nombre del usuario de la base de datos
			$usuario = "root";
			//contraseña de usuario de la base de datos 
			$password = ""; 
			//nombre de la base de datos
			$base = "grupova9_Pryse";  

			// Crear conexión
			$conexion = mysqli_connect($servidor, $usuario, $password, $base);

			//setencia para hacer la conexion con el servidor de la base de datos
			$conexion->set_charset('utf8mb4');

			//regresamos la respuesta
			return $conexion;
		}
	}
?>