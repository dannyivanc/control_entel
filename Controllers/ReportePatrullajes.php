<?php
require('Libraries/fpdf/fpdf.php');
require('Controllers/Proyectos.php');
class CustomPDFSupervisiones extends FPDF {
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
        $this->Cell(0, 10,  iconv('UTF-8', 'ISO-8859-1','Reporte de Supervisiones'), 0, 1, 'C');
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
        $this->Cell(25, 8, 'Fecha', 1, 0, 'C', true);
        $this->Cell(55, 8, 'Sucursal', 1, 0, 'C', true);
        $this->Cell(55, 8, 'Supervisor', 1, 0, 'C', true);

        $this->Cell(32, 8, 'Ubicacion', 1, 0, 'C', true);
        $this->Cell(82, 8, 'Detalles', 1, 1, 'C', true);
     
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
class ReportePatrullajes extends Controller{
    public function __construct(){
        session_start();              
        parent::__construct();
    }
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }
        $id_user= $_SESSION['id_usuario'];
        $verificar =$this->model ->verificarPermiso($id_user,'reporte supervisiones');
        if(!empty ($verificar)){
            if($_SESSION['rol']=='cliente'){ 
                $this->views->getView($this,"index");
            }
            else{
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_institucion'])) {
                    $_SESSION['id_institucion'] = $_POST['id_institucion'];    
                    $this->views->getView($this,"index"); 
                } 
                else{                   
                    header("Location: ".base_url."Proyectos?view=ReportePatrullajes");
                }
            }
        }
        else{
            header('Location:'.base_url.'Errors');
        }
    }

    public function listar(){
        $id_institucion= $_SESSION['id_institucion'];
        $data= $this->model->getPatrullajes($id_institucion);       
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnUbicacion= '<button class="btn btn-success me-1" type="button" onClick="btnUbicacion('.$data[$i]['lat'].','.$data[$i]['lng'].')"> <i class="fas fa-location-dot"></i> </button>';
            $data[$i]['acciones'] =  $btnUbicacion;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generarPDF() {
        ob_end_clean();
        $id_institucion= $_SESSION['id_institucion'];        
        $inicio= $_POST['inicio'];
        $fin= $_POST['fin'];
        if(empty($inicio)||empty($fin)){
            $data= $this->model->getPatrullajes($id_institucion);   
        }
        else{
            $data= $this->model->listarRango($id_institucion,$inicio,$fin);     
        }  
        // $pdf = new CustomPDFSupervisiones('L', 'mm', 'Letter');  
        $pdf = new CustomPDFSupervisiones($inicio,$fin);  

        $pdf->AddPage();
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 7);
        $fill = false; 
        $index=1;
        foreach($data as $row) {

            // Ajustar el tamaño del texto para cada celda
            $fecha = $this->ajustarTexto($pdf, $row['fecha'], 25);
            $id_sucursal = $this->ajustarTexto($pdf, $row['id_sucursal'], 55);
            $id_supervisor = $this->ajustarTexto($pdf, $row['id_supervisor'], 55);    
            $ubicacion = $this->ajustarTexto($pdf,$row['lat'].",".$row['lng'],32);
            // $descripcion = $this->ajustarTexto($pdf, $row['descripcion'], 82); 
            $descripcion = $row['descripcion'];
            $lng = $pdf->GetStringWidth($row['descripcion']) ;
            $col=0;
            if ($lng<= 82)$col=5;
            else if ($lng> 82  && $lng<= 164) $col=10; 
            else if ($lng> 164 && $lng<= 246) $col=15;
            else if ($lng> 246 && $lng<= 328) $col=20;
            else if ($lng> 328 && $lng<= 410) $col=25;
            else if ($lng> 410 && $lng<= 490) $col=30;

            
            // $x = $pdf->GetX()-1;
            // $y = $pdf->GetY()-5;
            
            //para color de las filas
            if ($fill) {
                $pdf->SetFillColor(241, 249, 254);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            $pdf->Cell(7, $col, $index, 1,0, 'C',  $fill);
            $pdf->Cell(25, $col, $fecha, 1,0, 'C',  $fill);
            $pdf->Cell(55, $col, $id_sucursal, 1, 0, 'C',  $fill);
            $pdf->Cell(55, $col, $id_supervisor, 1, 0, 'C',  $fill);  
            $pdf->Cell(32, $col, $ubicacion, 1,0, 'C',  $fill);     

            // $pdf->MultiCell(82, 5, $descripcion, 1,0, 'C',  $fill);        
            // $pdf->SetXY($x + 7 + 25 + 55 + 55 + 82 + 32, $y + $col);

            $startX = $pdf->GetX()-1;
            $startY = $pdf->GetY()-5;
            $pdf->MultiCell(82, 5, $descripcion, 1, 'C', $fill);
            $endY = $pdf->GetY()-5;
    
            // Volver a la posición correcta para la siguiente celda
            $pdf->SetXY($startX + 82, $startY);
            $pdf->SetY($endY);


            $index++;
            $fill = !$fill;
            $pdf->Ln();
        }
        $pdf->Output('I', 'reporte_patrullajes.pdf');
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

    public function fechasPatrullajes(){
        $id_institucion= $_SESSION['id_institucion'];
   
        $inicio= $_POST['inicio'];
        $fin= $_POST['fin'];
        $data= $this->model->listarRango($id_institucion,$inicio,$fin);  
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnUbicacion= '<button class="btn btn-primary me-1" type="button" onClick="btnUbicacion('.$data[$i]['lat'].','.$data[$i]['lng'].')"> <i class="fas fa-location-dot"></i> </button>';
            $data[$i]['acciones'] =  $btnUbicacion;
        }
        echo json_encode($data);
        die();

    }
}
?>