<?php
class ProyectoSucursal extends Controller{   
    public function __construct(){
        session_start();          
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
            exit();
        }    
        parent::__construct();
    }  
  
    public function index() {
        if (empty($_SESSION['activo'])) {
            header("location:" . base_url);
            exit;
        }
        $id_user = $_SESSION['id_usuario'];
        $type = $_GET['view'];
        $id_institucion= $_GET['id'];
        $permiso = $this->verificarPermiso($type);
        $verificar = $this->model->verificarPermiso($id_user, $permiso);      
        if (!empty($verificar)) {            
                $data['institucion'] = $this->model->getInstitucion($id_institucion);
                $data['sucursales'] = $this->model->getSucursales($id_institucion);
                $data['vista'] = $type;
                $this->views->getView($this, "index", $data);
                exit;
        } else {
            header('Location:' . base_url . 'Inicio');
            exit;
        }
    }
    
    private function verificarPermiso(string $data){
        $permiso = '';
        switch ($data) {
            case 'supervision':
                $permiso = 'supervision';
                break;
            case 'patrullaje':
                $permiso = 'patrullaje';
                break;
            case 'reporteSupervision':
                $permiso = 'reporte supervisiones';
                break;
            case 'ReporteVehiculos':
                $permiso = 'reporte vehiculos';
                break;
            case 'ReporteMateriales':
                $permiso = 'reporte materiales';
                break;
            case 'RegistroVehiculo':
                $permiso = 'materiales';
                break;
            case 'RegistroMaterial':
                $permiso = 'vehiculos';
                break;
            case 'RegistroVisita':
                $permiso = 'visitas';
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


