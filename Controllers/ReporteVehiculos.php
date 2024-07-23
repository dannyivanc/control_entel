<?php
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
        $this->Cell(25, 8, 'Fecha/Hora', 1, 0, 'C', true);
        $this->Cell(58, 8, 'Sucursal', 1, 0, 'C', true);
        $this->Cell(57, 8, 'Vigilante', 1, 0, 'C', true);
        $this->Cell(18, 8, 'Puntualidad', 1, 0, 'C', true);
        $this->Cell(14, 8, 'Pres_per', 1, 0, 'C', true);
        $this->Cell(12, 8, 'Patrulla', 1, 0, 'C', true);
        $this->Cell( 9, 8, 'Epp', 1, 0, 'C', true);
        $this->Cell(10, 8, 'Libro', 1, 0, 'C', true);
        $this->Cell(16, 8, 'Verif_vehi', 1, 0, 'C', true);
        $this->Cell(32, 8, 'Ubicacion', 1, 1, 'C', true);
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
            if($_SESSION['rol']=='cliente'){ 
                $this->views->getView($this,"index");
                
            }
            else{
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sucursal'])) {
                    // $_SESSION['id_institucion'] = $_POST['id_institucion'];    
                    $this->views->getView($this,"index"); 
                } 
                else{                   
                    header("Location: ".base_url."Proyectos?view=reporteVehiculos");
                }
            }
        }
        else{
            header('Location:'.base_url.'Errors');
        }
    }

    public function listar(){
        $id_institucion= $_SESSION['id_institucion'];
        $data= $this->model->getSupervisiones($id_institucion);       
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
            $data= $this->model->getSupervisiones($id_institucion);   
        }
        else{
            $data= $this->model->listarRango($id_institucion,$inicio,$fin);     
        }  
        // $pdf = new CustomPDFSupervisiones('L', 'mm', 'Letter');  
        $pdf = new CustomPDFVehiculos($inicio,$fin);  

        $pdf->AddPage();
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 7);
        $fill = false; 
        $index=1;
        foreach($data as $row) {
            // Ajustar el tamaño del texto para cada celda
            $fecha = $this->ajustarTexto($pdf, $row['fecha'], 25);
            $id_sucursal = $this->ajustarTexto($pdf, $row['id_sucursal'], 58);
            $id_vigilante = $this->ajustarTexto($pdf, $row['id_vigilante'], 57);
            $puntualidad = $this->ajustarTexto($pdf, $row['puntualidad'], 18);
            $pres_per = $this->ajustarTexto($pdf, $row['pres_per'], 14);
            $patrulla = $this->ajustarTexto($pdf, $row['patrulla'], 12);
            $epp = $this->ajustarTexto($pdf, $row['epp'], 9);
            $libro = $this->ajustarTexto($pdf, $row['libro'], 10);
            $verif_vehi = $this->ajustarTexto($pdf, $row['verif_vehi'], 16);           
            $ubicacion = $this->ajustarTexto($pdf,$row['lat'].",".$row['lng'],32);
            //para color de las filas
            if ($fill) {
                $pdf->SetFillColor(241, 249, 254);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            $pdf->Cell(7, 5, $index, 1,null, null,  $fill);
            $pdf->Cell(25, 5, $fecha, 1,null, null,  $fill);
            $pdf->Cell(58, 5, $id_sucursal, 1, null, null,  $fill);
            $pdf->Cell(57, 5, $id_vigilante, 1, null, null,  $fill);
            $pdf->Cell(18, 5, $puntualidad, 1,null, null,  $fill);
            $pdf->Cell(14, 5, $pres_per, 1,null, null,  $fill);
            $pdf->Cell(12, 5, $patrulla, 1, null, null,  $fill);
            $pdf->Cell( 9, 5, $epp, 1, null, null,  $fill);
            $pdf->Cell(10, 5, $libro, 1, null, null,  $fill);
            $pdf->Cell(16, 5, $verif_vehi, 1,null, null,  $fill);
            $pdf->Cell(32, 5, $ubicacion, 1,null, null,  $fill);

            $index++;
            $fill = !$fill;
            $pdf->Ln();
        }
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

    public function fechasSupervisiones(){
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
    public function pipipi(){
        // $_SESSION['rol']='laputie';
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }
}
?>