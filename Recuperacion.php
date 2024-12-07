<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>poliXpert</title>
    <link rel="stylesheet" href="src/css/inicio.css">
    <link rel="stylesheet" href="src/css/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>
<body class="Contenido_Recuperacion">
   
        <?php if (isset($_GET['error'])): ?>
            <div class="alert-danger" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        <div class="container" id="container">
            <div class="form-container">
            <form action="recuperacionPassword2.php" method="POST" id="RecuperacionContra_form">
                <h1>poliXpert</h1>
                <p>Introduce tu correo electrónico y te enviaremos un enlace para que vuelvas a entrar en tu cuenta. </p>
                <input type="email" id="email" name="email" placeholder="📧 correo" required>
                <div class="botonesR">
                    <button type="submit" class="b2">Enviar</button>
                    <button type="button" class="b1" onclick="home()">Volver</button>

                </div>
            </form>
            </div>
        </div>

        

    <!-- Capa negra de fondo -->
    <div id="loading-wrapper" style = "display: none;">
        <div id="loading">
            <div class="loader"></div>
            <p>Enviando correo, por favor espera...</p>
        </div>
    </div>
    <script src="src/js/funciones.js"></script>

    <script src="src/js/modernizr.js"></script>
    <script>
        document.querySelector('#RecuperacionContra_form').addEventListener('submit', function() {
            document.getElementById('loading-wrapper').style.display = 'flex';
        });
    </script>
</body>
</html>
