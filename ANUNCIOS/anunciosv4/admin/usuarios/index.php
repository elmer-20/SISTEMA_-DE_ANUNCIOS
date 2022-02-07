<?php 
session_start();

if (isset($_SESSION['idUsuario'])) {
	$fullName = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
} else {
	header("Location: ../../index.php");
}

/* posts */

include "../../conexion.php";

$query = "SELECT usuarios.idUsuario, usuarios.correo, usuarios.password, usuarios.nombre, usuarios.apellido, tipousuarios.nombre FROM usuarios
	INNER JOIN tipousuarios
	ON usuarios.idTipoUsuario = tipousuarios.idTipoUsuario";
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

  	<title>Admin | Usuarios</title>
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
		
		<a href="agregar.php" class="btn btn-success mb-5">Agregar Nuevo Usuario</a>
		<div class="table-responsive">
			<?php 
			if ($resultado->num_rows > 0) {
			 ?>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Correo</th>
						<th>Password</th>
						<th>Nombre</th>
						<th>Apellido</th>
						<th>Tipo</th>
						<th colspan="2" class="text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					while ($row = $resultado->fetch_assoc()) {
					 ?>
					<tr>
						<td><?php echo $row['correo'] ?></td>
						<td><?php echo $row['password'] ?></td>
						<td><?php echo $row['nombre'] ?></td>
						<td><?php echo $row['apellido'] ?></td>
						<td><?php echo $row['nombre'] ?></td>
						<td><a href="editar.php?idUsuario=<?php echo $row['idUsuario'] ?>" class="btn btn-primary">Editar</a></td>
						<td><a href="eliminar.php?idUsuario=<?php echo $row['idUsuario'] ?>" class="btn btn-danger">Eliminar</a></td>
					</tr>
					<?php
					}
					 ?>
				</tbody>
			</table>
			<?php
			} else {
				echo "Agrege nuevos autores";
			}	
			 ?>
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
  	<script src="../../js/jquery-3.3.1.min.js"></script>
  	<script src="../../js/bootstrap.min.js"></script>
</body>
</html>
