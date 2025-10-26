<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN/REGISTER</title>
    <link rel="stylesheet" href="css/login_1.css">
</head>
<body>
<div class="container" id="container">	
	<div class="form-container sign-up-container">
		<form action="registrar.php" method="POST">
			<h1>Crear una cuenta</h1>
			<div class="social-container">
				<a href="#" class="social"><i src="assets/img/facebook.png"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>o utiliza tu correo electrónico para registrarte</span>
			<input type="text" placeholder="Nombre" name="username"/>
			<input type="password" placeholder="Contraseña" name="password"/>
			<button>Registrarme</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="login_controlador.php" method="POST">
			<h1>Iniciar sesión</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>o usa tu cuenta</span>
			<input type="text" placeholder="Nombre" name="username"/>
			<input type="password" placeholder="Contraseña" name="password"/>
			<a href="#">¿Olvidaste tu contraseña?</a>
			<button>INICIAR SESIÓN</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>¡Bienvenido de nuevo!</h1>
				<p>Para mantenerse conectado con nosotros, inicia sesión con su tu cuenta ya creada</p>
				<button class="ghost" id="signIn">Iniciar Sesión</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>¡Hola, amigo!</h1>
				<p>Introduce tus datos personales y comienza tu viaje con nosotros</p>
				<button class="ghost" id="signUp">Registrarme</button>
			</div>
		</div>
	</div>
</div>

<script src="js/login_2.0.js"></script>
</body>
</html>