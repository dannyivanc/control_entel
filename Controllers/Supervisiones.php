<?php
class Supervisiones extends Controller{
    private $institucionInfo;
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_institucion'])) {
            $id_institucion = $_POST['id_institucion'];          
            $institucion_data = $this->model->getInstitucion($id_institucion);

            $this->institucionInfo= $institucion_data;
            if (!empty($institucion_data)) {
                $data['institucion'] =  $institucion_data;    
                $data['sucursales'] =  $this->model->getSucursales($id_institucion);   
                $data['vigilantes']= $this->model->getVigilantes($id_institucion);   
                $this->views->getView($this, "index", $data);
            } else {
                header('Location: '.base_url.'Proyectos');
                exit();
            }
        } 
        else {          
            header('Location: '.base_url.'Proyectos');
            exit();
        }
    }

    public function perrie(){
        print_r($_SESSION['id_usuario']);
        print_r('---');
        print_r($this->institucionInfo);
    }

    public function listar(){
        $data= $this->model->getSucursales();   
   
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnEditar= '<button class="btn btn-primary me-1" type="button" onClick="btnEditarSucursal('.$data[$i]['id'].')"> <i class="fas fa-edit"></i> </button>';
            $btnDesactivar = '<button class="btn btn-danger" type="button" onClick="btnDesactivarSucursal('.$data[$i]['id'].')"> <i class="fas fa-ban"></i> </button>';
            $btnActivar= '<button class="btn btn-success" type="button" onClick="btnActivarSucursal('.$data[$i]['id'].')"> <i class="fas fa-check"></i> </button>';
            if($data[$i]['estado']==1){
                $data[$i]['estado']='<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = $btnEditar . $btnDesactivar;
            }else{
                $data[$i]['estado']='<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] =  $btnActivar;
            }
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar(){
        $date =date('Y-m-d H:i:s');
        $lat= $_POST['lat'];    
        $lng= $_POST['lng'];           
        $puntualidad = isset($_POST['puntualidad']) ? "Si" : "No";
        $pres_per= isset($_POST['pres_per']) ? "Si" : "No";
        $patrulla= isset($_POST['patrulla']) ? "Si" : "No";  
        $epp= isset($_POST['epp']) ? "Si" : "No";
        $libro= isset($_POST['libro']) ? "Si" : "No"; 
        $verif_vehi= isset($_POST['verif_vehi']) ? "Si" : "No";  
        $id_sucursal= $_POST['id_sucursal'];      
        $id_vigilante= $_POST['id_vigilante']; 
        $id= $_POST['id'];     

        if(empty($sucursal)||empty($institucion)||empty($vigilante) ||empty($ciudad) ||empty($direccion)){
            $msg= "Todos los campos son obligatorios";
        }else{
            if($id==""){       
                $data= $this->model->registrarSucursal($date,$lat,$lng,$puntualidad,$pres_per,$patrulla, $epp,$libro,$verif_vehi,$id_sucursal,$id_vigilante);
                if($data=="ok"){
                    $msg ="si";
                }else if($data=="existe") {
                    $msg ="La sucursal ya se encuentra registrada";
                }else{
                    $msg=$data;
                }
            }else{       
                $data= $this->model->modificarSucursal($date,$lat,$lng,$puntualidad,$pres_per,$patrulla, $epp,$libro,$verif_vehi,$id_sucursal,$id_vigilante,$id);
                if($data=="modificado"){
                    $msg ="modificado";
                }else{
                    $msg="Error al modificar la sucursal";
                    
                }      
            }  
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }






}
?>


