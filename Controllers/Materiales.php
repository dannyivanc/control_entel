<?php
class Materiales extends Controller{
    private $sucursalInfo;
    public function __construct(){
        session_start();          
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }    
        parent::__construct();
        if($_SESSION['rol']=='vigilante'){
            $id = $_SESSION['id_usuario'];
            $sucursal= $this->model->getSucursal($id);
            $this->sucursalInfo=$sucursal;
        }
        else{
          if (isset($_POST['id_sucursal'])) {
            $id = intval($_POST['id_sucursal']);
            $_SESSION['aux'] = $id;  
            $sucursal = $this->model->getSucursalOthers($id);            
            $this->sucursalInfo = $sucursal;  
          }else {
                $id =  $_SESSION['aux'];  
                $sucursal = $this->model->getSucursalOthers($id);            
                $this->sucursalInfo = $sucursal;  
            }
        }
    }    
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
            exit;
        }       
        $id_user= $_SESSION['id_usuario'];        
        $verificar =$this->model ->verificarPermiso($id_user,'materiales');
        if(!empty ($verificar)){
            $data= $this->sucursalInfo;
            $this->views->getView($this, "index", $data);
            exit; 
        }
        else{
            header('Location:'.base_url.'Errors');
            exit;
        }
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
            $msg=array('ico'=>'success','msg'=> 'Exito al registrar');
        }else{
            if($id==""){
                $data= $this->model->registrarMaterial($fecha,$movimiento,$persona,$destino,$descripcion,$cantidad,$observacion,$id_sucursal,$id_vigilante);
                if($data=="ok"){
                    $msg=array('ico'=>'success','msg'=> 'Exito al registrar');
                }else{
                    $msg=array('ico'=>'error','msg'=> 'Error al registrar');
                }
            }
            else{       
                $data= $this->model->modificarMaterial($fecha,$movimiento,$persona,$destino,$descripcion,$cantidad,$observacion,$id_vigilante,$id);
                if($data=="modificado"){
                    $msg=array('ico'=>'success','msg'=> 'Modificado');
                }else{
                    $msg=array('ico'=>'error','msg'=> 'Error al modificar');
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
            $msg=array('ico'=>'success','msg'=> 'Registro completado con éxito');
       }else if($data=="vacio"){
            $msg=array('ico'=>'error','msg'=> 'No se pudo completar');
       }
       else{
            $msg=array('ico'=>'error','msg'=> 'Se produjo un error');
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



