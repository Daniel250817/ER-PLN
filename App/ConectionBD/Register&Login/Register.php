<?php
include __DIR__ . '/../db_connection.php';
session_start();

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['NombreUsuario'];
    $email = $_POST['Email'];
    $password = $_POST['Contra'];
    
    // Obtener la conexión a la base de datos
    $conn = getDbConnection();

    // Verificar si la conexión a la base de datos está establecida
    if (!$conn) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Verificar si el nombre de usuario o el email ya existen
    $sql = "SELECT * FROM Usuarios WHERE NombreUsuario='$username' OR Email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error_message = "El nombre de usuario o el email ya están en uso";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Usuarios (NombreUsuario, Email, Contra) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Registro exitoso";
            header("Location: login.php");
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Styles.css">
    <link rel="stylesheet" type="text/css" href="Login-Styles.css">
    <title>Registro</title>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h1>Regístrate</h1>
            <img src="../../Extras/Resource/Register-img.jpg" alt="Imagen de bienvenida" class="welcome-image">
        </div>
        <div class="form-container">
            <form method="post" action="register.php">
                <label for="NombreUsuario">Usuario:</label>
                <input type="text" id="NombreUsuario" name="NombreUsuario" required>
                <label for="Email">Correo electrónico:</label>
                <input type="email" id="Email" name="Email" required>
                <label for="Contra">Contraseña:</label>
                <input type="password" id="Contra" name="Contra" required>
                <button type="submit">Registrarse</button>
            </form>
            <p>¿Ya tienes una cuenta? <a class="link" href="login.php">Inicia sesión aquí</a></p>
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

    <!-- Modal Exito -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('successModal')">&times;</span>
            <div class="modal-header success">
                <span class="success-icon" style= "color:white;">&#10004;</span>
                <span>Éxito</span>
            </div>
            <p id="successMessage"><?php echo $success_message; ?></p>
        </div>
    </div>

    <script src="../../Extras/Modal.js"></script>
</body>
</html>