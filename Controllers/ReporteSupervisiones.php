<?php
require('Libraries/fpdf/fpdf.php');
class CustomPDFSupervisiones extends FPDF {
    // Cabecera de página
    function Header() {
        // Logo
        $this->Image('Assets/img/logo_web.png', 10, 10, 30);
        // Título
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 10,  iconv('UTF-8', 'ISO-8859-1','Reporte de Supervisiones'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        // $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1','Lista de vigilantes asignados a la institución'), 0, 1, 'C');
        $this->Ln(20);

        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 220, 255);
        $this->Cell( 8, 10, 'N', 1, 0, 'C', true);
        $this->Cell(29, 10, 'Fecha/Hora', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Sucursal', 1, 0, 'C', true);
        $this->Cell(55, 10, 'Vigilante', 1, 0, 'C', true);
        $this->Cell(18, 10, 'Puntualidad', 1, 0, 'C', true);
        $this->Cell(14, 10, 'Pres_per', 1, 0, 'C', true);
        $this->Cell(12, 10, 'Patrulla', 1, 0, 'C', true);
        $this->Cell( 9, 10, 'Epp', 1, 0, 'C', true);
        $this->Cell(10, 10, 'Libro', 1, 0, 'C', true);
        $this->Cell(16, 10, 'Verif_vehi', 1, 0, 'C', true);
        $this->Cell(36, 10, 'Ubicacion', 1, 1, 'C', true);


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
        // 
        // $data= $this->model->listarRango($id_institucion);      
        $pdf = new CustomPDFSupervisiones('L', 'mm', 'Letter');  

        $pdf->AddPage();
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 8);
        $fill = false; 
        $index=1;
        foreach($data as $row) {
            // Ajustar el tamaño del texto para cada celda
            $fecha = $this->ajustarTexto($pdf, $row['fecha'], 43);
            $id_sucursal = $this->ajustarTexto($pdf, $row['id_sucursal'], 50);
            $id_vigilante = $this->ajustarTexto($pdf, $row['id_vigilante'], 55);
            $puntualidad = $this->ajustarTexto($pdf, $row['puntualidad'], 18);
            $pres_per = $this->ajustarTexto($pdf, $row['pres_per'], 14);
            $patrulla = $this->ajustarTexto($pdf, $row['patrulla'], 12);
            $epp = $this->ajustarTexto($pdf, $row['epp'], 9);
            $libro = $this->ajustarTexto($pdf, $row['libro'], 10);
            $verif_vehi = $this->ajustarTexto($pdf, $row['verif_vehi'], 16);           
            $ubicacion = $this->ajustarTexto($pdf,$row['lat'].",".$row['lng'],36);
            //para color de las filas
            if ($fill) {
                $pdf->SetFillColor(241, 249, 254);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            $pdf->Cell(8, 10, $index, 1,null, null,  $fill);
            $pdf->Cell(29, 10, $fecha, 1,null, null,  $fill);
            $pdf->Cell(50, 10, $id_sucursal, 1, null, null,  $fill);
            $pdf->Cell(55, 10, $id_vigilante, 1, null, null,  $fill);
            $pdf->Cell(18, 10, $puntualidad, 1,null, null,  $fill);
            $pdf->Cell(14, 10, $pres_per, 1,null, null,  $fill);
            $pdf->Cell(12, 10, $patrulla, 1, null, null,  $fill);
            $pdf->Cell( 9, 10, $epp, 1, null, null,  $fill);
            $pdf->Cell(10, 10, $libro, 1, null, null,  $fill);
            $pdf->Cell(16, 10, $verif_vehi, 1,null, null,  $fill);
            $pdf->Cell(36, 10, $ubicacion, 1,null, null,  $fill);

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
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }
}
?>