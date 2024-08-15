<?php
include __DIR__ . '/../db_connection.php';
session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['NombreUsuario'];
    $password = $_POST['Contra'];

    // Obtener la conexión a la base de datos
    $conn = getDbConnection();

    // Verificar si la conexión a la base de datos está establecida
    if (!$conn) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Usuarios WHERE NombreUsuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Contra'])) {
            // Guardar información del usuario en la sesión
            $_SESSION['user_id'] = $row['IdUsuario']; // Asumiendo que tienes un campo 'id' en tu tabla Usuarios
            $_SESSION['username'] = $row['NombreUsuario'];

            // Redirigir al usuario a la página principal
            header("Location: /App/Main.php");
            exit();
        } else {
            $error_message = "Contraseña incorrecta";
        }
    } else {
        $error_message = "Usuario no encontrado";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Login-Styles.css">
    <title>Inicio de sesión</title>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h1>Iniciar Sesión</h1>
            <img src="../../Extras/Resource/Login-img.jpg" alt="Imagen de bienvenida" class="welcome-image">
        </div>
        <div class="form-container">
            <h2>¡Coloca tus credenciales y comienza a diagramar!</h2>
            <form method="post" action="login.php">
                <label for="NombreUsuario">Usuario:</label>
                <input type="text" id="NombreUsuario" name="NombreUsuario" required>
                <label for="Contra">Contraseña:</label>
                <input type="password" id="Contra" name="Contra" required>
                <button type="submit">Iniciar sesión</button>
                <p>¿No tienes una cuenta? <a class="link" href="register.php">Registrate aquí</a></p>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('errorModal')">&times;</span>
            <div class="modal-header error">
                <span class="warning-icon">&#9888;</span>
                <span>Advertencia</span>
            </div>
            <p id="errorMessage"><?php echo $error_message; ?></p>
        </div>
    </div>

    <script src="../../Extras/Modal.js"></script>
</body>
</html>