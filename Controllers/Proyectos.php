<?php
class Proyectos extends Controller{
    private $instituciones;
    public function __construct(){
        session_start();          
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }    
        parent::__construct();
        // $inst= $this->model->getInstituciones();
        // $this->instituciones=$inst;
    }
    
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }      
        $data=$this->model->getInstituciones();

        $this->views->getView($this, "index", $data);
    }
    public function perrie(){
        // print_r( $this->instituciones);
        print_r('hola mundo');
    }

    public function listar(){
        $data= $this->model->getInstituciones();       
        
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;         
            $data[$i]['estado']='<span class="badge  bg-success">Activo</span>';
            

        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>


