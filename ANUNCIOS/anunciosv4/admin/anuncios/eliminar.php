<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
} else {
	header("Location: ../../index.php");
}


/* anuncios */

include "../../conexion.php";

$idAnuncio = $_GET['idAnuncio'];

$consulta = "SELECT * FROM anuncios WHERE idAnuncio = '$idAnuncio'";
$result = $con->query($consulta);

$query = "DELETE FROM anuncios WHERE idAnuncio = '$idAnuncio'";

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<!-- Bootstrap CSS -->
  	<link rel="stylesheet" href="../../css/bootstrap.min.css">

  	<title>Admin | Eliminar Anuncio</title>
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
		if ($resultado = $con->query($query)) {
			if ($row = $result->fetch_assoc()) {
				// remover una imagen de la carpeta
				unlink($row['imagen']);
				echo "<p class='text-success'>Anuncio Eliminado</p>";
				echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
			}
		} else {
			echo "<p class='text-danger'>Error al eliminar Anuncio</p>";
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