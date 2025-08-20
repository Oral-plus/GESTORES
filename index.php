<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea gestores</title>
    <link rel="icon" type="image/x-icon" href="./imagenes/logosas.png">
    <link rel="stylesheet" href="custom.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.form').submit(function(e) {
                e.preventDefault();

                if ($('input[name="nombre_cliente"]').val() === '') {
                    alert("El código de cliente no es válido. Por favor, ingrese un código válido.");
                    return false;
                }

                var form = this;

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response); // Imprime la respuesta en la consola para depuración
                        if (response.success) {
                            alert(response.message); // Mensaje de éxito
                            form.reset();
                        } else {
                            alert(response.message); // Mensaje de error
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Ocurrió un error al enviar el registro");
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                    }
                });
            });

            $('input[name="codigo_cliente"]').on('input', function() {
                var codigoCliente = $(this).val();
                $.ajax({
                    url: 'buscar_cliente.php',
                    type: 'POST',
                    data: { codigo_cliente: codigoCliente },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.nombre_cliente) {
                            $('input[name="nombre_cliente"]').val(data.nombre_cliente);
                        } else {
                            $('input[name="nombre_cliente"]').val('');
                        }
                    }
                });
            });

            $('select[name="codigo"]').on('change', function() {
                var codigoGestor = $(this).val();
                $.ajax({
                    url: 'buscar_gestor.php',
                    type: 'POST',
                    data: { codigo_gestor: codigoGestor },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.nombre_gestor) {
                            $('input[name="asesor"]').val(data.nombre_gestor);
                        } else {
                            $('input[name="asesor"]').val('');
                        }
                    }
                });
            });
        });
    </script>
</head>
<body>
    <img src="./imagenes/logosas.png" alt="">
    <center>
        <form class="form" method="post" action="conexion.php">
            <p class="title">Tareas diarias gestores</p>
            <p class="message">Formulario para realizar antes de la visita al cliente.</p>
            <div class="flex">
                <label>
                    <input class="input3" type="date" name="Fecha" placeholder="" required="">
                </label>
            </div>
            <label>
                <select class="input" name="codigo" required="">
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
                        foreach ($cellIterator as $cell) {
                            $codigo = $cell->getValue();
                            break;
                        }
                        echo "<option value='$codigo'>$codigo</option>";
                    }
                    ?>
                </select>
            </label>
            <label>
                <input class="input" type="text" placeholder="Asesor" name="asesor" readonly>
            </label>
            <label>
                <input class="input" type="text" placeholder="Codigo cliente" name="codigo_cliente" required="">
            </label>
            <label>
                <input class="input" type="text" placeholder="Nombre cliente" name="nombre_cliente" readonly>
            </label>
            <label>
                <select name="estado" required="">
                    <option value="">Selecciona el estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Cliente 60">Cliente 60</option>
                    <option value="Perdido">Perdido</option>
                    <option value="Prospecto">Prospecto</option>
                </select>
            </label>
            <label>
                <select name="actividad" required="">
                    <option value="">Selecciona la actividad</option>
                    <option value="Tomar pedido">Tomar pedido</option>
                    <option value="Hacer inventario">Hacer inventario</option>
                    <option value="Presentación PAC comercial">Presentación PAC comercial</option>
                    <option value="Presentación Modelo HD">Presentación Modelo HD</option>
                    <option value="Presentación Modelo droguerías TAT">Presentación Modelo droguerías TAT</option>
                    <option value="Cliente nuevo">Cliente nuevo</option>
                    <option value="Realizar recaudo">Realizar recaudo</option>
                    <option value="Radicación de factura">Radicación de factura</option>
                </select>
            </label>
            <input class="submit" type="submit" value="Enviar">
        </form>
    </center>
</body>
</html>
