<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="src/css/inicio.css">
    <link rel="stylesheet" href="src/css/normalize.css">
    <title>apoyoesiqie</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="registroA.php" method="POST">
                <h1>Crea tu cuenta</h1>
                <input type="text" name="firstName" placeholder="Nombre" required>
                <input type="text" name="lastName" placeholder="Apellidos" required>
                <input type="text" name="numeroEmpleado" placeholder="Boleta" required>
                <input type="email" name="correo" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button>Crear tu cuenta</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="login.php" method="POST" id="loginform">
                <h1>Inicia Sesión</h1>
                <input id="email" name="email" type="email" placeholder="Email">
                <input id="password" name="password" type="password" placeholder="Password">
                <a href="Recuperacion.php">¿Olvidaste la contraseña?</a>
                <button>Iniciar sesión</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>¡Bienvenido de nuevo!</h1>
                    <p>Ingresa tus datos personales para usar todas las funciones del sitio</p>
                    <button class="hidden" id="login">Iniciar sesión</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>¡Hola, estudiante!</h1>
                    <p>Regístrate con tus datos personales para usar todas las funciones del sitio</p>
                    <button class="hidden" id="register">Registrarse</button>
                </div>
            </div>
        </div>
        
    </div>

    <script src="src/js/script.js"></script>
    <script src="src/js/modernizr.js"></script>
</body>

</html>