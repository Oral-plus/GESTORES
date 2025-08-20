<?php
require 'vendor/autoload.php';

// Verifica si se han enviado datos desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura los datos del formulario
    $Fecha = $_POST['Fecha'];
    $kam = $_POST['kam'];
    $coach = $_POST['coach'];
    $codigo = $_POST['codigo'];
    $ruta = $_POST['ruta'];
    $asesor = $_POST['asesor'];
    $codigo_cliente = $_POST['codigo_cliente'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $estado = $_POST['estado'];
    $actividad = $_POST['actividad'];




    // Nombre del archivo Excel
    $nombrearchivo = 'Formularioo.xlsx';

    // Carga el archivo Excel existente
    $documento = PHPExcel_IOFactory::load($nombrearchivo);

    // Obtiene la primera hoja del archivo Excel
    $hojaactual = $documento->getSheet(0);

    // Encuentra la próxima fila vacía para insertar los nuevos datos
    $nextRow = $hojaactual->getHighestDataRow() + 1;

    // Inserta los datos en las siguientes columnas de la próxima fila vacía
    $hojaactual->setCellValueByColumnAndRow(0, $nextRow, $Fecha);
    $hojaactual->setCellValueByColumnAndRow(1, $nextRow, $kam);
    $hojaactual->setCellValueByColumnAndRow(2, $nextRow, $coach);
    $hojaactual->setCellValueByColumnAndRow(3, $nextRow, $codigo);
    $hojaactual->setCellValueByColumnAndRow(4, $nextRow, $ruta);
    $hojaactual->setCellValueByColumnAndRow(5, $nextRow, $asesor);
    $hojaactual->setCellValueByColumnAndRow(6, $nextRow, $codigo_cliente);
    $hojaactual->setCellValueByColumnAndRow(7, $nextRow, $nombre_cliente);
    $hojaactual->setCellValueByColumnAndRow(8, $nextRow, $estado);
    $hojaactual->setCellValueByColumnAndRow(9, $nextRow, $actividad);

    // Guarda el archivo Excel
    $writer = PHPExcel_IOFactory::createWriter($documento, 'Excel2007');
    $writer->save($nombrearchivo);

    // Redirecciona a una página de éxito o muestra un mensaje de éxito
    header("Location: exito.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Gestores</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="custom.css">
</head>
<body>
<div class="formulario">
        <img src="./imagenes/logosas.png" alt="">
       
</div>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="FECHA">FECHA:</label>
        <br>

        <input class="fecha" type="date"  name="Fecha"><br><br>
        <label for="KAM">KAM:</label>
        <select name="kam">
            <option value="Diego Sosa">Diego Sosa</option>
            <option value="Sandra Rivas">Sandra Rivas</option>
            <option value="Ronald Arce">Ronald Arce</option>
        </select><br><br>

        <label for="COACH">COACH:</label>
        <select name="coach">
            <option value="Carlos Pico">Carlos Pico</option>
            <option value="Catalina Abril">Catalina Abril</option>
            <option value="Harold Carrasquilla">Harold Carrasquilla</option>
            <option value="Henry Rodriguez">Henry Rodriguez</option>
            <option value="Juan Cuervo">Juan Cuervo</option>
            <option value="Juan Olaya">Juan Olaya</option>
            <option value="Yeferson Lastra">Yeferson Lastra</option>
        </select><br><br>

        <label for="CODIGO">CODIGO:</label>
        <input type="text"  name="codigo"><br><br>

        
        <label for="RUTA">RUTA:</label>
        <input type="text"  name="ruta"><br><br>

        <label for="ASESOR">ASESOR:</label>
        <input type="text"  name="asesor"><br><br>

        <label for="CODIGO CLIENTE">CODIGO CLIENTE:</label>
        <input type="text"  name="codigo_cliente"><br><br>

        <label for="NOMBRE CLIENTE">NOMBRE CLIENTE:</label>
        <input type="text"  name="nombre_cliente"><br><br>

        <label for="ESTADO">ESTADO:</label>
        <select name="estado">
            <option value="Normal">Normal</option>
            <option value="Decreciente">Decreciente</option>
            <option value="Cliente 60">Cliente 60</option>
            <option value="Perdido">Perdido</option>
        </select><br><br>

        <label for="ACTIVIDAD">ACTIVIDAD:</label>
        <select name="actividad">
            <option value="Tomar pedido">Tomar pedido</option>
            <option value="Hacer inventario">Hacer inventario</option>
            <option value="Presentación PAC comercial">Presentación PAC comercial</option>
            <option value="Presentación Modelo HD">Presentación Modelo HD</option>
            <option value="Presentación Modelo droguerías TAT">Presentación Modelo droguerías TAT</option>
            <option value="Cliente nuevo">Cliente nuevo</option>
            <option value="Promoción obsequio">Promoción obsequio</option>
            <option value="Realizar recaudo">Realizar recaudo</option>
            
        </select><br><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>
