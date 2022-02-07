<?php 

include "conexion.php";

/* extraemos datos*/

$query0 = "SELECT * FROM anuncios";
$resultado0 = $con->query($query0);

$articulo_x_pagina = 5; // puedes cambiar esto
$total_articulos_db = $resultado0->num_rows;
$paginas = ceil($total_articulos_db / $articulo_x_pagina);

if ($resultado0->num_rows > 5) {
	if (!$_GET) {
	  header("Location: index.php?pagina=1");
	}
	      
	if ($_GET['pagina'] > $paginas || $_GET['pagina'] < 0) {
	  header("Location: index.php?pagina=1");
	}

	$iniciar = ($_GET['pagina'] - 1) * $articulo_x_pagina;

	// anuncios
	$query = "SELECT * FROM anuncios 
				INNER JOIN usuarios
				ON anuncios.idUsuario = usuarios.idUsuario 
				ORDER BY idAnuncio DESC
				LIMIT $iniciar, $articulo_x_pagina";
	
} else {
	$query = "SELECT * FROM anuncios 
			INNER JOIN usuarios
			ON anuncios.idUsuario = usuarios.idUsuario 
			ORDER BY idAnuncio DESC";
}


$resultado = $con->query($query);

// categorías
$query2 = "SELECT * FROM categorias";
$resultado2 = $con->query($query2);


 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<!-- Bootstrap CSS -->
  	<link rel="stylesheet" href="css/bootstrap.min.css">
  
  	<style>
	.fakeimg {
	    height: 200px;
	    background: #aaa;
	    display: block;
	}
  	</style>

  	<title>Anuncios</title>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="index.php">Anuncios Puno</a>
		  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  	</button>
		  	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			    <div class="navbar-nav ml-auto">
			    	<a class="nav-item nav-link" href="registro.php">Registrarse</a>
				    <a class="nav-item nav-link" href="login.php">Ingresar</a>
				    <a class="nav-item nav-link" href="anunciar.php">Anunciar</a>
			    </div>
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
	  		 	<div class="row">
				<div class="col-md-4">
					<div>
						<img src="admin/anuncios/<?php echo $row['imagen'] ?>" alt="OOps!" class="img-fluid img-thumbnail" style="width: 100%; height: 200px">
					</div>
				</div>
				<div class="col-md-8">
					<h3><a href="anuncio.php?idAnuncio=<?php echo $row['idAnuncio'] ?>"><?php echo $row['titulo'] ?></a></h3>
					<h5><?php echo $row['fecha'] ?></h5>
					<p class="text-justify"><?php echo substr($row['contenido'], 0, 200) . ' (...)' ?></p>
					<p><a href="anuncio.php?idAnuncio=<?php echo $row['idAnuncio'] ?>">Más información</a></p>
				</div>
	  		 	</div>
			    <hr>
		    <?php
	  		}
	  		 ?>
	    </div>
	    <div class="col-sm-4 mb-5">
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
  	<script src="js/jquery-3.3.1.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
</body>
</html>
