<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Si no hay sesión iniciada, redirigir al usuario a la página de login
    header("Location: /App/ConectionBD/Register&Login/Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

include __DIR__ . '/Extras/Functions.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/konva@8.3.5/konva.min.js"></script>
    <title>Diagram ER</title>
</head>
<body class="<?php echo $dark_mode ? 'dark-mode' : ''; ?>">
        <div class="header">
        <h1>Diagrama ER</h1>
        <div class="Toogle button-style" onclick="window.location.href='?toggle_dark_mode=1'">
            <p>Dark Mode</p>
            <span class="material-symbols-outlined">dark_mode</span>
        </div>
        <div class="logout">
            <a href="/App/ConectionBD/Register&Login/LogOut.php" class="logout-button button-style">Cerrar sesión</a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="Container-Left">
            <h2>Sección izquierda</h2>
            <section class="Section-Left">
                <div class="Titulo">
                    <h4>Entidades</h4>
                </div>
            </section>
            <section class="Section-Left">
                <div class="Titulo">
                    <h4>Atributos</h4>
                </div>
            </section>
        </div>
        <div class="Container-Right">
            <h2>Sección derecha</h2>
            <section class="Section-Right">
                <div id="canvas-container"></div>
            </section>
        </div> 
        <script>
            // Pasar el ID del usuario a JavaScript
            const userId = <?php echo json_encode($user_id); ?>;
        </script>
        <script src="Extras/Create-Tables.js"></script>
    </div>
    
    <footer>
        <div class="Footer-Container">
            <h2>Estudiantes</h2>
        </div>   
    </footer> 
</body>
</html>