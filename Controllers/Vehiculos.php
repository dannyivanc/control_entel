<?php
class Vehiculos extends Controller{
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
        $verificar = $this->model ->verificarPermiso($id_user,'vehiculos');
        if(!empty ($verificar)){
            $data= $this->sucursalInfo;
            $this->views->getView($this, "index", $data);
        }
        else{
            header('Location:'.base_url.'Inicio');
        }
    }
    public function perrie(){
        print_r($_SESSION['id_usuario']);
        print_r('---');
        print_r($this->sucursalInfo['id']);
    }

    public function listar(){
        $id_sucursal= $this->sucursalInfo['id'];
        $data= $this->model->getVehiculos($id_sucursal);       
       
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
        $salida= $_POST['salida'];
        $retorno = empty($_POST['retorno']) ? '2000-00-00T00:00:00' : $_POST['retorno'];
        $tipo= $_POST['tipo'];
        $placa= $_POST['placa'];    
        $km_salida= $_POST['km_salida'];       
        $km_retorno = empty($_POST['km_retorno']) ? 0: $_POST['km_retorno'];    
        $conductor=$_POST['conductor'];  
        $destino=$_POST['destino']; 
        $id_sucursal=$this->sucursalInfo['id'];
        $id_vigilante= $_SESSION['id_usuario'];   
        $id= $_POST['id'];   
        $msg= $retorno;   
        if(empty($salida)||empty($tipo)||empty($placa)||empty($km_salida)||empty($conductor)||empty($destino)){
            $msg= "todos los campos son obligatorios";
        }else{

            if($id==""){
                $data= $this->model->registrarVehiculo($salida,$retorno,$tipo,$placa,$km_salida,$km_retorno,$conductor,$destino,$id_vigilante,$id_sucursal);
                if($data=="ok"){
                    $msg ="si";
                }else{
                    $msg="Error al registrar vehiculo";
                }
            }
            else{       
                $data= $this->model->modificarVehiculo($salida,$retorno,$tipo,$placa,$km_salida,$km_retorno,$conductor,$destino,$id_vigilante,$id);
                if($data=="modificado"){
                    $msg ="modificado";
                }else{
                    $msg="Error al modificar el vehiculo";
                }
            }
        }
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


