<?php
class Sucursales extends Controller{
    public function __construct(){
        session_start();              
        parent::__construct();
    
    }
    public function index(){     
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }
        $id_user= $_SESSION['id_usuario'];
        $verificar = $this->model ->verificarPermiso($id_user,'sucursal');
        if(!empty ($verificar)){
            $data['instituciones']=$this->model->getInstituciones();
            $data['vigilantes']=$this->model->getVigilantes();
            $this->views->getView($this,"index",$data);
        }
        else{
            header('Location:'.base_url.'Inicio');
        }
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
        $msg='';
        $sucursal= $_POST['sucursal'];      
        $institucion= $_POST['institucion'];   
        $vigilantes= $_POST['vigilante'];   
        $ciudad= $_POST['ciudad'];   
        $direccion= $_POST['direccion'];   
        $id= $_POST['id'];     
            if($id==""){  
                $data= $this->model->registrarSucursal($sucursal,$institucion,$ciudad,$direccion);  
                if($data=="error"){
                    $msg=array('ico'=>'error','msg'=> 'Error al crear la sucursal');
                }
                else if($data=="existe"){
                    $msg=array('ico'=>'error','msg'=> 'El nombre de la sucursal ya esta registrada');
                }
                else{
                    foreach($vigilantes as $vigilante){
                        $this->model->cambiarVigilante($vigilante,$data);    
                    }
                    $msg=array('ico'=>'success','msg'=> 'Registrado con exito');
                }
            }
            else{  
                $dataSuc= $this->model->modificarSucursal($sucursal,$institucion,$ciudad,$direccion,$id);  
                if($dataSuc=="modificado"){
                    foreach($vigilantes as $vigilante){
                        $this->model->cambiarVigilante($vigilante,$id);
                     }
                     $msg=array('ico'=>'success','msg'=> 'Modificado');
                }
                else{
                    $msg=array('ico'=>'error','msg'=> 'Error al modificar');
                }     
            } 
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar (int $id){
      $data=$this->model->editarSucursal($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function desactivar(int $id){
        $data=$this->model ->accionInstitucion(0,$id);
       if($data==1){
        $msg="ok";
       }else{
        $msg="Error al desactivar usuario";
       }
       echo json_encode($msg,JSON_UNESCAPED_UNICODE);
       die();
    }
    
    public function activar(int $id){
        $data=$this->model ->accionInstitucion(1,$id);
       if($data==1){
        $msg="ok";
       }else{
        $msg="Error al activar usuario";
       }
       echo json_encode($msg,JSON_UNESCAPED_UNICODE);
       die();
    }

    public function salir(){
        session_destroy();
        header("location:".base_url);
    }
}
?>  

