<?php
class Usuarios extends Controller{
    public function __construct(){
        session_start();
        parent::__construct();
    }
    public function index(){
        $data['instituciones']=$this->model->getInstituciones();
        $this->views->getView($this,"index",$data);
    }

    public function listar(){
        $data= $this->model->getUsuarios();       
        for ($i=0; $i <count($data) ; $i++) { 
            if($data[$i]['estado']==1){
                $data[$i]['estado']='<span class="badge badge-success">Activo</span>';
            }else{
                $data[$i]['estado']='<span class="badge badge-danger">Activo</span>';
            }
           $data[$i]['acciones'] = '<div>
           <button class="btn btn-primary" type="button" onClick="btnEditarUser('.$data[$i]['id'].')"> <i class="fas fa-edit"></i> </button>
           <button class="btn btn-danger" type="button" onClick="btnDesactivarUsuario('.$data[$i]['id'].')"> <i class="fas fa-ban"></i> </button>
           <button class="btn btn-success" type="button" onClick="btnActivarUsuario('.$data[$i]['id'].')"> <i class="fas fa-check"></i> </button>
           <div/>';
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

      public function validar(){
        if(empty($_POST['usuario']) || empty($_POST['clave'])){
            $msg = "Los campos estan vacios";
        }else{
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $data =$this->model->getUsuario($usuario,$clave);
           
            if($data){
                $_SESSION['id_usuario']=$data['id'];
                $_SESSION['usuario']=$data['usuario'];
                $_SESSION['nombre']=$data['nombre'];
                $msg="ok";
            }else{
                $msg ="Usuario o contraseña incorrecta";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
       
        die();
    }

    
    public function registrar(){
        $usuario= $_POST['usuario'];
        $nombre= $_POST['nombre'];
        $carnet= $_POST['carnet'];
        $clave= $_POST['clave'];    
        $institucion= $_POST['institucion'];
        $id= $_POST['id'];
        $hash=hash("SHA256",$clave);
        if(empty($usuario)||empty($nombre)||empty($carnet)||empty($clave)||empty($institucion)){
            $msg= "todos los campos son obligatorios";
        }else{
            if($id==""){
                $data= $this->model->registrarUsuario($usuario,$nombre,$carnet,$hash,$institucion);
                if($data=="ok"){
                    $msg ="si";
                }else if($data=="existe") {
                    $msg ="El usuario ya se encuentra registrado, Verifique el usuario o carnet";
                }else{
                    $msg="Error al registrar usuario";
                }
            }else{
                $data= $this->model->modificarUsuario($usuario,$nombre,$carnet,$clave,$institucion,$id);
                if($data=="modificado"){
                    $msg ="modificado";
                }else{
                    $msg="Error al modificar usuario";
                }

            }
          
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar (int $id){
      $data=$this->model->editarUser($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function desactivar(int $id){
        $data=$this->model ->accionUser(0,$id);
       if($data==1){
        $msg="ok";
       }else{
        $msg="Error al desactivar usuario";
       }
       echo json_encode($msg,JSON_UNESCAPED_UNICODE);
       die();
    }
    public function activar(int $id){
        $data=$this->model ->accionUser(1,$id);
       if($data==1){
        $msg="ok";
       }else{
        $msg="Error al activar usuario";
       }
       echo json_encode($msg,JSON_UNESCAPED_UNICODE);
       die();
    }
}
?>

