<?php
require 'vendor/autoload.php'; // Asegúrate de cargar el autoloader de Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['codigo_gestor'])) {
    $codigoGestor = $_POST['codigo_gestor'];

    // Nombre del archivo Excel con los códigos y nombres de gestores
    $nombreArchivoGestores = 'Gestores.xlsx';

    // Carga el archivo Excel
    $spreadsheet = IOFactory::load($nombreArchivoGestores);
    $hojaGestores = $spreadsheet->getActiveSheet();

    // Recorrer las filas en busca del código de gestor
    $nombreGestor = '';
    foreach ($hojaGestores->getRowIterator() as $fila) {
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
        if ($codigo == $codigoGestor) {
            $nombreGestor = $nombre;
            break;
        }
    }

    echo json_encode(['nombre_gestor' => $nombreGestor]);
}
?>
