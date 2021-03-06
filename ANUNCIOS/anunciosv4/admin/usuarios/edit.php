<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
} else {
	header("Location: ../../index.php");
}

/* posts */

include "../../conexion.php";

$idUsuario = mysqli_real_escape_string($con, $_POST['idUsuario']);
$correo = mysqli_real_escape_string($con, $_POST['correo']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$nombre = mysqli_real_escape_string($con, $_POST['nombre']);
$apellido = mysqli_real_escape_string($con, $_POST['apellido']);
$celular = mysqli_real_escape_string($con, $_POST['celular']);

$query = "SELECT * FROM usuarios WHERE idUsuario = '$idUsuario'";
$resultado = $con->query($query);
$row = $resultado->fetch_assoc();

if ($password == $row['password']) {
	$query2 = "UPDATE usuarios SET correo = '$correo', nombre = '$nombre', apellido = '$apellido', celular = '$celular' WHERE idUsuario = '$idUsuario'";
} else {
	$password = md5(mysqli_real_escape_string($con, $_POST['password']));
	$query2 = "UPDATE usuarios SET correo = '$correo', password = '$password', nombre = '$nombre', apellido = '$apellido', celular = '$celular' WHERE idUsuario = '$idUsuario'";
}

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<!-- Bootstrap CSS -->
  	<link rel="stylesheet" href="../../css/bootstrap.min.css">

  	<title>Admin | Editar Usuario</title>
</head>
<body>
	
	<!-- navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="index.php">Anuncios Puno</a>	
		  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  	</button>
		  	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			    <div class="navbar-nav">
				    <a class="nav-item nav-link" href="../anuncios/index.php">Anuncios</a>
				    <a class="nav-item nav-link" href="../categorias/index.php">Categor??as</a>
				    <a class="nav-item nav-link active" href="../usuarios/index.php">Usuarios <span class="sr-only">(current)</span></a>
			    </div>
			    <span class="navbar-text ml-auto">
			    	<span class="text-white mr-3"><?php echo $fullName ?></span>
			      	<a href="../../cerrarSesion.php" class="btn btn-danger">Cerrar Sesi??n</a>
			    </span>
		  	</div>
		</div>
	</nav>

	<!-- main -->
	<div class="container my-5">
		<?php 
		if ($resultado2 = $con->query($query2)) {
			echo "<p class='text-success'>Usuario Editado</p>";
			echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
		} else {
			echo "<p class='text-danger'>Error al editar Usuario</p>";
			echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
		}
		 ?>
	</div>

	
	<!-- footer -->
	<footer class="jumbotron jumbotron-fluid text-center bg-dark text-white mb-0">
	  	<div class="container">
	    	<h3>Todos los derechos reservados &copy; 2022 GRUPO 01</h3>
	  	</div>
	</footer>

  	<!-- Optional JavaScript -->
  	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
  	<script src="../../js/jquery-3.3.1.min.js"></script>
  	<script src="../../js/bootstrap.min.js"></script>
</body>
</html>