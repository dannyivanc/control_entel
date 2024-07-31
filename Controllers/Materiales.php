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
        $id_user= $_SESSION['id_usuario'];
        $verificar =    $this->model ->verificarPermiso($id_user,'materiales');
        if(!empty ($verificar)){
            $data= $this->sucursalInfo;
            $this->views->getView($this, "index", $data);
        }
        else{
            header('Location:'.base_url.'Errors');
        }


        // $data= $this->sucursalInfo;
        // $this->views->getView($this, "index", $data);
    }
    public function perrie(){
        print_r($_SESSION['id_usuario']);
        print_r('---');
        print_r($this->sucursalInfo);
    }

    public function listar(){
        $id_sucursal= $this->sucursalInfo['id'];
        $data= $this->model->getMateriales($id_sucursal);       
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnEditar= '<button class="btn btn-primary me-1" type="button" onClick="btnEditarMaterial('.$data[$i]['id'].')"> <i class="fas fa-edit"></i> </button>';
            $btnDesactivar = '<button class="btn btn-warning" type="button" onClick="btnDesactivarMaterial('.$data[$i]['id'].')"> <i class="fas fa-check-double"></i> </button>';
            if($data[$i]['estado']==1){
                $data[$i]['estado']='<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = $btnEditar . $btnDesactivar;
            }

        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

    
    public function registrar(){
        $fecha= $_POST['fecha'];
        $movimiento =  $_POST['movimiento'];
        $persona= $_POST['persona'];
        $destino= $_POST['destino']; 
        $cantidad= $_POST['cantidad'];    
        $descripcion= $_POST['descripcion'];   
        $observacion= $_POST['observacion'];   
        $id_vigilante= $_SESSION['id_usuario'];   
        $id_sucursal=$this->sucursalInfo['id'];
        $id= $_POST['id'];  

        if(empty($fecha)||empty($movimiento)||empty($persona)||empty($destino)||empty($descripcion)||empty($cantidad)){
            $msg= "Solo las observaciones pueden esta vacias";
        }else{
            if($id==""){
                $data= $this->model->registrarMaterial($fecha,$movimiento,$persona,$destino,$descripcion,$cantidad,$observacion,$id_sucursal,$id_vigilante);
                if($data=="ok"){
                    $msg ="si";
                }else{
                    $msg="Error al registrar movimiento";
                }
            }
            else{       
                $data= $this->model->modificarMaterial($fecha,$movimiento,$persona,$destino,$descripcion,$cantidad,$observacion,$id_vigilante,$id);
                if($data=="modificado"){
                    $msg ="modificado";
                }else{
                    $msg="Error al modificar el movimiento";
                }
            }
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar (int $id){
      $data=$this->model->editarMaterial($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function desactivar(int $id){
        $data=$this->model ->accionMaterial($id);
       if($data=="ok"){
        $msg="ok";
       }else if($data=="void"){
        $msg="void";
       }
       else{
        $msg="Error en el material";
       }
       echo json_encode($msg,JSON_UNESCAPED_UNICODE);
       die();
    }

    public function pipipi(){
        // $_SESSION['rol']='laputie';
        echo '<pre>';
        // print_r($_SESSION);
        print_r($this->sucursalInfo);
        echo '</pre>';
    }

}
?>



