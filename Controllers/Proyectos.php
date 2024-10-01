<?php
class Proyectos extends Controller{   
    public function __construct(){
        session_start();          
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
            exit;
        }    
        parent::__construct();
    }
     
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
            exit;
        }     
        $id_user= $_SESSION['id_usuario'];
        $type = $_GET['view'];        
        $permiso= $this->verificarPermiso($type);
        $verificar = $this->model ->verificarPermiso($id_user,$permiso);
        if($_SESSION['rol']=='cliente'){
            header('Location:'.base_url.'Inicio');
        }
        else if ($_SESSION['rol']!='cliente'){
            if(!empty ($verificar)){
                $data['instituciones']=$this->model->getInstituciones();
                $data['vista']=$type;
                $this->views->getView($this, "index", $data); 
                exit;
            }
            else{
                header('Location:'.base_url.'Inicio');
                exit;
            }
        }else{
            header('Location:'.base_url.'Inicio');
            exit;
        }
    }
    private function verificarPermiso(string $data){
        $permiso = '';
        switch ($data) {
            case 'Supervision':
                $permiso = 'supervision';
                break;
            case 'Patrullaje':
                $permiso = 'patrullaje';
                break;
            case 'ReporteSupervision':
                $permiso = 'reporte supervisiones';
                break;
            case 'ReportePatrullajes':
                $permiso = 'reporte patrullajes';
                break;
            case 'ReporteVehiculos':
                $permiso = 'reporte vehiculos';
                break;
            case 'ReporteMateriales':
                $permiso = 'reporte materiales';
                break;
            case 'RegistroVehiculo':
                $permiso = 'vehiculos';
                break;
            case 'RegistroMaterial':
                $permiso = 'materiales';
                break;
        }
        return $permiso;
    } 
    public function listar(){
        $data= $this->model->getInstituciones();       
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>


