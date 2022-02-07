<?php
session_start();

include "conexion.php";

$correo = mysqli_real_escape_string($con, $_POST['correo']);
$password = md5(mysqli_real_escape_string($con, $_POST['password']));

$query = "SELECT * FROM usuarios WHERE correo = '$correo' AND password = '$password'";
$resultado = $con->query($query);
$row = $resultado->fetch_assoc();

if ($resultado->num_rows > 0) {
	$_SESSION['idUsuario'] = $row['idUsuario'];
	$_SESSION['nombre'] = $row['nombre'];
	$_SESSION['apellido'] = $row['apellido'];
	if ($row['idTipoUsuario'] == 1) {
		header("Location: admin/anuncios/index.php");
	} elseif ($row['idTipoUsuario'] == 2) {
		header("Location: usuarios/anuncios/index.php");
	}
} else {
	header("Location: login.php");
}