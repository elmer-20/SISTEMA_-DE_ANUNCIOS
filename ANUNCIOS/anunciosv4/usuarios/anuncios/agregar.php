<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
} else {
	header("Location: ../../index.php");
}

include "../../conexion.php";

// categorias
$query = "SELECT * FROM categorias";
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
		<form action="add.php" method="post" class="p-5 bg-light" enctype="multipart/form-data">
			<label for="titulo">Título:</label>
			<input type="text" class="form-control" placeholder="Título" name="titulo">
			<br>
			<label for="imagen">Imagen:</label>
			<input type="file" class="form-control" placeholder="Imagen" name="imagen">
			<br>
			<input type="hidden" value="<?php echo $_SESSION['idAutor'] ?>">
			<br>
			<label for="contenido">Contenido:</label>
			<textarea name="contenido" id="contenido" placeholder="Contenido" required class="form-control ckeditor" style="min-height: 100px; max-height: 300px"></textarea>
			<br>
			<label for="categoría">Categoría:</label>
			<select name="idCategoria" id="categoria" class="form-control">
				<?php
				while ($row = $resultado->fetch_assoc()) {
				 ?>
					<option value="<?php echo $row['idCategoria'] ?>"><?php echo $row['nombre'] ?></option>
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
  	<script src="../../admin/ckeditor/ckeditor.js"></script>
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
