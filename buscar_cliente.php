<?php
require 'vendor/autoload.php'; // Asegúrate de cargar el autoloader de Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['codigo_cliente'])) {
    $codigoCliente = $_POST['codigo_cliente'];

    // Nombre del archivo Excel con los códigos y nombres de clientes
    $nombreArchivoClientes = 'Clientes.xlsx';

    // Carga el archivo Excel
    $spreadsheet = IOFactory::load($nombreArchivoClientes);
    $hojaClientes = $spreadsheet->getActiveSheet();

    // Recorrer las filas en busca del código de cliente
    $nombreCliente = '';
    foreach ($hojaClientes->getRowIterator() as $fila) {
        $cellIterator = $fila->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); 
        $codigo = '';
        $nombre = '';
        foreach ($cellIterator as $cell) {
            if (!$codigo) {
                $codigo = $cell->getValue();
            } else {
                $nombre = $cell->getValue();
            }
        }
        if ($codigo == $codigoCliente) {
            $nombreCliente = $nombre;
            break;
        }
    }

    echo json_encode(['nombre_cliente' => $nombreCliente]);
}
?>
