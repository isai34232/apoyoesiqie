<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión y si es un alumnp
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'alumno') {
    header("Location: ../../logout.php");
    header("Location: ../../index.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="es" class="a">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <li><a href="examenMateria.php">Examen por materias</a></li>
                <li><a href="estadisticas.php">Estadísticas</a></li>
                <li><a href="material.php">Referencias</a></li>
            </ul>
        </nav>
        <div class="btn-wrapper">
            <a class="btn" href="perfil.php"><button>👨🏻</button></a>
            <a class="btn" href="../../logout.php"><button>Salir</button></a>
        </div>
    </header>



      <main class="content">
        <div class="contenedor">
            <br>
            <h2 class="perfil__datos">Mi perfil</h2>
            <div class="perfil__datos">
                <div class="iconoText">
                    <div class="datos__logo">
                        <span class="material-symbols-outlined"> person </span>
                    </div>      
                    <p><?php echo htmlspecialchars($_SESSION['user_name']); ?> <?php echo htmlspecialchars($_SESSION['user_lastname']); ?></p>            
                </div>
                <div class="iconoText">
                    <div class="datos__logo">
                        <span class="material-symbols-outlined"> contact_mail </span>
                    </div>   
                    <p><?php echo htmlspecialchars($_SESSION['user_email']); ?></p> 
                </div>
            </div>
            <div class="cambiarC">
                <h3 class="cambiarC__titulo">Cambiar Contraseña</h3>

                <form class="formulario" action="cambiarPassword_alumno.php" method="POST">
                    <div class="campo">
                        <label class="campo__label" for="password_a">Contraseña Actual</label>
                        <input 
                            class="campo__field"
                            type="password" 
                            placeholder="Tu nueva contraseña" 
                            id="password_a"
                            name="password_a" 
                        >
                    </div>

                    <div class="campo">
                        <label class="campo__label" for="password_n">Contraseña</label>
                        <input 
                            class="campo__field"
                            type="password" 
                            placeholder="Tu nueva contraseña" 
                            id="password_n"
                            name="password_n"
                        >
                    </div>
                    <div class="campo">
                        <label class="campo__label" for="password_c">Confirma Contraseña</label>
                        <input 
                            class="campo__field"
                            type="password"
                            placeholder=" " 
                            id="password_c"
                            name="password_c"
                        >
                    </div>
                
                    
                    <div class="cambiarC__boton">
                        <input type="submit" value="Enviar" class="botonPrincipal">
                    </div>
                    <br>
                    <br>
                </form>
            </div>
        </div>
      </main>
    </div>
    <!-- internos -->
    <script src="../../src/js/comprimir_expandir.js"></script>
    <!-- Iconos -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['error'])): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "<?php echo $_SESSION['error']; ?>"
                });
                <?php unset($_SESSION['error']); // Eliminar el mensaje después de mostrarlo ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: "<?php echo $_SESSION['success']; ?>"
                });
                <?php unset($_SESSION['success']); // Eliminar el mensaje después de mostrarlo ?>
            <?php endif; ?>
        });
    </script>
    <script src="../../src/js/menu.js"></script>
</body>
</html>