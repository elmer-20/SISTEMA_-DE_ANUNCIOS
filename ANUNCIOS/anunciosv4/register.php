<?php 

include "conexion.php";

$correo = mysqli_real_escape_string($con, $_POST['correo']);
$password = md5(mysqli_real_escape_string($con, $_POST['password']));
$nombre = mysqli_real_escape_string($con, $_POST['nombre']);
$apellido = mysqli_real_escape_string($con, $_POST['apellido']);
$celular = mysqli_real_escape_string($con, $_POST['celular']);
$idTipoUsuario = 2;


$query = "INSERT INTO usuarios (correo, password, nombre, apellido, celular, idTipoUsuario) VALUES ('$correo', '$password', '$nombre', '$apellido', '$celular', '$idTipoUsuario')";

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<!-- Bootstrap CSS -->
  	<link rel="stylesheet" href="css/bootstrap.min.css">

  	<title>Registro</title>
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
			    <div class="navbar-nav ml-auto">
					<a class="nav-item nav-link active" href="registro.php">Registrarse <span class="sr-only">(current)</span></a>
				    <a class="nav-item nav-link" href="login.php">Ingresar</a>
				    <a class="nav-item nav-link" href="anunciar.php">Anunciar</a>
			    </div>
		  	</div>
		</div>
	</nav>

	<!-- main -->
	<div class="container my-5">
		<?php 
		if ($resultado = $con->query($query)) {
			echo "<p class='text-success'>Registro exitoso</p>";
			echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
			echo " ";
			echo "<a href='login.php' class='btn btn-primary'>Ingresar</a>";
		} else {
			echo "<p class='text-danger'>Error al Registrarse</p>";
			echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
			echo " ";
			echo "<a href='login.php' class='btn btn-primary'>Ingresar</a>";
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
  	<script src="js/jquery-3.3.1.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
</body>
</html>
