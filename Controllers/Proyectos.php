<?php
class Proyectos extends Controller{   
    public function __construct(){
        session_start();          
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }    
        parent::__construct();
    }
     
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }     
        $id_user= $_SESSION['id_usuario'];
        $type = $_GET['view'];
        $permiso= $this->verificarPermiso($type);
        $verificar =    $this->model ->verificarPermiso($id_user,$permiso);
        if(!empty ($verificar)){
            $data['instituciones']=$this->model->getInstituciones();
            $data['vista']=$type;
            $this->views->getView($this, "index", $data);
        }
        else{
            // header('Location:'.base_url.'Errors');
            header('Location:'.base_url.'Proyectos?view='.$type);
            
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
            case 'ReporteSupervision':
                $permiso = 'reporte supervisiones';
                break;
            case 'ReporteVehiculos':
                $permiso = 'reporte vehiculos';
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


