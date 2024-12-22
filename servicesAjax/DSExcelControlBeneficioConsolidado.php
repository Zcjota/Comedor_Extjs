<?php
include('../lib/conex.php');
session_start();

$fechaini = $_REQUEST['fechaini'];
$fechafin = $_REQUEST['fechafin'];
$registro = $_SESSION['reg'];

$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

// Incluir autoload de Composer
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;


// Obtener el proveedor
$proveedor = "";
$sqlProveedor = 'SELECT nombre FROM proveedor WHERE activo=1 ORDER BY _id DESC LIMIT 1';
$rproveedor = mysqli_query($conex, $sqlProveedor);
if ($row = mysqli_fetch_array($rproveedor)) {
    $proveedor = $row['nombre'];
}

// Crear el objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configuración inicial
$spreadsheet->getDefaultStyle()->getFont()->setSize(12);
$sheet->mergeCells('A1:J1');
$sheet->mergeCells('A2:J2');
$sheet->mergeCells('A3:B3');
$sheet->mergeCells('E3:I3');

// Títulos y encabezados
$sheet->setCellValue('A1', 'DETALLE DE ALIMENTACION COMEDOR S.R.L');
$sheet->setCellValue('A2', 'DEL: ' . $fechaini . '         AL: ' . $fechafin);
$sheet->setCellValue('A3', 'PROVEEDOR: ' . $proveedor);
$sheet->setCellValue('E3', 'REGIONAL: SANTA CRUZ');

// Estilos
$sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2:J2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Encabezados de columnas
$sheet->setCellValue('A6', 'CODIGO');
$sheet->setCellValue('B6', 'COLABORADOR');
$sheet->setCellValue('C6', 'CARGO');
$sheet->setCellValue('D6', 'UNIDAD');
$sheet->setCellValue('E6', 'SUBCENTRO');
$sheet->setCellValue('F6', 'CENTRO');

// Estilo de bordes
$borders = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'],
        ],
    ],
];

// Consultar horarios y establecer encabezados
$sqlHorario = 'SELECT * FROM horario_comedor WHERE ACTIVO=1 ORDER BY HORARIO';
$rHorario = mysqli_query($conex, $sqlHorario);
$numHorario = 0;

while ($row = mysqli_fetch_array($rHorario)) {
    $columna = chr(71 + $numHorario); // G, H, I, ...
    $sheet->setCellValue($columna . '6', $row['DESCRIPCION']);
    $sheet->getStyle($columna . '6')->applyFromArray($borders);
    $sheet->getColumnDimension($columna)->setAutoSize(true);
    $numHorario++;
}

// Congelar panes
$sheet->freezePane('A7');

// Procesar registros
$records = json_decode(stripslashes($registro));
$vt = array_fill(1, 15, 0); // Inicializar totales
$i = 7;

if ($records != '') {
    foreach ($records as $record) {
        $codigo = $record->codigo;
        $nombre = $record->nombre;
        $cargo = $record->cargo;
        $unidad = $record->unidad;
        $subcentro = $record->subcentro;
        $centro = $record->centro;

        $sheet->setCellValue('A' . $i, $codigo)
              ->setCellValue('B' . $i, $nombre)
              ->setCellValue('C' . $i, $cargo)
              ->setCellValue('D' . $i, $unidad)
              ->setCellValue('E' . $i, $subcentro)
              ->setCellValue('F' . $i, $centro);

        // Llenar columnas dinámicas según horarios
        for ($j = 1; $j <= $numHorario; $j++) {
            $columna = chr(70 + $j); // G, H, I, ...
            $campo = "c$j";
            if (isset($record->$campo)) {
                $sheet->setCellValue($columna . $i, $record->$campo);
                $sheet->getStyle('A' . $i . ':' . $columna . $i)->applyFromArray($borders);
                $vt[$j] += $record->$campo; // Sumar al total
            }
        }
        $i++;
    }
}

// Agregar totales al final
$sheet->mergeCells("A$i:E$i");
$sheet->setCellValue('F' . $i, 'TOTAL');

for ($j = 1; $j <= $numHorario; $j++) {
    $columna = chr(70 + $j); // G, H, I, ...
    $sheet->setCellValue($columna . $i, $vt[$j]);
    $sheet->getStyle("A$i:$columna$i")->applyFromArray($borders);
}

// Configuración de página
$sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
$sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
$sheet->setTitle($fechaini . ' ' . $fechafin);

// Descargar archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ReporteBeneficio.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
