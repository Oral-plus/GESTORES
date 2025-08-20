<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$servername = "193.203.166.183";
$database = "u531422485_VENDEODRES";
$username = "u531422485_VENDEODRES";
$password = "Medellin*2024";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . mysqli_connect_error()]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Fecha = mysqli_real_escape_string($conn, $_POST['Fecha']);
    $codigo = mysqli_real_escape_string($conn, $_POST['codigo']);
    $asesor = mysqli_real_escape_string($conn, $_POST['asesor']);
    $codigo_cliente = mysqli_real_escape_string($conn, $_POST['codigo_cliente']);
    $nombre_cliente = mysqli_real_escape_string($conn, $_POST['nombre_cliente']);
    $estado = mysqli_real_escape_string($conn, $_POST['estado']);
    $actividad = mysqli_real_escape_string($conn, $_POST['actividad']);

    $sql = "INSERT INTO GESTORES (FECHA, CODIGO, ASESOR, CODIGO_CLIENTE, NOMBRE, ESTADO, ACTIVIDAD) 
            VALUES ('$Fecha', '$codigo', '$asesor', '$codigo_cliente', '$nombre_cliente', '$estado', '$actividad')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la inserción: ' . mysqli_error($conn)]);
    }
    mysqli_close($conn);
    exit();
}
?>
