<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
} else {
	header("Location: ../../index.php");
}

// post

include "../../conexion.php";

$titulo = $_POST['titulo'];

// imagen
$nombreImagen = $_FILES['imagen']['name'];
$tamañoImagen = $_FILES['imagen']['size'];
$tipoImagen = $_FILES['imagen']['type'];
$ruta = $_FILES['imagen']['tmp_name'];
$destino = "imagenes/" . $nombreImagen;

// establecemos zona horaria
date_default_timezone_set ("America/Lima");
$fecha = date("Y-m-d h:i:s");
$idUsuario = $_SESSION['idUsuario'];
$contenido = $_POST['contenido'];
$idCategoria = $_POST['idCategoria'];

// confirmación si existe la imagen
$consulta = "SELECT * FROM anuncios WHERE imagen = '$destino'";
$miresultado = $con->query($consulta);
if ($miresultado->num_rows > 0) {
	$i = 1;
	$destino = "imagenes/" . $nombreImagen . "(" . $i . ")";
	$i++;
}

$query = "INSERT INTO anuncios (titulo, imagen, fecha, idUsuario, contenido, idCategoria) VALUES (
		'$titulo', '$destino', '$fecha', '$idUsuario', '$contenido', '$idCategoria')";

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<!-- Bootstrap CSS -->
  	<link rel="stylesheet" href="../../css/bootstrap.min.css">

  	<title>Admin | Agregar Anuncio</title>
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
				    <a class="nav-item nav-link active" href="index.php">Anuncios <span class="sr-only">(current)</span></a>
				    <a class="nav-item nav-link" href="../categorias/index.php">Categorías</a>
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
		<?php 
		if ($tipoImagen == 'image/jpeg' OR $tipoImagen == 'image/png' OR $tipoImagen == 'image/gif') {
			if ($resultado = $con->query($query)) {
				copy($ruta, $destino);
				echo "<p>Post Agregado</p>";
				echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
			} else {
				echo "<p>Error al agregar Post</p>";
				echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
			}
		} else {
			echo "<p>Suba una imagen por favor!</p>";
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