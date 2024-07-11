<?php
require('Libraries/fpdf/fpdf.php');

class CustomPDFSupervisiones extends FPDF {
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
        $this->Cell(7, 10, 'N', 1, 0, 'C', true);
        $this->Cell(43, 10, 'Fecha/hora', 1, 0, 'C', true);
        $this->Cell(28, 10, 'Sucursal', 1, 0, 'C', true);
        $this->Cell(25, 10, 'Vigilante', 1, 0, 'C', true);
        $this->Cell(25, 10, 'Puntualidad', 1, 0, 'C', true);

        $this->Cell(20, 10, 'Pres_per', 1, 0, 'C', true);
        $this->Cell(17, 10, 'Patrulla', 1, 0, 'C', true);
        $this->Cell(10, 10, 'Epp', 1, 0, 'C', true);
        $this->Cell(22, 10, 'Verif_vehi', 1, 1, 'C', true);


    }
    // Pie de página
    function Footer() {
        $this->SetY(-15); // Ajusta esta posición si es necesario
        $this->Line(10, $this->GetY(), 270, $this->GetY());
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

class ReporteSupervisiones extends Controller{
    public function __construct(){
        session_start();              
        parent::__construct();
    }
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }
        $id_user= $_SESSION['id_usuario'];
        $verificar =    $this->model ->verificarPermiso($id_user,'reporte vigilantes');
        if(!empty ($verificar)){
            $this->views->getView($this,"index");
        }
        else{
            header('Location:'.base_url.'Errors');
        }
        // $this->views->getView($this,"index");
    }

    public function listar(){
        $id_institucion= $_SESSION['id_institucion'];
        $data= $this->model->getSupervisiones($id_institucion);       
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generarPDF() {
        ob_end_clean();
        $id_institucion= $_SESSION['id_institucion'];
        $data= $this->model->getSupervisiones($id_institucion);      
        $pdf = new CustomPDFSupervisiones('L', 'mm', 'Letter');  

        $pdf->AddPage();
       
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 12);
        $fill = false; 
        $index=1;
        foreach($data as $row) {
            // Ajustar el tamaño del texto para cada celda
            $fecha = $this->ajustarTexto($pdf, $row['fecha'], 43);
            $id_sucursal = $this->ajustarTexto($pdf, $row['id_sucursal'], 28);
            $id_vigilante = $this->ajustarTexto($pdf, $row['id_vigilante'], 25);
            $puntualidad = $this->ajustarTexto($pdf, $row['puntualidad'], 25);

            $pres_per = $this->ajustarTexto($pdf, $row['pres_per'], 25);
            $patrulla = $this->ajustarTexto($pdf, $row['patrulla'], 25);
            $epp = $this->ajustarTexto($pdf, $row['epp'], 25);
            $verif_vehi = $this->ajustarTexto($pdf, $row['verif_vehi'], 25);

            //para color de las filas
            if ($fill) {
                $pdf->SetFillColor(241, 249, 254);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            $pdf->Cell(7, 10, $index, 1,null, null,  $fill);
            $pdf->Cell(43, 10, $fecha, 1,null, null,  $fill);
            $pdf->Cell(28, 10, $id_sucursal, 1, null, null,  $fill);
            $pdf->Cell(25, 10, $id_vigilante, 1, null, null,  $fill);
            $pdf->Cell(25, 10, $puntualidad, 1,null, null,  $fill);

            $pdf->Cell(20, 10, $pres_per, 1,null, null,  $fill);
            $pdf->Cell(17, 10, $patrulla, 1, null, null,  $fill);
            $pdf->Cell(10, 10, $epp, 1, null, null,  $fill);
            $pdf->Cell(22, 10, $verif_vehi, 1,null, null,  $fill);
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

    public function pipipi(){
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }
}
?>