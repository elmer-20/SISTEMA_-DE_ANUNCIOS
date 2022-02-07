<!DOCTYPE html>
<html lang="es">
<head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<!-- Bootstrap CSS -->
  	<link rel="stylesheet" href="css/bootstrap.min.css">

  	<title>Registro</title>
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
			    <div class="navbar-nav ml-auto">
					<a class="nav-item nav-link active" href="registro.php">Registrarse <span class="sr-only">(current)</span></a>
				    <a class="nav-item nav-link" href="login.php">Ingresar</a>
				    <a class="nav-item nav-link" href="anunciar.php">Anunciar</a>
			    </div>
		  	</div>
		</div>
	</nav>

	<!-- main -->
	<div class="container my-5">
		<h3>Registrarse</h3>
		<hr>
		<form action="register.php" method="post" class="p-5 bg-dark text-white">
			<label for="correo">Correo:</label>
			<input type="text" class="form-control" placeholder="Correo" name="correo">
			<br>
			<label for="password">Password:</label>
			<input type="password" class="form-control" placeholder="Password" name="password">
			<br>
			<label for="nombre">Nombre:</label>
			<input type="text" class="form-control" placeholder="Nombre" name="nombre">
			<br>
			<label for="apellido">Apellido:</label>
			<input type="text" class="form-control" placeholder="Apellido" name="apellido">
			<br>
			<label for="celular">Celular:</label>
			<input type="text" class="form-control" placeholder="Calular" name="celular">
			<br>
			<input type="reset" value="Cancelar" class="btn btn-primary">
			<input type="submit" class="btn btn-primary" value="Registrarse">
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
  	<script src="js/jquery-3.3.1.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
</body>
</html>
