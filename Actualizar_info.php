<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
  <link rel="icon" type="image/x-icon" href="./imagenes/logosas.png">
  <style>
    /* Estilos para la tabla */
    .table-container {
      margin-top: 20px;
      overflow-x: auto;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      border: 1px solid #ddd;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #f2f2f2;
    }

    .boton {
      background-color: #4caf50;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px; 
    margin: 5px 5px;
    }

    .boton:hover {
      background-color: #45a049;
    }

    /* Estilos para el select */
    select {
      border: none;
      background-color: transparent;
      font-size: 16px;
      padding: 8px;
      width: 100%;
      box-sizing: border-box;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
    }

    select:focus {
      outline: none;
    }

    /* Resto de estilos */
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .titulo {
      display: block;
      margin-bottom: 10px;
      font-size: 18px;
      color: #333;
    }

    .form-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      justify-content: center; /* Centra los divs horizontalmente */
    }

    .form-container div {
      display: flex;
      align-items: center; /* Centra verticalmente los elementos */
    }

    .form-container label {
      padding-right: 10px;
      width: 120px; /* Ancho fijo para los labels */
      text-align: right; /* Alinea los labels a la derecha */
    }

    .form-container input {
      width: 50%; /* Ocupa el 50% del ancho del contenedor */
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .form-container select {
      width: 50%; /* Ocupa el 50% del ancho del contenedor */
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .boton-div {
      display: flex;
      justify-content: flex-end; /* Alinea el contenido al final */
      align-items: center; /* Centra verticalmente el botón */
    }

    .logo-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo-container img {
      max-width: 100%;
      height: auto;
    }

    .contenedor2 {
      float: right;
      margin-top: 30px;
    }

    .table-container {
      overflow-x: auto;
      max-width: 100%; /* Establece el ancho máximo */
      margin-top: 20px;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center; /* Centra horizontalmente los elementos */
      margin-top: 30px;
    }

    .scrollable-table {
      max-height: 500px; /* Altura máxima */
      overflow-y: auto; /* Agrega una barra de desplazamiento vertical si es necesario */
      margin-top: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table {
      border-collapse: collapse;
      width: 100%;
      border: 1px solid #ddd;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
</head>
<body>

<div class="logo-container">
  <img src="./imagenes/logosas.png" alt="logo">
</div>

<script>
function actualizarTodo() {
    var filas = document.getElementById("tablaDatos").rows;
    var datosActualizados = [];

    // Recorrer todas las filas
    for (var i = 1; i < filas.length; i++) { // Empezar desde 1 para omitir la fila de encabezados
        var fila = filas[i];
        var id = fila.cells[0].innerText; // Obtener el ID de la fila
        var estado = fila.cells[6].querySelector("select").value; // Obtener el estado seleccionado
        var actividad = fila.cells[7].querySelector("select").value; // Obtener la actividad seleccionada
        var observacion = fila.cells[8].querySelector("select").value; // Obtener la observación seleccionada
        var filtro = fila.cells[9].querySelector("select").value; // Obtener el filtro seleccionado

        // Comparar con el valor original
        var estadoOriginal = fila.cells[6].getAttribute('data-original');
        var actividadOriginal = fila.cells[7].getAttribute('data-original');
        var observacionOriginal = fila.cells[8].getAttribute('data-original');
        var filtroOriginal = fila.cells[9].getAttribute('data-original');

        if (estado !== estadoOriginal || actividad !== actividadOriginal || observacion !== observacionOriginal || filtro !== filtroOriginal) {
            datosActualizados.push({ id: id, estado: estado, actividad: actividad, observacion: observacion, filtro: filtro });
        }
    }

    if (datosActualizados.length === 0) {
        alert("No hay cambios para guardar.");
        return;
    }

    // Crear un objeto XMLHttpRequest
    var xhttp = new XMLHttpRequest();

    // Definir la función de retorno de llamada cuando se complete la solicitud
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                try {
                    var response = JSON.parse(this.responseText);
                    if (response.status === "success") {
                        alert("Datos actualizados correctamente");
                    } else {
                        alert("Error al actualizar datos: " + response.message);
                    }
                } catch (e) {
                    alert("Error en el formato de la respuesta del servidor");
                }
            } else {
                alert("Error de red: " + this.statusText);
            }
        }
    };

    // Configurar la solicitud AJAX
    xhttp.open("POST", "actualizar_datos.php", true);
    xhttp.setRequestHeader("Content-type", "application/json");

    // Enviar los datos actualizados al servidor
    xhttp.send(JSON.stringify(datosActualizados));
}

// Función para agregar listas desplegables a las celdas de las columnas ESTADO, ACTIVIDAD, OBSERVACION y FILTRO
function agregarListasDesplegables() {
    var filas = document.querySelectorAll("#tablaDatos tbody tr");

    filas.forEach(function(fila) {
        var celdaEstado = fila.cells[6];
        var estadoActual = celdaEstado.innerText;
        celdaEstado.setAttribute('data-original', estadoActual); // Almacenar valor original
        celdaEstado.innerHTML = `
            <select>
                <option value="Activo" ${estadoActual === "Activo" ? "selected" : ""}>Activo</option>
                <option value="Cliente 60" ${estadoActual === "Cliente 60" ? "selected" : ""}>Cliente 60</option>
                <option value="Perdido" ${estadoActual === "Perdido" ? "selected" : ""}>Perdido</option>
                <option value="Prospecto" ${estadoActual === "Prospecto" ? "selected" : ""}>Prospecto</option>
                <option value="" ${estadoActual === "" ? "selected" : ""}></option>
            </select>
        `;
        
        var celdaActividad = fila.cells[7];
        var actividadActual = celdaActividad.innerText;
        celdaActividad.setAttribute('data-original', actividadActual); // Almacenar valor original
        celdaActividad.innerHTML = `
            <select>
                
                <option value="Cliente nuevo" ${actividadActual === "Cliente nuevo" ? "selected" : ""}>Cliente nuevo</option>
                <option value="Hacer inventario" ${actividadActual === "Hacer inventario" ? "selected" : ""}>Hacer inventario</option>
                <option value="Ninguna Actividad" ${actividadActual === "Ninguna Actividad" ? "selected" : ""}>Ninguna Actividad</option>
                <option value="Presentacion Modelo droguerias TAT" ${actividadActual === "Presentacion Modelo droguerias TAT" ? "selected" : ""}>Presentación Modelo droguerías TAT</option>
                <option value="Presentacion Modelo HD" ${actividadActual === "Presentacion Modelo HD" ? "selected" : ""}>Presentacion Modelo HD</option>
                <option value="Presentacion PAC comercial" ${actividadActual === "Presentacion PAC comercial" ? "selected" : ""}>Presentacion PAC comercial</option>
                <option value="Promocion obsequio" ${actividadActual === "Promocion obsequio" ? "selected" : ""}>Promoción obsequio</option>
                <option value="Realizar recaudo" ${actividadActual === "Realizar recaudo" ? "selected" : ""}>Realizar recaudo</option>
                <option value="Tomar pedido" ${actividadActual === "Tomar pedido" ? "selected" : ""}>Tomar pedido</option>
                <option value="" ${actividadActual === "" ? "selected" : ""}></option>
            </select>
        `;
        
        var celdaObservacion = fila.cells[8];
        var observacionActual = celdaObservacion.innerText;
        celdaObservacion.setAttribute('data-original', observacionActual); // Almacenar valor original
        celdaObservacion.innerHTML = `
            <select>
                <option value="Estado mal asignado" ${observacionActual === "Estado mal asignado" ? "selected" : ""}>Estado mal asignado</option>
                <option value="Cliente faltante en programacion" ${observacionActual === "Cliente faltante en programacion" ? "selected" : ""}>Cliente faltante en programacion</option>
                <option value="Actividad a desarrollar no acorde al estado" ${observacionActual === "Actividad a desarrollar no acorde al estado" ? "selected" : ""}>Actividad a desarrollar no acorde al estado</option>
                <option value="Cliente mal programado" ${observacionActual === "Cliente mal programado" ? "selected" : ""}>Cliente mal programado</option>
                <option value="" ${observacionActual === "" ? "selected" : ""}></option>
            </select>
        `;
        
        var celdaFiltro = fila.cells[9];
        var filtroActual = celdaFiltro.innerText;
        celdaFiltro.setAttribute('data-original', filtroActual); // Almacenar valor original
        celdaFiltro.innerHTML = `
           <select>
                <option value="COACH" ${filtroActual === "COACH" ? "selected" : ""}>COACH</option>
                <option value="JEFE DE VENTAS" ${filtroActual === "JEFE DE VENTAS" ? "selected" : ""}>JEFE DE VENTAS</option>
                <option value="KAM" ${filtroActual === "KAM" ? "selected" : ""}>KAM</option>
                <option value="" ${filtroActual === "" ? "selected" : ""}></option>
            </select>
        `;
    });
}

// Llamar a la función para agregar listas desplegables después de que la tabla se haya cargado
document.addEventListener("DOMContentLoaded", function() {
    agregarListasDesplegables();
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Incluir Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<form method="post">
  <div class="form-container">
    <div>
        <label for="">Codigo del Asesor</label>
        <select class="input" name="codigo_gestor" id="codigo_gestor">
        <option value="">Selecciona el Código</option>
        <?php
        require 'vendor/autoload.php';
        use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;

        $nombreArchivoGestores = 'Gestores.xlsx';
        $spreadsheetGestores = SpreadsheetIOFactory::load($nombreArchivoGestores);
        $hojaGestores = $spreadsheetGestores->getActiveSheet();

        foreach ($hojaGestores->getRowIterator(2) as $fila) {
            $cellIterator = $fila->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $codigo = '';
            $nombre = '';
            $colIndex = 0;

            foreach ($cellIterator as $cell) {
                if ($colIndex == 0) {
                    $codigo = $cell->getValue();
                } elseif ($colIndex == 1) {
                    $nombre = $cell->getValue();
                }
                $colIndex++;
            }

            echo "<option value='$codigo'>$codigo - $nombre</option>";
        }
        ?>
    </select>


<script>
    $(document).ready(function() {
        $('#codigo_gestor').select2({
            placeholder: "Selecciona el Código",
            allowClear: true
        });
    });
</script>

    </div>
    <div>
      <label class="titulo" for="AREA">Ingresa el codigo:</label>
      <input type="text" name="cliente">
    </div>
    <div>
      <label class="titulo" for="INICIO">Fecha de inicio:</label>
      <input type="date" name="fechaInicio">
    </div>
    <div>
      <label class="titulo" for="FINAL">Fecha final:</label>
      <input type="date" name="fechaFin">
    </div>
  </div>
  <br><br>
  <div class="boton-div">
    <button class="boton" type="submit">BUSCAR</button>
  </div>
</form>

<br>
<br>

<form method="post">
  <div class="boton-div">
    <button class="boton" type="button" onclick="actualizarTodo()">Guardar Cambios</button>
    <button class="boton" type="button" onclick="exportarExcel()">Exportar a Excel</button>
  </div>

  <script>
function exportarExcel() {
    var table = document.getElementById("tablaDatos");
    var wb = XLSX.utils.book_new();
    var ws_data = [];
    var rows = table.querySelectorAll("tr");

    // Recorrer todas las filas
    rows.forEach(function(row, rowIndex) {
        var rowData = [];
        var cells = row.querySelectorAll("th, td");

        cells.forEach(function(cell, cellIndex) {
            var cellData = cell.innerText;

            // Verificar si la celda contiene un select
            var select = cell.querySelector("select");
            if (select) {
                cellData = select.value; // Obtener el valor seleccionado
            }
            rowData.push(cellData);
        });

        ws_data.push(rowData);
    });

    var ws = XLSX.utils.aoa_to_sheet(ws_data);
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
    XLSX.writeFile(wb, "TablaDatos.xlsx");
}
</script>

</form>

<div class="table-container">
  <div class="scrollable-table">
    <table id="tablaDatos">
      <thead>
        <tr>
          <th>ID</th>
          <th>FECHA</th>
          <th>CODIGO</th>
          <th>ASESOR</th>
          <th>CODIGO DEL CLIENTE</th>
          <th>NOMBRE DEL CLIENTE</th>
          <th>ESTADO</th>
          <th>ACTIVIDAD</th>
          <th>OBSERVACION</th>
          <th>FILTRO</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Configurar la conexión a la base de datos MySQL
        $servername = "193.203.166.183";
        $database = "u531422485_VENDEODRES";
        $username = "u531422485_VENDEODRES";
        $password = "Medellin*2024";
        
        // Crear conexión
        $conn = mysqli_connect($servername, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
          die("Conexión fallida: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $codigo_gestor = $_POST['codigo_gestor'];
          $cliente = $_POST['cliente'];
          $fechaInicio = $_POST['fechaInicio'];
          $fechaFin = $_POST['fechaFin'];

          // Consulta SQL
          $sql = "SELECT ID, FECHA, CODIGO, ASESOR, CODIGO_CLIENTE, NOMBRE, ESTADO, ACTIVIDAD, OBSERVACION, FILTRO FROM GESTORES WHERE 1=1";

          if (!empty($codigo_gestor)) {
            $sql .= " AND CODIGO = '$codigo_gestor'";
          }

          if (!empty($cliente)) {
            $sql .= " AND CODIGO_CLIENTE = '$cliente'";
          }

          if (!empty($fechaInicio) && !empty($fechaFin)) {
            $sql .= " AND FECHA BETWEEN '$fechaInicio' AND '$fechaFin'";
          }

          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["ID"] . "</td>";
              echo "<td contenteditable='true'>" . $row["FECHA"] . "</td>";
              echo "<td contenteditable='true'>" . $row["CODIGO"] . "</td>";
              echo "<td contenteditable='true'>" . $row["ASESOR"] . "</td>";
              echo "<td contenteditable='true'>" . $row["CODIGO_CLIENTE"] . "</td>";
              echo "<td contenteditable='true'>" . $row["NOMBRE"] . "</td>";
              echo "<td>" . $row["ESTADO"] . "</td>";
              echo "<td>" . $row["ACTIVIDAD"] . "</td>";
              echo "<td>" . $row["OBSERVACION"] . "</td>";
              echo "<td>" . $row["FILTRO"] . "</td>";
              echo "</tr>";
            }
          } else {
            echo "0 resultados";
          }
        }

        // Cerrar la conexión
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</div>

<div id="mensaje"></div>

</body>
</html>
