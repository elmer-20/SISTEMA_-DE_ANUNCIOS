<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
} else {
	header("Location: ../index.php");
}

include "../conexion.php";


$idAnuncio = $_GET['idAnuncio'];

// anuncios
$query = "SELECT * FROM anuncios
		WHERE idAnuncio = '$idAnuncio'";
$resultado = $con->query($query);

// categorías
$query2 = "SELECT * FROM categorias";
$resultado2 = $con->query($query2);

// usuarios
$query3 = "SELECT * FROM anuncios
			INNER JOIN usuarios
			ON anuncios.idUsuario = usuarios.idUsuario
			WHERE anuncios.idAnuncio = '$idAnuncio'";
$resultado3 = $con->query($query3);
$row3 = $resultado3->fetch_assoc();


 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<!-- Bootstrap CSS -->
  	<link rel="stylesheet" href="../css/bootstrap.min.css">
  
  	<style>
	.fakeimg {
	    height: 200px;
	    background: #aaa;
	    display: block;
	}
  	</style>

  	<title>MY BLOG</title>
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
				    <a class="nav-item nav-link active" href="anuncios/index.php">Anuncios <span class="sr-only">(current)</span></a>
			    </div>
			    <span class="navbar-text ml-auto">
			    	<span class="text-white mr-3"><?php echo $fullName ?></span>
			      	<a href="../cerrarSesion.php" class="btn btn-danger">Cerrar Sesión</a>
			    </span>
		  	</div>
		</div>
	</nav>


	<!-- main -->
	<div class="container" style="margin-top:30px">
	  <div class="row">
	  	<div class="col-sm-8">
	  		<?php 
	  		while ($row = $resultado->fetch_assoc()) {
	  		 ?>
				<h2><?php echo $row['titulo'] ?></h2>
			    <h5><?php echo $row['fecha'] ?></h5>
			    <div>
			    	<img src="../admin/anuncios/<?php echo $row['imagen'] ?>" style="width: 100%; height: 250px; border: 1px solid; padding: 2px" alt="OOps!" class="fakeimg">
			    </div>
			    <p class="text-justify mt-3"><?php echo $row['contenido'] ?></p>
			    <hr>
			    <a href="index.php" class="btn btn-primary mb-5">Volver</a>
		    <?php
	  		}
	  		 ?>
	    </div>
	    <div class="col-sm-4 mb-5">
	      	<h2>Sobre el Anunciante</h2>
	      	<p>Autor: <?php echo $row3['nombre'] . " " . $row3['apellido'] ?></p>
	      	<p>Contacto: <?php echo $row3['celular'] ?></p>
	      	<h3>Categorías</h3>
	      	<ul class="nav nav-pills flex-column">
	      		<?php 
	      		while ($row2 = $resultado2->fetch_assoc()) {
	      		 ?>
					<li><a href="categorias.php?idCategoria=<?php echo $row2['idCategoria'] ?>"><?php echo $row2['nombre'] ?></a></li>
	      		<?php
	      		}
	      		 ?>
	      	</ul>
	      	<hr class="d-sm-none">
	    </div>
	  </div>
	</div>

	<!-- footer -->
	<footer class="jumbotron jumbotron-fluid text-center bg-dark text-white mb-0">
	  	<div class="container">
	    	<h3>Todos los derechos reservados &copy; 2022 GRUPO 01</h3>
	  	</div>
	</footer>

  	<!-- Optional JavaScript -->
  	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
  	<script src="../js/jquery-3.3.1.min.js"></script>
  	<script src="../js/bootstrap.min.js"></script>
</body>
</html>
