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
                $data['sucursales'] =  $this->model->getSucursales($id_institucion);   
                $data['vigilantes']= $this->model->getVigilantes($id_institucion);   
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

    public function registrar(){
        $id_sucursal= $_POST['id_sucursal'];      
        $id_vigilante= $_POST['id_vigilante']; 
        
        
        $puntualidad= $_POST['puntualidad'];   
        $pres_per= $_POST['pres_per'];   
        $patrulla= $_POST['patrulla'];   
        $epp= $_POST['epp'];  
        $libro= $_POST['libro'];   
        $verif_vehi= $_POST['verif_vehi'];   
        $id= $_POST['id'];     
   

        // $vigilantes_arr = implode(',', $vigilante);
        $msg="asd00";
        // if(empty($sucursal)||empty($institucion)||empty($vigilante) ||empty($ciudad) ||empty($direccion)){
        //     $msg= "Todos los campos son obligatorios";
        // }else{
        //     if($id==""){       
        //         $data= $this->model->registrarSucursal($sucursal,$institucion,$vigilantes_arr,$ciudad,$direccion);
        //         if($data=="ok"){
        //             $msg ="si";
        //         }else if($data=="existe") {
        //             $msg ="La sucursal ya se encuentra registrada";
        //         }else{
        //             $msg=$data;
        //         }
        //     }else{       
        //         $data= $this->model->modificarSucursal($sucursal,$institucion,$vigilantes_arr,$ciudad,$direccion,$id);
        //         if($data=="modificado"){
        //             $msg ="modificado";
        //         }else{
        //             $msg="Error al modificar la sucursal";
                    
        //         }      
        //     }  
        // }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }






}
?>


