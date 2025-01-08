    <?php
    // Inicia la sesión
    session_start();

    // Verifica si el usuario ha iniciado sesión y si es un administrador
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'administrador') {
        header("Location: ../../logout.php");
        header("Location: ../../index.php");
        exit();
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel Administrador</title>
        <!-- Externas -->
        <link rel="preload" href="https://db.onlinewebfonts.com/c/240a7cb10b49b02c94ceddc459d385a9?family=Gagalin-Regular" as="style">
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" crossorigin="anonymous" as="style">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/january-threed" rel="stylesheet">
        <!-- Linking Google Font Link For Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
                    

        <!-- internas -->
        <link rel="stylesheet" href="../../src/css/siderN.css">
        <link rel="stylesheet" href="../../src/css/ialumno.css">
        <link rel="stylesheet" href="../../src/css/normalize.css">

    </head>
    <body>
    
        <div class="container">
        
        <header class="header">
            <div class="logo">
                <a href="index.php">
                    <img src="../../src/img/IPN.png" alt="Logo de la marca"/>
                </a>
                <span class="title">Sistema de apoyo en matemáticas y física para estudiantes</span> <!-- Añadido el título -->
            </div>
            <nav>
                <div class="menu-toggle" onclick="toggleMenu()">Menú</div>
                <ul class="nav-links" id="nav-links">
                    <li><a href="preguntas.php">Editar preguntas</a></li>
                    <li><a href="material.php">Material de apoyo</a></li>
                </ul>
            </nav>
            <div class="btn-wrapper">
                <a class="btn" href="perfil.php"><button>👨🏻</button></a>
                <a class="btn" href="../../logout.php"><button>Salir</button></a>
            </div>
        </header>




        <main class="content">
            <div class="contenedor">
                <h2>Bienvenid@, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
                <p>Bienvenido al panel de administración para la pagina rumbo a la meta. Aquí puedes: </p>
                <ul class="lista">
                    <li class="iconoText">
                        - Modificar las preguntas y respuestas del los test por materia <span class="material material-symbols-outlined">list</span>
                    </li>
                    <li class="iconoText">
                        - Actualizar el material de apoyo de los estudiantes. <span class="material material-symbols-outlined">attach_file</span></li>
                </ul>
                <br>
            </div>
            <button class="boton--zoom" id="toggleButton"><span id="zoom" class=" material-symbols-outlined"> zoom_in_map </span></button>
        </main>
        </div>
        <!-- internos -->
        <script src="../../src/js/comprimir_expandir.js"></script>
        <!-- Iconos -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="../../src/js/menu.js"></script>
    </body>
    </html>