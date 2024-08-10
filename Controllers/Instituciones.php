<?php
class Instituciones extends Controller{
    public function __construct(){
        session_start();              
        parent::__construct();
    
    }
    public function index(){    
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }
        $id_user= $_SESSION['id_usuario'];
        $verificar =    $this->model ->verificarPermiso($id_user,'institucion');
        if(!empty ($verificar)){
        
            $this->views->getView($this,"index");
        }
        else{
            header('Location:'.base_url.'Errors');
        }
    }

    public function listar(){
        $data= $this->model->getInstituciones();   
   
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnEditar= '<button class="btn btn-primary me-1" type="button" onClick="btnEditarInstitucion('.$data[$i]['id'].')"> <i class="fas fa-edit"></i> </button>';
            $btnDesactivar = '<button class="btn btn-danger" type="button" onClick="btnDesactivarInstitucion('.$data[$i]['id'].')"> <i class="fas fa-ban"></i> </button>';
            $btnActivar= '<button class="btn btn-success" type="button" onClick="btnActivarInstitucion('.$data[$i]['id'].')"> <i class="fas fa-check"></i> </button>';
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
        $institucion= $_POST['institucion'];      
        $id= $_POST['id'];     
        if(empty($institucion)){
            $msg= "El nombre es obligatorio";
        }else{
            if($id==""){
                $data= $this->model->registrarInstitucion($institucion);
                if($data=="ok"){
                     $msg=array('ico'=>'success','msg'=> 'Exito Al registrar');
                }else if($data=="existe") {
                    $msg=array('ico'=>'error','msg'=> 'La institucion ya se encuentrada registrada');
                }else if ($data=="error"){
                    $msg=array('ico'=>'error','msg'=> 'Error al registrar la institucion');
                }
            }else{              
                $data= $this->model->modificarInstitucion($institucion,$id);
                if($data=="modificado"){
                    $msg=array('ico'=>'success','msg'=> 'Modificado');
                }else if($data=="existe"){
                    $msg=array('ico'=>'error','msg'=> 'El nonbre de la institucion ya se encuentra registrado');
                }else{
                    $msg=array('ico'=>'error','msg'=> 'Error al modificar la institucion');
                }    
            }  
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar (int $id){
      $data=$this->model->editarInstitucion($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function desactivar(int $id){
        $data=$this->model ->accionInstitucion(0,$id);
       if($data==1){
            $msg=array('ico'=>'success','msg'=> 'Desactivado');
       }else{
            $msg=array('ico'=>'error','msg'=> 'Error al desactivar');
       }
       echo json_encode($msg,JSON_UNESCAPED_UNICODE);
       die();
    }
    public function activar(int $id){
        $data=$this->model ->accionInstitucion(1,$id);
       if($data==1){
            $msg=array('ico'=>'success','msg'=> 'Activado');
       }else{
            $msg=array('ico'=>'error','msg'=> 'Error al activar');
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

