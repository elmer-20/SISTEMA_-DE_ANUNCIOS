<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
} else {
	header("Location: ../../index.php");
}

include "../../conexion.php";

$query = "SELECT * FROM tipoUsuarios";
$resultado = $con->query($query);


 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<!-- Bootstrap CSS -->
  	<link rel="stylesheet" href="../../css/bootstrap.min.css">

  	<title>Admin | Agregar Usuario</title>
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
				    <a class="nav-item nav-link" href="../categorias/index.php">Categorías</a>
				    <a class="nav-item nav-link active" href="../usuarios/index.php">Usuarios <span class="sr-only">(current)</span></a>
			    </div>
			    <span class="navbar-text ml-auto">
			    	<span class="text-white mr-3"><?php echo $fullName ?></span>
			      	<a href="../../cerrarSesion.php" class="btn btn-danger">Cerrar Sesión</a>
			    </span>
		  	</div>
		</div>
	</nav>

	<!-- main -->
	<div class="container my-5">
		<form action="add.php" method="post" class="p-5 bg-light">
			<label for="correo">Correo:</label>
			<input type="text" class="form-control" placeholder="Correo" name="correo">
			<br>
			<label for="password">Password:</label>
			<input type="password" class="form-control" placeholder="Password" name="password">
			<br>
			<label for="nombre">Nombre:</label>
			<input type="text" class="form-control" placeholder="Nombre" name="nombre">
			<br>
			<label for="apellido">Apellido:</label>
			<input type="text" class="form-control" placeholder="Apellido" name="apellido">
			<br>
			<label for="celular">Celular:</label>
			<input type="text" class="form-control" placeholder="Calular" name="celular">
			<br>
			<label for="idTipoUsuario">Tipo:</label>
			<select name="idTipoUsuario" id="" class="form-control">
				<?php 
				while ($row = $resultado->fetch_assoc()) {
				 ?>
					<option value="<?php echo $row['idTipoUsuario'] ?>"><?php echo $row['nombre'] ?></option>
				<?php
				}
				 ?>
			</select>
			<br>
			<a href="index.php" class="btn btn-primary">Volver</a>
			<input type="submit" class="btn btn-primary" value="Agregar">
		</form>
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
