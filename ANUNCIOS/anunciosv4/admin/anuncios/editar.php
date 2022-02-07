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

$query = "SELECT * FROM anuncios INNER JOIN categorias ON anuncios.idCategoria = categorias.idCategoria WHERE idAnuncio = '$idAnuncio'";
$resultado = $con->query($query);
$row = $resultado->fetch_assoc();

// categorias
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
		<form action="edit.php" method="post" class="p-5 bg-light" enctype="multipart/form-data">
			<input type="hidden" name="idAnuncio" value="<?php echo $row['idAnuncio'] ?>">
			<label for="titulo">Título:</label>
			<input type="text" class="form-control" value="<?php echo $row['titulo'] ?>" name="titulo">
			<br>
			<label for="imagen">Imagen:</label>
			<input type="hidden" name="imx" value="<?php echo $row['imagen'] ?>">
			<input type="file" name="imagen">
			<br>
			<input type="hidden" value="<?php echo $_SESSION['idAutor'] ?>">
			<br>
			<label for="contenido">Contenido:</label>
			<textarea name="contenido" id="contenido" required class="form-control ckeditor" style="min-height: 100px; max-height: 300px"><?php echo $row['contenido'] ?></textarea>
			<br>
			<label for="categoría">Categoría:</label>
			<p>* La categoría actual es: <?php echo $row['nombre'] ?></p>
			<select name="idCategoria" id="categoria" class="form-control">
				<?php
				while ($row2 = $resultado2->fetch_assoc()) {
				 ?>
					<option value="<?php echo $row2['idCategoria'] ?>"><?php echo $row2['nombre'] ?></option>
				<?php
				}
				 ?>
			</select>
			<p class="text-info">* Puedes agregar una nueva Categoría, si no encuentras la Categoría requerida</p>
			<br>
			<a href="index.php" class="btn btn-primary">Volver</a>
			<input type="submit" class="btn btn-primary" value="Editar">
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
  	<script src="../ckeditor/ckeditor.js"></script>
	<script>
        CKEDITOR.replace( 'contenido' );
        $("form").submit( function(e) {
            var messageLength = CKEDITOR.instances['contenido'].getData().replace(/<[^>]*>/gi, '').length;
            if( !messageLength ) {
                alert('Agrega contenido!');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
