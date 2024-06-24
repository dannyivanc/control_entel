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
        $data['instituciones']=$this->model->getInstituciones();
        $data['vigilantes']=$this->model->getVigilantes();
        $this->views->getView($this,"index",$data);
    }

    

    

}
?>  

