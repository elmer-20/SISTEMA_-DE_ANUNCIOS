<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
} else {
	header("Location: ../../index.php");
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

  	<title>Admin | Agregar Categoría</title>
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
				    <a class="nav-item nav-link active" href="../categorias/index.php">Categorías <span class="sr-only">(current)</span></a>
				    <a class="nav-item nav-link" href="../usuarios/index.php">Usuarios</a>
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
		<form action="addCategory.php" method="post" class="p-5 bg-light">
			<label for="correo">Nombre:</label>
			<input type="text" class="form-control" placeholder="Nombre" name="nombre">
			<br>
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
