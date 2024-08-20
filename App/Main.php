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
    <script src="Extras/Create-Tables.js" defer></script>
    <title>Diagram ER</title>
</head>
<body class="<?php echo isset($dark_mode) && $dark_mode ? 'dark-mode' : ''; ?>">
    <div class="header">
        <h1>Diagrama ER</h1>
        <div class="Toogle button-style" onclick="window.location.href='?toggle_dark_mode=1'">
            <p>Dark Mode</p>
            <span class="material-symbols-outlined">dark_mode</span>
        </div>
        <div class="logout">
            <a href="/App/ConectionBD/Register&Login/LogOut.php" class="logout-button button-style">Cerrar sesión</a>
        </div>
        <div>
        <select id="diagramas-combobox" class="combobox-style">
                <option value="">Seleccione un diagrama</option>
            </select>
            <script src="Extras/HistoryOP_Diagramas.js"></script>
        </div>
    </div>

    <div class="main-content">
        <div class="Container-Left">
            <textarea id="sql-input" placeholder="Escribe tu comando SQL para empezar a diagramar" rows="10"></textarea>
            <button id="generate-diagram">Generar Diagrama</button>
        </div>
        <div id="canvas-container">
            <canvas id="myCanvas"></canvas>
        </div>
    </div>
    
    <footer>
        <div class="Footer-Container">
            <p>Derechos reservados</p>
        </div>  
        <div class="Footer-copy">
            <p>Estudiantes / Autores</p>
            <p>Julio Daniel Guardado Martínez | Wilson Alexander Portillo Marroquín</p>
            <p>Manuel Alejandro Pérez Ramírez | Francisco Alexander Arbaiza Orellana</p>
        </div>
    </footer> 
</body>
</html>
