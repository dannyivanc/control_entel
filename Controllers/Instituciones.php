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
        $this->views->getView($this,"index");
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
                    $msg ="si";
                }else if($data=="existe") {
                    $msg ="La institucion ya se encuentra registrada";
                }else{
                    $msg="Error al registrar la institucion";
                }
            }else{              
                $data= $this->model->modificarInstitucion($institucion,$id);
                if($data=="modificado"){
                    $msg ="modificado";
                }else{
                    $msg="Error al modificar institucion";
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

