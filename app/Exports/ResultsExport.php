<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ResultsExport
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function downloadQ23pf()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Define headers
    $headers = [
        'CUPS', 'Contador', 'Contrato', 'Periodo Tarifario', 
        'Fecha Inicio', 'Fecha Fin', 'Energia Activa Absoluta', 
        'Energia Activa Incremental', 'Bit Calidad Activa', 
        'Energia Reactiva Inductiva Absoluta', 'Energia Reactiva Inductiva Incremental', 
        'Bit Calidad Reactiva Inductiva', 'Energia Reactiva Capacitiva Absoluta', 
        'Energia Reactiva Capacitiva Incremental', 'Bit Calidad Reactiva Capacitiva', 
        'Excesos de Potencias', 'Bit Calidad Excesos', 'Maximetros', 
        'Fecha Maximetros', 'Bit Calidad Maximetros'
    ];

    // Set headers
    $sheet->fromArray($headers, null, 'A1');

    // Fill data
    $rowNum = 2;
    foreach ($this->results as $row) {
        $data = [];
        foreach ((array) $row as $value) {
            // Convert zeroes to string "0"
            $data[] = $value === 0 ? '0' : $value;
        }
        $sheet->fromArray($data, null, 'A' . $rowNum++);
    }

    $writer = new Xlsx($spreadsheet);
    
    // Output to browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="exportacion_excel.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}



public function downloadQ24pf()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Define headers
    $headers = [
        'CUPS', 'Contador', 'Fecha', 'Hora', 
        'Energía Activa Importada A+', 'Bit Calidad Activa A+', 
        'Energía Activa Exportada A-', 'Bit Calidad Activa A-',
        'Energía Reactiva Inductiva Importada Ri+', 'Bit Calidad Reactiva Importada Ri+',
        'Energía Reactiva Inductiva Exportada Ri-', 'Bit Calidad Reactiva Importada Ri-',
        'Energía Reactiva Capacitiva Importada Rc+', 'Bit Calidad Reactiva Importada Rc+',
        'Energía Reactiva Capacitiva Exportada Rc-', 'Bit Calidad Reactiva Exportada Rc-'
    ];

    // Set headers
    $sheet->fromArray($headers, null, 'A1');

    // Fill data
    $rowNum = 2;
    foreach ($this->results as $row) {
        $data = [];
        foreach ((array) $row as $value) {
            // Convert zeroes to string "0"
            $data[] = $value === 0 ? '0' : $value;
        }
        $sheet->fromArray($data, null, 'A' . $rowNum++);
    }

    $writer = new Xlsx($spreadsheet);
    
    // Output to browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="exportacion_excel.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}


    
public function downloadQ25pf()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Define headers
    $headers = [
        'CUPS', 'Contador', 'Fecha', 'Hora', 
        'Energía Activa Importada A+', 'Bit Calidad Activa A+', 
        'Energía Activa Exportada A-', 'Bit Calidad Activa A-',
        'Energía Reactiva Inductiva Importada Ri+', 'Bit Calidad Reactiva Importada Ri+',
        'Energía Reactiva Inductiva Exportada Ri-', 'Bit Calidad Reactiva Importada Ri-',
        'Energía Reactiva Capacitiva Importada Rc+', 'Bit Calidad Reactiva Importada Rc+',
        'Energía Reactiva Capacitiva Exportada Rc-', 'Bit Calidad Reactiva Exportada Rc-'
    ];

    // Set headers
    $sheet->fromArray($headers, null, 'A1');

    // Fill data
    $rowNum = 2;
    foreach ($this->results as $row) {
        $data = [];
        foreach ((array) $row as $value) {
            // Convert zeroes to string "0"
            $data[] = $value === 0 ? '0' : $value;
        }
        $sheet->fromArray($data, null, 'A' . $rowNum++);
    }

    $writer = new Xlsx($spreadsheet);
    
    // Output to browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="exportacion_excel.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}

}

