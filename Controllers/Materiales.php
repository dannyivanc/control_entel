<?php
class Materiales extends Controller{
    private $sucursalInfo;
    public function __construct(){
        session_start();          
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }    
        parent::__construct();
        $id = $_SESSION['id_usuario'];
        $sucursal= $this->model->getSucursal($id);
        $this->sucursalInfo=$sucursal;
    }
    
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }       
        $data= $this->sucursalInfo;
        $this->views->getView($this, "index", $data);
    }
    public function perrie(){
        print_r($_SESSION['id_usuario']);
        print_r('---');
        print_r($this->sucursalInfo['id']);
    }

    public function listar(){
        $id_sucursal= $this->sucursalInfo['id'];
        $data= $this->model->getMateriales($id_sucursal);       
       
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnEditar= '<button class="btn btn-primary me-1" type="button" onClick="btnEditarVehiculo('.$data[$i]['id'].')"> <i class="fas fa-edit"></i> </button>';
            $btnDesactivar = '<button class="btn btn-warning" type="button" onClick="btnDesactivarVehiculo('.$data[$i]['id'].')"> <i class="fas fa-check-double"></i> </button>';
            $btnActivar= '<button class="btn btn-success" type="button" onClick="btnActivarVehiculo('.$data[$i]['id'].')"> <i class="fas fa-check"></i> </button>';
            if($data[$i]['estado']==1){
                $data[$i]['estado']='<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = $btnEditar . $btnDesactivar;
            }else{
                $data[$i]['estado']='<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = $btnActivar;
            }

        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

    
    public function registrar(){
        $fecha= $_POST['salida'];
        $movimiento =  $_POST['movimiento'];
        $persona= $_POST['persona'];
        $destino= $_POST['destino'];    
        $descripcion= $_POST['descripcion'];   
        $observacion= $_POST['observacion'];   
        $id_vigilante= $this->sucursalInfo['id_vigilante'];   
        $id_sucursal=$this->sucursalInfo['id'];
        $id= $_POST['id'];  

        $msg="si";
        // if(empty($fecha)||empty($movimiento)||empty($persona)||empty($destino)||empty($descripcion)){
        //     $msg= "Solo las observaciones pueden esta vacias";
        // }else{
        //     if($id==""){
        //         $data= $this->model->registrarMaterial($fecha,$movimiento,$persona,$destino,$descripcion,$observacion,$id_vigilante,$id_sucursal);
        //         if($data=="ok"){
        //             $msg ="si";
        //         }else{
        //             $msg="Error al registrar movimiento";
        //         }
        //     }
        //     else{       
        //         $data= $this->model->modificarMaterial($fecha,$movimiento,$persona,$destino,$descripcion,$observacion,$id_vigilante,$id);
        //         if($data=="modificado"){
        //             $msg ="modificado";
        //         }else{
        //             $msg="Error al modificar el movimiento";
        //         }
        //     }
        // }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar (int $id){
      $data=$this->model->editarVehiculo($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function desactivar(int $id){
        $data=$this->model ->accionVehiculo($id);
       if($data=="ok"){
        $msg="ok";
       }else if($data=="void"){
        $msg="void";
       }
       else{
        $msg="Error al desactivar el vehiculo";
       }
       echo json_encode($msg,JSON_UNESCAPED_UNICODE);
       die();
    }


}
?>


