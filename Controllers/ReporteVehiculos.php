<?php
ini_set('memory_limit', '512M');
ini_set('max_execution_time', '600');
require('Libraries/fpdf/fpdf.php');
require('Controllers/Proyectos.php');
class CustomPDFVehiculos extends FPDF {
    private $inicio;
    private $fin;
    public function __construct($inicio = '', $fin = '') {
        parent::__construct('L', 'mm', 'Letter');
        $this->inicio = $inicio;
        $this->fin = $fin;
    }
    // Cabecera de página
    function Header() {
        // Logo
        $this->Image('Assets/img/logo_web.png', 10, 10, 30);
        // Título
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 10,  iconv('UTF-8', 'ISO-8859-1','Reporte de entrada y salida de vehiculos'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        // $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1','Lista de vigilantes asignados a la institución'), 0, 1, 'C');
        if(!empty($this->inicio)||!empty($this->fin)){
            $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1','Fecha de inicio: '.$this->inicio), 0, 1, 'C');
            $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1','Fecha de Fin: '.$this->fin), 0, 1, 'C');
        }
        else{
            $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1','Reporte de los ultimos 31 dias'), 0, 1, 'C');
            $this->Ln(10);
        }
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 220, 255);
        $this->Cell( 7, 8, 'N', 1, 0, 'C', true);
        $this->Cell(25, 8, 'Salida', 1, 0, 'C', true);
        $this->Cell(25, 8, 'Retorno', 1, 0, 'C', true);
        $this->Cell(23, 8, 'Tipo', 1, 0, 'C', true);
        $this->Cell(15, 8, 'Placa', 1, 0, 'C', true);
        $this->Cell(15, 8, 'Km Salida', 1, 0, 'C', true);
        $this->Cell(17, 8, 'Km Retorno', 1, 0, 'C', true);
        $this->Cell(34, 8, 'Conductor', 1, 0, 'C', true);
        $this->Cell(98, 8, 'Destino', 1, 1, 'C', true);

    }
    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->Line(10, $this->GetY(), 270, $this->GetY());
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        // Fecha
        $fecha = date('d/m/Y');
        $this->Cell(0, 10, $fecha, 0, 0, 'L');
        // Número de página
        $this->Cell(0, 10, 'Pg ' . $this->PageNo(), 0, 0, 'R');
    }
}
class ReporteVehiculos extends Controller{
    public function __construct(){
        session_start();              
        parent::__construct();
    }
    public function index(){       
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }
        $id_user= $_SESSION['id_usuario'];
        $verificar =$this->model ->verificarPermiso($id_user,'reporte vehiculos');
        if(!empty ($verificar)){
            $_SESSION['id_sucursal'] = $_POST['id_sucursal'];    
            $this->views->getView($this,"index"); 
            exit;
        }
        else{
            header('Location:'.base_url.'Inicio');
            exit;
        }
    }

    public function listar(){
        $id_sucursal= $_SESSION['id_sucursal'];
        $data= $this->model->getVehiculos($id_sucursal);    
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        
        die();
    }
    public function generarPDF() {
        ob_end_clean();
        $id_sucursal= $_SESSION['id_sucursal'];        
        $inicio= $_POST['inicio'];
        $fin= $_POST['fin'];
        if(empty($inicio)||empty($fin)){
            $data= $this->model->getVehiculos($id_sucursal);   
        }
        else{
            $data= $this->model->listarRango($id_sucursal,$inicio,$fin);     
        }  
        $pdf = new CustomPDFVehiculos($inicio,$fin);  
        $pdf->AddPage();
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 7);
        $fill = false; 
        $index=1;
        foreach($data as $row) {
            // Ajustar el tamaño del texto para cada celda
            $salida = $this->ajustarTexto($pdf, $row['salida'], 25);
            $retorno = $this->ajustarTexto($pdf, $row['retorno'], 25);
            $tipo = $this->ajustarTexto($pdf, $row['tipo'], 23);
            $placa = $this->ajustarTexto($pdf, $row['placa'], 15);
            $km_salida = $this->ajustarTexto($pdf, $row['km_salida'], 15);
            $km_retorno = $this->ajustarTexto($pdf, $row['km_retorno'], 17);
            $conductor = $this->ajustarTexto($pdf, $row['conductor'], 34);
            $destino = $row['destino'];
            $lng = $pdf->GetStringWidth($row['destino']) ;
            
            $col=0;
            if ($lng<= 98)$col=5;
            else if ($lng> 98  && $lng<= 196) $col=10; 
            else if ($lng> 196 && $lng<= 270) $col=15;
            else if ($lng> 270 && $lng<= 294) $col=20;
            else if ($lng> 294 && $lng<= 392) $col=25;
            else if ($lng> 392 && $lng<= 490) $col=30;

            $x = $pdf->GetX()-1;
            $y = $pdf->GetY()-5;

            if ($fill) {
                $pdf->SetFillColor(241, 249, 254);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            $pdf->Cell( 7, $col, $index, 1, 0, 'C', $fill);     
            $pdf->Cell(25, $col, $salida, 1, 0, 'C', $fill);
            $pdf->Cell(25, $col, $retorno, 1, 0, 'C', $fill);
            $pdf->Cell(23, $col, $tipo, 1, 0, 'C', $fill);
            $pdf->Cell(15, $col, $placa, 1, 0, 'C', $fill);
            $pdf->Cell(15, $col, $km_salida, 1, 0, 'C', $fill);
            $pdf->Cell(17, $col, $km_retorno, 1, 0, 'C', $fill);
            $pdf->Cell(34, $col, $conductor, 1, 0, 'C', $fill);

            $startX = $pdf->GetX()-1;
            $startY = $pdf->GetY()-5;
            $pdf->MultiCell(98, 5, $destino, 1, 'C', $fill);
            $endY = $pdf->GetY()-5;

            $pdf->SetXY($startX + 98, $startY);
            $pdf->SetY($endY);

            $index++;
            $fill = !$fill;
            $pdf->Ln();
        }
        $pdf->Output('I', 'reporte_de vehiculos.pdf');
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

    public function fechasReporte(){
        $id_sucursal= $_SESSION['id_sucursal'];
        $inicio= $_POST['inicio'];
        $fin= $_POST['fin'];
        $data= $this->model->listarRango($id_sucursal,$inicio,$fin);  
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();

    }
}
?>