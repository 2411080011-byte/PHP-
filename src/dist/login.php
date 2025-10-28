<?php
require 'conexionPDO.php';

$error = "";
$success = "";

// --- PROCESAR REGISTRO ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $userExists = $stmt->fetch();

        if ($userExists) {
            $error = "Ocurrió un error al crear la cuenta. El nombre de usuario ya existe. Intenta con otro.";
        } else {
            // Crear nueva cuenta
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashedPassword])) {
                $success = "Cuenta creada, inicie sesión.";
            } else {
                $error = "Ocurrió un error al crear la cuenta. Inténtalo nuevamente.";
            }
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN-PLANTILLA</title>

    <link rel="stylesheet" href="styles.css">
    <style>
        .form-login .button-container input,
        .form-register .button-container input {
            transition: transform .23s linear;
        }

        .form-login .button-container input:hover,
        .form-register .button-container input:hover {
            letter-spacing: 0;
            transform: scale(1.05);
        }

        .left-container input,
        .right-container input {
            transition: transform .23s linear;
        }

        .left-container input:hover,
        .right-container input:hover {
            letter-spacing: 0;
            transform: scale(1.05);
        }

        .alert {
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .alert-error {
            background-color: #ffdddd;
            border: 1px solid #ff5c5c;
            color: #b00000;
        }

        .alert-success {
            background-color: #ddffdd;
            border: 1px solid #5cff5c;
            color: #006600;
        }
    </style>
</head>

<body>

    <div class="general-container" id="container">

        <!-- INTERFAZ LOGIN -->
        <div class="login-container">
            <form class="form-login" method="post" action="login_controlador.php">
                <h2>Iniciar Sesión</h2>

                <!-- Mostrar error o éxito del registro aquí también -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <div class="input-container">
                    <input type="text" placeholder="Nombre" name="username" required>
                    <input type="password" placeholder="Contraseña" name="password" required>
                </div>
                <!-- 
                <div class="link-container">
                    <a href="#"><p>¿Olvidaste tu contraseña?</p></a>
                </div> -->

                <div class="button-container">
                    <input type="submit" name="login" value="Iniciar Sesión">
                </div>

                <p>or use your account</p>
                <div class="option-container">
                    <a href="#"><img src="image-video/communication_15047435.png"></a>
                    <a href="#"><img src="image-video/google_13170545.png"></a>
                    <a href="#"><img src="image-video/linkedin_4782336.png"></a>
                </div>
            </form>
        </div>

        <!-- INTERFAZ REGISTRO -->
        <div class="register-container">
            <form class="form-register" method="post">
                <h2>Crear nueva cuenta</h2>

                <!-- Mostrar error o éxito del registro -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <div class="input-container">
                    <input type="text" placeholder="Nombre" name="username" required>
                    <input type="password" placeholder="Contraseña" name="password" required>
                </div>

                <div class="button-container">
                    <input type="submit" name="register" value="Registrarme">
                </div>

                <p>or use your account</p>
                <div class="option-container">
                    <a href="#"><img src="image-video/communication_15047435.png"></a>
                    <a href="#"><img src="image-video/google_13170545.png"></a>
                    <a href="#"><img src="image-video/linkedin_4782336.png"></a>
                </div>
            </form>
        </div>

        <div class="overlay">
            <div class="overlay-slider">
                <div class="sub-overlay"></div>
                <video src="image-video/33273-397122017_small.mp4" autoplay loop muted></video>

                <!-- Ventana REGISTER -->
                <div class="right-container" id="r">
                    <strong>Start your journey now</strong>
                    <p>If you don't have an account yet, join us and start your journey.</p>
                    <input type="submit" value="Register" id="button-right">
                </div>

                <!-- Ventana LOGIN -->
                <div class="left-container" id="l">
                    <strong>Hello friends</strong>
                    <p>If you already have an account login here and have fun.</p>
                    <input type="submit" value="Login" id="button-left">
                </div>
            </div>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>

</html>