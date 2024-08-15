<?php
function getDbConnection() {
    $servername = "localhost";
    $username = "root";
    // Obtener la contraseña desde la variable de entorno
    $password = getenv('ContraMysql');

    if ($password === false) {
        die('Error: La variable de entorno ContraMysql no está definida.');
    }

    $dbname = "ER_PLN";
    $port = 3306;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}
?>