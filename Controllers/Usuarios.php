<?php

class Usuarios extends Controller{
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
            $data['instituciones']=$this->model->getInstituciones();
            $this->views->getView($this,"index",$data);
        }
        else{
            header('Location:'.base_url.'Inicio');
        }
        // $data['instituciones']=$this->model->getInstituciones();
        // $this->views->getView($this,"index",$data);
    }

    public function listar(){
             $data= $this->model->getUsuarios();       
       
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnPermisos= '<a class="btn btn-dark me-1" href="'.base_url.'Usuarios/permisos/'.$data[$i]['id'].'"> <i class="fas fa-key"></i> </a>';
            $btnEditar= '<button class="btn btn-primary me-1" type="button" onClick="btnEditarUser('.$data[$i]['id'].')"> <i class="fas fa-edit"></i> </button>';
            $btnDesactivar = '<button class="btn btn-danger" type="button" onClick="btnDesactivarUsuario('.$data[$i]['id'].')"> <i class="fas fa-ban"></i> </button>';
            $btnActivar= '<button class="btn btn-success" type="button" onClick="btnActivarUsuario('.$data[$i]['id'].')"> <i class="fas fa-check"></i> </button>';
            if($data[$i]['estado']==1){
                $data[$i]['estado']='<span class="badge  bg-success">Activo</span>';
                $data[$i]['acciones'] =  $btnPermisos . $btnEditar . $btnDesactivar;
            }else{
                $data[$i]['estado']='<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = $btnActivar;
            }

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
            $hash = hash("SHA256",$clave);
            $data =$this->model->getUsuario($usuario,$hash);
           
            if($data){
                $_SESSION['id_usuario']=$data['id'];
                $_SESSION['usuario']=$data['usuario'];
                $_SESSION['nombre']=$data['nombre'];            
                $_SESSION['activo']=$data['estado'];
                $_SESSION['rol']=$data['rol'];
                $_SESSION['id_institucion']=$data['id_institucion'];
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
        $cel= $_POST['cel'];
        $rol= $_POST['rol'];     
        $institucion= $_POST['institucion'];
        $id= $_POST['id'];      
        $hash=hash("SHA256",$clave);   
            
        $clave_ant=$_POST['clave_ant'];
        if(empty($usuario)||empty($nombre)||empty($carnet)||empty($clave)||empty($institucion)||empty($cel)||empty($rol)){
            $msg= "todos los campos son obligatorios";
        }else{
            if($id==""){
                $data= $this->model->registrarUsuario($usuario,$nombre,$carnet,$hash,$institucion,$cel,$rol);
                if($data=="ok"){
                    $msg ="si";
                }else if($data=="existe") {
                    $msg ="El usuario ya se encuentra registrado, Verifique el usuario o carnet";
                }else{
                    $msg="Error al registrar usuario";
                }
            }else{
                if ( $clave_ant==$clave){
                    // $data= $this->model->modificarUsuario($usuario,$nombre,$carnet,$hash,$institucion,$id);
                    $data= $this->model->modificarUsuario($usuario,$nombre,$carnet,$institucion,$id,$cel,$rol);
                    if($data=="modificado"){
                        $msg ="modificado";
                    }else{
                        $msg="Error al modificar usuario";
                    }
                }else{
                     // $data= $this->model->modificarUsuario($usuario,$nombre,$carnet,$hash,$institucion,$id);
                     $data= $this->model->modificarUsuarioPass($usuario,$nombre,$carnet,$hash,$institucion,$id,$cel,$rol);
                     if($data=="modificado"){
                         $msg ="modificado";
                     }else{
                         $msg="Error al modificar usuario";
                     }
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


    //permisos
    public function permisos($id){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }
        $data['datos']=$this->model->getPermisos();
        $permisos=$this->model->getDetallePermisos($id);
        $data['asignados']=array();
        foreach($permisos as $permiso){
            $data['asignados'][$permiso['id_permiso']]=true;
        }
        $data['id_usuario']=$id;
        $this->views->getView($this,"permisos",$data);
    }

    public function registrarPermiso(){
        $msg='';
        $id_user= $_POST['id_usuario'];
        $eliminar= $this->model->elimiarPermisos( $id_user);     
        if($eliminar == 'ok'){
            foreach($_POST ['permisos'] as $id_permiso ){
                $msg=$this->model->registrarPermisos($id_user,$id_permiso);
            }
            if($msg=='ok'){
                $msg=array('ico'=>'success','msg'=> 'permisos asignados');
            }else{
                $msg='Error al error al asignar los permisos';
            }
        }else {
            $msg='Error no identificado';
        }
        echo json_encode($msg);
    }


    public function salir(){
        session_destroy();
        header("location:".base_url);
    }
    public function pipipi(){
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }
}
?>

