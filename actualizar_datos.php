<?php
// Conectar a la base de datos
$servername = "193.203.166.183";
$database = "u531422485_VENDEODRES";
$username = "u531422485_VENDEODRES";
$password = "Medellin*2024";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos JSON de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

if (is_array($data)) {
    foreach ($data as $registro) {
        $id = $registro['id'];
        $estado = $registro['estado'];
        $actividad = $registro['actividad'];
        $observacion = $registro['observacion'];
        $filtro = $registro['filtro'];

        // Preparar la consulta SQL
        $sql = "UPDATE GESTORES SET ESTADO=?, ACTIVIDAD=?, OBSERVACION=?, FILTRO=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $estado, $actividad, $observacion, $filtro, $id);

        if (!$stmt->execute()) {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
            exit();
        }
    }
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Datos no válidos"]);
}

// Cerrar la conexión
$conn->close();
?>
