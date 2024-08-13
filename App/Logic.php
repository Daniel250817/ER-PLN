<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "homologacionGM100422";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

$numero = "Mi numero";

echo $numero . "<br>" . "<br>";

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa" . "<br>" . "<br>";
$sql = "SELECT * FROM alumnos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Procesar los datos obtenidos
    while ($row = $result->fetch_assoc()) {
        // Acceder a los valores de cada fila
        $column1 = $row["nombre"];
        $column2 = $row["tipo_documento"];
        $column3 = $row["nacionalidad"];
        // ... continuar con las demás columnas

        // Hacer algo con los valores obtenidos
        // Por ejemplo, imprimirlos en pantalla
        echo "Columna 1: " . $column1 . "<br>";
        echo "Columna 2: " . $column2 . "<br>";
        echo "Columna 3: " . $column3 . "<br>";
    }
} else {
    echo "No se encontraron resultados";
}
$conn->close();
?>

