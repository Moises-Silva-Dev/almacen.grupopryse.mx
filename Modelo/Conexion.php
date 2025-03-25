<?php 
//Hacemos la clase para la conexion con la base de datos
	class Conectar{
		//nombre del servidor de la base de datos
		private $servidor = "localhost"; 
		//nombre del usuario de la base de datos
		private $usuario = "root";
		//contraseña de usuario de la base de datos 
		private $password = ""; 
		//nombre de la base de datos
		private $base = "grupova9_Pryse";

	/*
		//nombre del servidor de la base de datos
		private $servidor = "localhost"; 
		//nombre del usuario de la base de datos
		private $usuario = "grupova9_TecPryse";
		//contrase帽a de usuario de la base de datos 
		private $password = "M0ch1t*_619"; 
		//nombre de la base de datos
		private $base = "grupova9_Pryse";
	*/

		// Creamos la funcion para conectar 
		public function conexion() {
			// Crear conexión
			$conexion = new mysqli($this->servidor, $this->usuario, $this->password, $this->base);

			// Verificar errores de conexión
			if ($conexion->connect_error) {
				// Si hay un error, mostrar el mensaje
				throw new Exception("Error de conexión a la base de datos: " . $conexion->connect_error);
			}

			//setencia para hacer la conexion con el servidor de la base de datos
			$conexion->set_charset('utf8mb4');

			//regresamos la respuesta
			return $conexion;
		}
	}
?>