<?php
require_once('Libraries/tcpdf/tcpdf.php');

// Extender TCPDF con funciones personalizadas
class MYPDF extends TCPDF {
    // Cargar datos de la tabla desde un arreglo
    public function LoadDataFromArray($data) {
        return $data;
    }

    // Tabla coloreada
    public function ColoredTable($header, $data) {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Encabezado
        $w = array(60, 40, 40);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Restauración de color y fuente
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row['nombre'], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row['carnet'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['cel'], 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $row['rol'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row['estado'], 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, $row['usuario'], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
?>