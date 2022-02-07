<?php 

$servidor = "localhost";
$usuario = "root";
$password = "";
$db = "publicidad";

$con = new mysqli($servidor, $usuario, $password, $db);
mysqli_set_charset($con, "utf8");

if ($con->connect_error) {
	// echo "Error al conectar con la base de datos";
} else {
	// echo "Conexión exitosa";
}