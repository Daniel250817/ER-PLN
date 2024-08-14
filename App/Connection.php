<?php
$servername = "localhost";  // Cambia esto por el nombre de host o dirección IP de tu servidor MySQL en la nube.
$username = "root";
$password = "mysql250817";   
$dbname = "ER_PLN";
$port = 3306;  // Puerto del servidor MySQL (ajusta si es necesario)

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Realizar consulta para verificar datos
$sql = "SELECT * FROM Atributos";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["IdAtributos"]. " - Atributos: " . $row["Atributos"]. " - Entidades: " . $row["IdEntidades"]. "<br>";
    }
} else {
    echo "0 resultados";
}

// Cerrar conexión
$conn->close();
?>