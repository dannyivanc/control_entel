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
    // public function index(){
    //     if(empty($_SESSION['activo'])){
    //         header("location:".base_url);
    //         exit;
    //     }     
    //     $id_user= $_SESSION['id_usuario'];
    //     $type = $_GET['view'];
    //     $permiso= $this->verificarPermiso($type);
    //     $verificar =    $this->model ->verificarPermiso($id_user,$permiso);
    //     if(!empty ($verificar)){       
    //         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_institucion'])) {
    //             $data['institucion']=$this->model->getInstitucion($_POST['id_institucion']);
    //             $data['sucursales']=$this->model->getSucursales($_POST['id_institucion']);
    //             $data['vista']=$type;
    //             $_SESSION['data'] =  $data;

    //             if ($type == 'reporteVehiculos') {
    //                 header('Location: ' . base_url . 'ProyectoSucursal?view=' . $type . '&reload=true');
    //             } else {
    //                 header('Location: ' . base_url . 'Proyectos?view=' . $type . '&reload=true');
    //             }
    //             exit;
    //         } 
    //         else{
    //             if (isset($_SESSION['data'])) {
    //                 $data = $_SESSION['data'];
    //                 $this->views->getView($this, "index", $data);
    //             } else {
    //                 header('Location: ' . base_url . 'Proyectos?view=reporteVehiculos');
    //                 exit;
    //             }
    //         }
    //     }
    //     else{
    //         header('Location:'.base_url.'Errors');
    //         exit; 
    //     }
    // }

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

        // print_r($type);
        // print_r('---');
        // print_r($id_institucion);
        // print_r('---');
        // print_r($permiso);
        // print_r('---');
        // print_r($verificar);
        
        
        if (!empty($verificar)) {            
                $data['institucion'] = $this->model->getInstitucion($id_institucion);
                $data['sucursales'] = $this->model->getSucursales($id_institucion);
                $data['vista'] = $type;
                // $_SESSION['data'] = $data;
                $this->views->getView($this, "index", $data);
                exit;
          
        } else {
            // header('Location:' . base_url . 'Errors');
            exit;
        }




    
        // if (!empty($verificar)) {
        //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_institucion'])) {
        //         $data['institucion'] = $this->model->getInstitucion($_POST['id_institucion']);
        //         $data['sucursales'] = $this->model->getSucursales($_POST['id_institucion']);
        //         $data['vista'] = $type;
        //         $_SESSION['data'] = $data;
        //         header('Location: ' . base_url . 'ProyectoSucursal?view=' . $type);
        //         exit;
        //     } else {
        //         if (isset($_SESSION['data'])) {
        //             $data = $_SESSION['data'];
        //             $this->views->getView($this, "index", $data);
        //             unset($_SESSION['data']);
        //         } else {
        //             header('Location: ' . base_url . 'Proyectos?view='.$type);
        //             exit;
        //         }
        //     }
        // } else {
        //     // header('Location:' . base_url . 'Errors');
        //     exit;
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

    public function pipipi(){
        // $_SESSION['rol']='laputie';
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

 


    // public function index(){
    //     if(empty($_SESSION['activo'])){
    //     header("location:".base_url);
    //     }     
    //     $id_user= $_SESSION['id_usuario'];
    //     $type = $_GET['view'];        
    //     $permiso= $this->verificarPermiso($type);
    //     $verificar =    $this->model ->verificarPermiso($id_user,$permiso);
    //     if(!empty ($verificar)){       
    //         if ($_SESSION['id_usuario'] === 'POST' && isset($_POST['id_institucion'])) {
    //             $data['institucion']=$this->model->getInstitucion($_POST['id_institucion']);
    //             $data['sucursales']=$this->model->getSucursales($_POST['id_institucion']);
    //             $data['vista']=$type;
    //             $this->views->getView($this,"index",$data);
    //         } 
    //         else{
    //             header('Location:'.base_url.'Errors');
    //         }
    //     }
    //     else{
    //         header('Location:'.base_url.'Errors');
    //     }
    // }

}
?>


