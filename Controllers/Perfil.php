<?php
class Perfil extends Controller{
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

    public function verPerfil(){
        $data= $this->model->getPerfil();   
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

    
    public function changePass(){
        $id= $_POST['modal-id'];
        $verif= $_POST['modal-clave'];
        $actual= $_POST['clave-act'];
        $nueva= $_POST['clave-new'];    
        $repetir= $_POST['clave-rep'];
        $hash=hash("SHA256",$actual);   
        $hashNuevo=hash("SHA256",$nueva);   
        if(empty($actual)||empty($nueva)||empty($repetir)){
            $msg=  "Todos los campos son obligatorios";
        }else{
            if($hash!=$verif){
                $msg="La contraseña actual es incorrecta";
            }
            else{               
                $data= $this->model->modificarPerfilPass($hashNuevo,$id);
                if($data=="modificado"){
                    $msg ="modificado";
                }else{
                    $msg="Error al modificar clave";
                }

            }
           
                
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }
}
}
?>

