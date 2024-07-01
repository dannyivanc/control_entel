<?php
require('Libraries/tcpdf/tcpdf.php');
// require('Libraries/fpdf/fpdf.php');


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
    // public function generarPDF() {

    //     // Datos para la tabla (puedes obtener estos datos de la base de datos)
    //     $data = $this->model->getUsuarios();

    //     // Crear una nueva instancia de FPDF
    //     $pdf = new FPDF();
    //     $pdf->AddPage();

    //     // Encabezado
    //     $pdf->SetFont('Arial', 'B', 16);
    //     $pdf->Cell(0, 10, 'Reporte de Vigilantes', 0, 1, 'C');

    //     // Salto de línea
    //     $pdf->Ln(10);

    //     // Configuración de la fuente para la tabla
    //     $pdf->SetFont('Arial', 'B', 12);

    //     // Encabezados de la tabla
    //     $header = array('Nombre', 'Carnet', 'Celular');

    //     // Ancho de las columnas
    //     $widths = array(60, 60, 60);

    //     // Agregar encabezados
    //     for ($i = 0; $i < count($header); $i++) {
    //         $pdf->Cell($widths[$i], 7, $header[$i], 1);
    //     }
    //     $pdf->Ln();

    //     // Datos de la tabla
    //     $pdf->SetFont('Arial', '', 12);

    //     foreach ($data as $row) {
    //         // Calcular la altura máxima de la fila
    //         $nombreHeight = $pdf->GetStringWidth($row['nombre']) / $widths[0] * 10;
    //         $carnetHeight = $pdf->GetStringWidth($row['carnet']) / $widths[1] * 10;
    //         $celHeight = $pdf->GetStringWidth($row['cel']) / $widths[2] * 10;
            
    //         $maxHeight = max($nombreHeight, $carnetHeight, $celHeight);

    //         // Dibujar cada celda de la fila con la altura máxima calculada
    //         $x = $pdf->GetX();
    //         $y = $pdf->GetY();
            
    //         $pdf->MultiCell($widths[0], 10, $row['nombre'], 1);
    //         $pdf->SetXY($x + $widths[0], $y);
    //         $pdf->MultiCell($widths[1], 10, $row['carnet'], 1);
    //         $pdf->SetXY($x + $widths[0] + $widths[1], $y);
    //         $pdf->MultiCell($widths[2], 10, $row['cel'], 1);
    //         $pdf->Ln();
    //     }

    //     // Generar y descargar el PDF
    //     $pdf->Output('D', 'reporte_vigilantes.pdf');
    // }

    // public function generarPdf() {
    //     // create new PDF document
    //     $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    //     // set document information
    //     $pdf->SetCreator(PDF_CREATOR);
    //     $pdf->SetAuthor('Nicola Asuni');
    //     $pdf->SetTitle('TCPDF Example 001');
    //     $pdf->SetSubject('TCPDF Tutorial');
    //     $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    //     // set default header data
    //     $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    //     $pdf->setFooterData(array(0,64,0), array(0,64,128));

    //     // set header and footer fonts
    //     $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    //     $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    //     // set default monospaced font
    //     $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //     // set margins
    //     $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    //     $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //     $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //     // set auto page breaks
    //     $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //     // set image scale factor
    //     $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //     // set some language-dependent strings (optional)
    //     if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    //         require_once(dirname(__FILE__).'/lang/eng.php');
    //         $pdf->setLanguageArray($l);
    //     }

    //     // ---------------------------------------------------------

    //     // set default font subsetting mode
    //     $pdf->setFontSubsetting(true);

    //     // Set font
    //     // dejavusans is a UTF-8 Unicode font, if you only need to
    //     // print standard ASCII chars, you can use core fonts like
    //     // helvetica or times to reduce file size.
    //     $pdf->SetFont('dejavusans', '', 14, '', true);

    //     // Add a page
    //     // This method has several options, check the source code documentation for more information.
    //     $pdf->AddPage();

    //     // set text shadow effect
    //     $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

    //     // Set some content to print
    //     $html = <<<EOD
    //     <h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
    //     <i>This is the first example of TCPDF library.</i>
    //     <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
    //     <p>Please check the source code documentation and other examples for further information.</p>
    //     <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
    //     EOD;

    //     // Print text using writeHTMLCell()
    //     $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    //     // ---------------------------------------------------------

    //     // Close and output PDF document
    //     // This method has several options, check the source code documentation for more information.
    //     $pdf->Output('example_001.pdf', 'I');
    // }

    public function generarPdf(){
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Título del PDF');
$pdf->SetSubject('Asunto del PDF');
$pdf->SetKeywords('TCPDF, PDF, ejemplo, test, guía');

// Establecer los encabezados y pies de página
$pdf->setHeaderData('', 0, 'Encabezado del Documento', 'Subtítulo del documento');
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// Establecer las fuentes de encabezado y pie de página
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Establecer las márgenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Establecer la ruptura automática de página
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Establecer el modo de escala de imagen
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Añadir una página
$pdf->AddPage();

// Establecer el contenido del PDF
$html = '<h1>Hola Mundo</h1><p>Este es un documento PDF generado con TCPDF.</p>';

// Escribir el contenido HTML al PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del PDF
$pdf->Output('documento.pdf', 'I');
    }


}

?>