<?php
function getDbConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "mysql250817";
    $dbname = "ER_PLN";
    $port = 3306;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}
?>