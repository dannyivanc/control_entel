<?php
class Supervisiones extends Controller{
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
        $verificar = $this->model ->verificarPermiso($id_user,'supervision');
        if(!empty ($verificar)){
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_institucion'])) {
                $id_institucion = $_POST['id_institucion'];          
                $institucion_data = $this->model->getInstitucion($id_institucion);
                $_SESSION['institucionInfo'] = $institucion_data; 
                if (!empty($institucion_data)) {
                    $data['institucion'] =  $institucion_data;    
                    $data['sucursales'] =  $this->model->getSucursales($id_institucion);   
                    $data['vigilantes']= $this->model->getVigilantes($id_institucion);   
                    $this->views->getView($this, "index", $data);
                } else {
                    header('Location: '.base_url.'Proyectos?view=Supervision');
                    exit();
                }
            } 
            else {          
                header('Location: '.base_url.'Proyectos?view=Supervision');
                exit();
            }
        }
        else{
            header('Location:'.base_url.'Inicio');
        }    
    }

    public function listar(){
        $data= $this->model->listarSupervisiones($_SESSION['institucionInfo']['id']);   
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnEditar= '<button class="btn btn-primary me-1" type="button" onClick="btnEditarSupervision('.$data[$i]['id'].')"> <i class="fas fa-edit"></i> </button>';
            $data[$i]['acciones'] = $btnEditar;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar(){
        $fecha =date('Y-m-d H:i:s');
        $lat= $_POST['lat'];    
        $lng= $_POST['lng'];           
        $puntualidad = isset($_POST['puntualidad']) ? "Si" : "No";
        $pres_per= isset($_POST['pres_per']) ? "Si" : "No";
        $patrulla= isset($_POST['patrulla']) ? "Si" : "No";  
        $epp= isset($_POST['epp']) ? "Si" : "No";
        $libro= isset($_POST['libro']) ? "Si" : "No"; 
        $verif_vehi= isset($_POST['verif_vehi']) ? "Si" : "No";  
        $id_sucursal= $_POST['id_sucursal'];     
        $id_supervisor= $_SESSION['id_usuario'];     
        $id_vigilante= $_POST['id_vigilante']; 
        $id= $_POST['id'];    
        if(empty($lat)||empty($lng)||empty($id_sucursal) ||empty($id_vigilante)){
            $msg= "Todos los campos son obligatorios";
        }else{
            if($id==""){       
                $data= $this->model->registrarSupervision($fecha,$lat,$lng,$puntualidad,$pres_per,$patrulla, $epp,$libro,$verif_vehi,$id_sucursal,$id_supervisor,$id_vigilante);
                if($data=="ok"){
                    $msg=array('ico'=>'success','msg'=>'Registado con exito');
                }else if($data=="existe") {
                    $msg=array('ico'=>'error','msg'=>'Error al registrar');
                }else{
                    $msg=$data;
                }
            }else{       
                $data= $this->model->modificarSupervision($puntualidad,$pres_per,$patrulla, $epp,$libro,$verif_vehi,$id_sucursal,$id_vigilante,$id);
                if($data=="modificado"){
                    $msg=array('ico'=>'success','msg'=>'Modificado con exito');
                }else if($data=="existe") {
                    $msg=array('ico'=>'error','msg'=>'Error al modificar');
                }      
            }  
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar (int $id){
        $data=$this->model->editarSupervision($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
      }
}
?>


