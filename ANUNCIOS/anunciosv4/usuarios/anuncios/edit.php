<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
} else {
	header("Location: ../../index.php");
}

/* anuncios */

include "../../conexion.php";

$idAnuncio = $_POST['idAnuncio'];
$titulo = $_POST['titulo'];

// imagen
$nombreImagen = $_FILES['imagen']['name'];
$tamañoImagen = $_FILES['imagen']['size'];
$tipoImagen = $_FILES['imagen']['type'];
$ruta = $_FILES['imagen']['tmp_name'];
$destino = "imagenes/" . $nombreImagen;
$imx = $_POST['imx'];

// establecemos zona horaria
date_default_timezone_set("America/Lima");
$fecha = date("Y-m-d h:m:s");
$idUsuario = $_SESSION['idUsuario'];
$contenido = $_POST['contenido'];

// confirmación si existe la imagen
$consulta = "SELECT * FROM anuncios WHERE imagen = '$destino'";
$miresultado = $con->query($consulta);
if ($miresultado->num_rows > 0) {
	$i = 1;
	$destino = "imagenes/" . $nombreImagen . "(" . $i . ")";
	$i++;
}

if ($nombreImagen != null) {
	$query = "UPDATE anuncios SET titulo = '$titulo', imagen = '$destino', fecha = '$fecha', idUsuario = '$idUsuario', contenido = '$contenido' WHERE idAnuncio = '$idAnuncio'";
} else {
	$query = "UPDATE anuncios SET titulo = '$titulo', fecha = '$fecha', idUsuario = '$idUsuario', contenido = '$contenido' WHERE idAnuncio = '$idAnuncio'";
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

  	<title>Admin | Editar Anuncio</title>
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
				unlink($imx); // to remove an image from a folder
				echo "<p class='text-info'>Post editado</p>";
				echo "<a class='btn btn-primary' href='index.php'>Volver</a>";
			} else {
				echo "<p class='text-info'>Error al editar Post</p>";
				echo "<a class='btn btn-primary' href='index.php'>Volver</a>";
			}
		} elseif($tipoImagen == "") {
			if ($resultado = $con->query($query)) {
				echo "<p class='text-info'>Post editado</p>";
				echo "<a class='btn btn-primary' href='index.php'>Volver</a>";
			} else {
				echo "<p class='text-info'>Error al editar Post</p>";
				echo "<a class='btn btn-primary' href='index.php'>Volver</a>";
			}
		} else {
			echo "Suba una imagen";
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