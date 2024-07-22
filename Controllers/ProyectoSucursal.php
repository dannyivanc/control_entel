<?php
class ProyectoSucursal extends Controller{   
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
        // $id_user= $_SESSION['id_usuario'];
        $type = $_GET['view'];
        // $permiso= $this->verificarPermiso($type);
        // $verificar =    $this->model ->verificarPermiso($id_user,$permiso);
        // if(!empty ($verificar)){       
            // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_institucion'])) {
                $data['institucion']=$this->model->getInstitucion($_POST['id_institucion']);
                $data['sucursales']=$this->model->getSucursales($_POST['id_institucion']);
                $data['vista']=$type;
                // print_r($data);
                $this->views->getView($this,"index",$data);
            // } 
            // else{
            //     header('Location:'.base_url.'Errors');
            // }
        // }
        // else{
        //     header('Location:'.base_url.'Errors');
        // }
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
            case 'reporteVehiculos':
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


