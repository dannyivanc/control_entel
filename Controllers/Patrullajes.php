<?php
class Patrullajes extends Controller{
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
            $_SESSION['institucionInfo'] = $institucion_data; 
            if (!empty($institucion_data)) {
                $data['institucion'] =  $institucion_data;    
                $data['sucursales'] =  $this->model->getSucursales($id_institucion);    
                $this->views->getView($this, "index", $data);
            } else {
                header('Location: '.base_url.'Proyectos?view=patrullaje');
                exit();
            }
        } 
        else {          
            header('Location: '.base_url.'Proyectos?view=patrullaje');
            exit();
        }
    }

    public function perrie(){
        print_r($_SESSION['id_usuario']);
        print_r('---');
        // $id_sucursal= $this->institucionInfo;
        $id_sucursal= $_SESSION;
        print_r($id_sucursal);
    }

    public function listar(){
        $data= $this->model->listarPatrullajes($_SESSION['institucionInfo']['id']);   
   
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnEditar= '<button class="btn btn-primary me-1" type="button" onClick="btnEditarSupervision('.$data[$i]['id'].')"> <i class="fas fa-edit"></i> </button>';
            $data[$i]['acciones'] = $btnEditar;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

    // public function popopo(){
    //     $fecha =date('Y-m-d H:i:s');
    //     $lat= 19.90;
    //     $lng= 19.90;           
    //     $descripcion= 'hola';
    //     $id_sucursal= 6;     
    //     $id_supervisor= 2;   
    //     for ($i = 130001; $i < 500000; $i++) {
    //         $data= $this->model->registrarPatrullaje($fecha,$lat,$lng,$i,$id_sucursal,$id_supervisor);        
    //     }
       
    // }
    public function registrar(){
        $fecha =date('Y-m-d H:i:s');
        $lat= $_POST['lat'];    
        $lng= $_POST['lng'];           
        $descripcion= $_POST['descripcion'];
        $id_sucursal= $_POST['id_sucursal'];     
        $id_supervisor= $_SESSION['id_usuario'];     
        $id= $_POST['id'];    


        if(empty($lat)||empty($lng)||empty($id_sucursal) || empty($descripcion)){
            $msg= "Todos los campos son obligatorios";
        }else{
            if($id==""){       
                $data= $this->model->registrarPatrullaje($fecha,$lat,$lng,$descripcion,$id_sucursal,$id_supervisor);
                if($data=="ok"){
                    $msg ="si";
                }else if($data=="existe") {
                    $msg ="La sucursal ya se encuentra registrada";
                }else{
                    $msg=$data;
                }
               
            }else{       
                $data= $this->model->modificarPatrullaje($descripcion,$id_sucursal,$id);
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

    public function editar (int $id){
        $data=$this->model->editarPatrullaje($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
      }





}
?>


