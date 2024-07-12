<?php
class Proyectos extends Controller{   
    public function __construct(){
        session_start();          
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }    
        parent::__construct();
    }
    
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }     
        $id_user= $_SESSION['id_usuario'];
        $verificar =    $this->model ->verificarPermiso($id_user,'materiales');
        if(!empty ($verificar)){
            $type = $_GET['view'];
            $data['instituciones']=$this->model->getInstituciones();
            $data['vista']=$type;
            $this->views->getView($this, "index", $data);
        }
        else{
            header('Location:'.base_url.'Errors');
        }
    }
    public function perrie(){
        // print_r( $this->instituciones);
        print_r('hola mundo');
    }

    public function listar(){
        $data= $this->model->getInstituciones();       
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>


