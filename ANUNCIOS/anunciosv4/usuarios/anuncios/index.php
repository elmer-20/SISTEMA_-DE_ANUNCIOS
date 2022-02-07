<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
	$idUsuario = $_SESSION['idUsuario'];
} else {
	header("Location: ../../index.php");
}

include "../../conexion.php";

/* extraemos datos*/

$query0 = "SELECT * FROM anuncios WHERE idUsuario = '$idUsuario'";
$resultado0 = $con->query($query0);

$articulo_x_pagina = 3; // puedes cambiar esto
$total_articulos_db = $resultado0->num_rows;
$paginas = ceil($total_articulos_db / $articulo_x_pagina);

if ($resultado0->num_rows > 3) {
	if (!$_GET) {
	  header("Location: index.php?pagina=1");
	}
	      
	if ($_GET['pagina'] > $paginas || $_GET['pagina'] < 0) {
	  header("Location: index.php?pagina=1");
	}

	$iniciar = ($_GET['pagina'] - 1) * $articulo_x_pagina;

	/* anuncios */
	$query = "SELECT anuncios.idAnuncio AS idAnuncio,anuncios.titulo, anuncios.imagen, anuncios.fecha, usuarios.nombre AS name, usuarios.apellido, anuncios.contenido, categorias.nombre FROM anuncios
			INNER JOIN usuarios
			ON anuncios.idUsuario = usuarios.idUsuario
			INNER JOIN categorias
			ON anuncios.idCategoria = categorias.idCategoria 
			WHERE usuarios.idUsuario = '$idUsuario'
			ORDER BY anuncios.idAnuncio DESC
			LIMIT $iniciar, $articulo_x_pagina"; // número de post q mostraremos
	} else {
		$query = "SELECT anuncios.idAnuncio AS idAnuncio,anuncios.titulo, anuncios.imagen, anuncios.fecha, usuarios.nombre AS name, usuarios.apellido, anuncios.contenido, categorias.nombre FROM anuncios
				INNER JOIN usuarios
				ON anuncios.idUsuario = usuarios.idUsuario
				INNER JOIN categorias
				ON anuncios.idCategoria = categorias.idCategoria 
				WHERE usuarios.idUsuario = '$idUsuario'
				ORDER BY anuncios.idAnuncio DESC";
	}

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

  	<title>Usuario | Anuncios</title>
</head>
<body>
	
	<!-- navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="../index.php">Anuncios Puno</a>	
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
		
		<a href="agregar.php" class="btn btn-success mb-5">Agregar Nuevos Anuncios</a>
		<div class="table-responsive">
			<?php 
			if ($resultado->num_rows > 0) {
			 ?>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Título</th>
						<th>Fecha</th>
						<th>Autor</th>
						<th>Categoria</th>
						<th colspan="2" class="text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					while ($row = $resultado->fetch_assoc()) {
					 ?>
					<tr>
						<td><?php echo $row['titulo'] ?></td>
						<td><?php echo $row['fecha'] ?></td>
						<td><?php echo $row['name'] . " " . $row['apellido'] ?></td>
						<td><?php echo $row['nombre'] ?></td>
						<td><a href="editar.php?idAnuncio=<?php echo $row['idAnuncio'] ?>" class="btn btn-primary">Editar</a></td>
						<td><a href="eliminar.php?idAnuncio=<?php echo $row['idAnuncio'] ?>" class="btn btn-danger">Eliminar</a></td>
					</tr>
					<?php
					}
					 ?>
				</tbody>
			</table>
			<?php
			} else {
				echo "Agrege nuevos anuncios";
			}	
			 ?>
		</div>
	</div>
	
	<?php if ($resultado0->num_rows > 3): ?>
		<div class="container">
			<nav aria-label="Page navigation example">
	        <ul class="pagination">
	          <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="index.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
	          
	          <?php for ($i = 0; $i < $paginas; $i++) : ?>
	          <li class="page-item <?php echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>"><a class="page-link" href="index.php?pagina=<?php echo $i + 1 ?>"><?php echo $i + 1 ?></a></li>
	          <?php endfor ?>

	          <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="index.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
	        </ul>
	      	</nav>
		</div>
	<?php endif ?>
	
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
