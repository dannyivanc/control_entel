<?php

class Usuarios extends Controller{
    public function __construct(){
        session_start();              
        parent::__construct();
    }

    public function encryptId($id) {
        return base64_encode($id);
    }
    public function decryptId($encryptedId) {
        return base64_decode($encryptedId);
    }

    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }
        $id_user= $_SESSION['id_usuario'];
        $verificar = $this->model ->verificarPermiso($id_user,'usuarios');
        if(!empty ($verificar)){
            $data['instituciones']=$this->model->getInstituciones();
            $this->views->getView($this,"index",$data);
        }
        else{
            header('Location:'.base_url.'Inicio');
        }
    }

    public function listar(){
             $data= $this->model->getUsuarios();       
       
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            // $encryptedId = encryptId($data[$i]['id']);
            $encryptedId = $this->encryptId($data[$i]['id']);
            // $btnPermisos= '<a class="btn btn-dark me-1" href="'.base_url.'Usuarios/permisos/'.$data[$i]['id'].'"> <i class="fas fa-key"></i> </a>';
            $btnPermisos= '<a class="btn btn-dark me-1" href="'.base_url.'Usuarios/permisos/'.$encryptedId.'"> <i class="fas fa-key"></i> </a>';
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
                $permisos =$this->model->getArrPermiso($data['id']); 
                foreach ($permisos as $permiso) {
                    $_SESSION['v_' . $permiso["vista"]] = $permiso["vista"];
                }
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
        else{
            if(empty ($id)){
                header('Location:'.base_url.'Usuarios');
            }
            else{
                $id_decrip = $this->decryptId($id);
                // $verificar=$this->model->getUser($id);
                $verificar=$this->model->getUser($id_decrip);
                if(!empty ($verificar)){
                    $data['datos']=$this->model->getPermisos();
                    $permisos=$this->model->getDetallePermisos($id_decrip);
                    $data['asignados']=array();
                    foreach($permisos as $permiso){
                        $data['asignados'][$permiso['id_permiso']]=true;
                    }
                    $data['id_usuario']=$id;
                    $this->views->getView($this,"permisos",$data);
                }
                else{
                    header('Location:'.base_url.'Usuarios');
                }
            } 
        }   
    }

    public function registrarPermiso(){
        $id_user= $_POST['id_usuario'];     
        $id_decrip = $this->decryptId($id_user);     
        
        $eliminar= $this->model->elimiarPermisos( $id_decrip);     
        if($eliminar == 'ok'){
            if(!empty($_POST ['permisos'])){
                foreach($_POST ['permisos'] as $id_permiso ){
                    $msg=$this->model->registrarPermisos($id_decrip,$id_permiso);
                }
                if($msg=='ok'){
                    $msg=array('ico'=>'success','msg'=> 'permisos asignados');
                }else{
                    $msg='Error al error al asignar los permisos';
                }
            }
            else{
                $msg=array('ico'=>'success','msg'=> 'Todos los permisos retirados');
            }
            // foreach($_POST ['permisos'] as $id_permiso ){
            //     $msg=$this->model->registrarPermisos($id_decrip,$id_permiso);
            // }
           
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
        $_SESSION['rol']='laputie';
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }
    
}
?>

