<?php
class Perfil extends Controller{
    public function __construct(){
        session_start();              
        parent::__construct();
    }
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
            exit;
        }
        $this->views->getView($this,"index");
        exit;
    }

    public function verPerfil(){
        $data= $this->model->getPerfil();   
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function changePass(){
        $id= $_POST['modal-id'];
        $actual= $_POST['clave-act'];
        $nueva= $_POST['clave-new'];    
        $repetir= $_POST['clave-rep'];
        $hash=hash("SHA256",$actual);   
        $hashNuevo=hash("SHA256",$nueva);   
        if(empty($actual)||empty($nueva)||empty($repetir)){
            $msg=array('ico'=>'error','msg'=>'Todos los campos son obligatorios');
        }else{               
                $data= $this->model->modificarPerfilPass($hash,$hashNuevo,$id);
                if($data=="modificado"){
                    $msg=array('ico'=>'success','msg'=>'Modificado correctamente');
                }
                else if($data=="incorrecto"){
                    $msg=array('ico'=>'error','msg'=>'La clave actual es incorrecta');
                }
                else{
                    $msg=array('ico'=>'error','msg'=>'Error al modificar clave');
                }   


        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }
}
}
?>

