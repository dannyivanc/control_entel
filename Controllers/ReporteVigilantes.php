<?php
require('Libraries/fpdf/fpdf.php');

class CustomPDF extends FPDF {
    // Cabecera de página
    function Header() {
        // Logo
        $this->Image('Assets/img/logo_web.png', 10, 10, 30);
        // Título
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 10, 'Reporte de Vigilantes', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Lista de vigilantes asignados a la institución', 0, 1, 'C');
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(9, 10, 'N', 1, 0, 'C', true);
        $this->Cell(75, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(28, 10, 'Carnet', 1, 0, 'C', true);
        $this->Cell(25, 10, 'Celular', 1, 0, 'C', true);
        $this->Cell(55, 10, 'Sucursal', 1, 1, 'C', true);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15); // Ajusta esta posición si es necesario
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Fecha
        $fecha = date('d/m/Y');
        $this->Cell(0, 10, $fecha, 0, 0, 'L');

        // Número de página
        $this->Cell(0, 10, 'Pg ' . $this->PageNo(), 0, 0, 'R');
    }
}

class ReporteVigilantes extends Controller{
    public function __construct(){
        session_start();              
        parent::__construct();
    }
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }
        $this->views->getView($this,"index");
    }

    public function listar(){
        $data= $this->model->getUsuarios();       
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generarPDF() {
        ob_end_clean();
        $data = $this->model->getUsuarios();   
        $pdf = new CustomPDF('P', 'mm', 'Letter');  

        $pdf->AddPage();
        
        // Logo de la empresa
        // $pdf->Image('Assets/img/logo_web.png', 10, 10, 30);
        
        // Título y descripción
        // $titulo = 'Reporte de Vigilantes';
        // $descripcion = "Lista de vigilantes asignados";
        // $pdf->SetFont('Arial', 'B', 18);
        // $pdf->Cell(0, 10, $titulo, 0, 1, 'C');
        // $pdf->SetFont('Arial', 'B', 14);
        // $pdf->Cell(0, 10, $descripcion, 0, 1, 'C');
        // $pdf->Cell(0, 10, '', 0, 1, 'C');
        // $pdf->SetFont('Arial', 'B', 12);
   
        // Encabezados de la tabla
        // $pdf->SetFont('Arial', 'B', 12);
        // $pdf->SetFillColor(81, 195, 247); 
        // $pdf->Cell(9, 10, 'N', 1, null,null, true); 
        // $pdf->Cell(75, 10, 'Nombre', 1, null,null, true); 
        // $pdf->Cell(28, 10, 'Carnet', 1, null,null, true); 
        // $pdf->Cell(25, 10, 'Celular', 1, null,null, true); 
        // $pdf->Cell(55, 10, 'Sucursal', 1, null,null, true);
        // $pdf->Ln();
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 12);
        $fill = false; 
        $index=1;
        foreach($data as $row) {
            // Ajustar el tamaño del texto para cada celda
            $nombre = $this->ajustarTexto($pdf, $row['nombre'], 75);
            $carnet = $this->ajustarTexto($pdf, $row['carnet'], 30);
            $cel = $this->ajustarTexto($pdf, $row['cel'], 30);
            $sucursal = $this->ajustarTexto($pdf, $row['nombre'], 57);

            //para color de las filas
            if ($fill) {
                $pdf->SetFillColor(241, 249, 254);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            $pdf->Cell(9, 10, $index, 1,null, null,  $fill);
            $pdf->Cell(75, 10, $nombre, 1,null, null,  $fill);
            $pdf->Cell(28, 10, $carnet, 1, null, null,  $fill);
            $pdf->Cell(25, 10, $cel, 1, null, null,  $fill);
            $pdf->Cell(55, 10, $sucursal, 1,null, null,  $fill);
            $index++;
            $fill = !$fill;
            $pdf->Ln();
        }
        // $pdf->Output('I', 'reporte_vigilantes.pdf');


        $pdf->Output('I', 'reporte_vigilantes.pdf');



        ob_end_clean();
        exit;
    }
    private function ajustarTexto($pdf, $texto, $anchoMaximo) {
        $textoAjustado = $texto;
        while ($pdf->GetStringWidth($textoAjustado) > $anchoMaximo - 2) {
            $textoAjustado = substr($textoAjustado, 0, -1);
        }
        return $textoAjustado;
    }
}
?>