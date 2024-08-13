<?php include 'Extras\Functions.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Diagram ER</title>
</head>
<body class="<?php echo $dark_mode ? 'dark-mode' : ''; ?>">
    

    <div class="header">
        <h1>Diagrama ER</h1>
        <div class="Toogle" onclick="window.location.href='?toggle_dark_mode=1'">
        <p>Dark Mode</p>
        <span class="material-symbols-outlined">dark_mode</span>
    </div>
    </div>
  
    <div class="Container-Left">
        <section class="Section-Left">
            <h2>Sección izquierda</h2>
        </section>
    </div>
    <div class="Container-Right">
        <section class="Section-Right">
            <h2>Sección derecha</h2>
        </section>
    </div> 
    <footer>
        <div class="Footer-Container">
            <h1>Este es el pie de página</h1>
        </div>   
    </footer> 
</body>
</html>