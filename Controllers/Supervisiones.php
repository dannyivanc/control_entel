<?php
class Supervisiones extends Controller{
    private $institucionInfo;
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_institucion'])) {
            $id_institucion = $_POST['id_institucion'];          
            $institucion_data = $this->model->getInstitucion($id_institucion);

            $this->institucionInfo= $institucion_data;
            if (!empty($institucion_data)) {
                $data['institucion'] =  $institucion_data;    
                $data['Sucursales'] =  $this->model->getSucursales($id_institucion);   
                $data['Vigilantes']= $this->model->GetVigilantes($id_institucion);   
                $this->views->getView($this, "index", $data);
            } else {
                header('Location: '.base_url.'Proyectos');
                exit();
            }
        } 
        else {          
            header('Location: '.base_url.'Proyectos');
            exit();
        }
    }

    public function perrie(){
        print_r($_SESSION['id_usuario']);
        print_r('---');
        print_r($this->institucionInfo);
    }

    public function listar(){
        $data= $this->model->getSucursales();   
   
        for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['index']=$i+1;
            $btnEditar= '<button class="btn btn-primary me-1" type="button" onClick="btnEditarSucursal('.$data[$i]['id'].')"> <i class="fas fa-edit"></i> </button>';
            $btnDesactivar = '<button class="btn btn-danger" type="button" onClick="btnDesactivarSucursal('.$data[$i]['id'].')"> <i class="fas fa-ban"></i> </button>';
            $btnActivar= '<button class="btn btn-success" type="button" onClick="btnActivarSucursal('.$data[$i]['id'].')"> <i class="fas fa-check"></i> </button>';
            if($data[$i]['estado']==1){
                $data[$i]['estado']='<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = $btnEditar . $btnDesactivar;
            }else{
                $data[$i]['estado']='<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] =  $btnActivar;
            }
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>


