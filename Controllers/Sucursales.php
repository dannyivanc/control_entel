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
        $msg='';
        $sucursal= $_POST['sucursal'];      
        $institucion= $_POST['institucion'];   
        $vigilantes= $_POST['vigilante'];   
        $ciudad= $_POST['ciudad'];   
        $direccion= $_POST['direccion'];   
        $id= $_POST['id'];     
        // $ids = array_map('intval', explode(",", $vigilante)); 
                // $msg=$this->model->registrarPermisos($id_vigilante,$id);
            if($id==""){  
                $data= $this->model->registrarSucursal($sucursal,$institucion,$ciudad,$direccion); 
                print_r($data);
                // if($data=="ok"){
                //     $msg ="si";
                // }else if($data=="existe") {
                //     $msg ="La sucursal ya se encuentra registrada";
                //     }else{
                //     $msg=$data;
                // }
                foreach( $vigilantes as $vigilante ){
                    $this->model->elimiarVigilante( $vigilante);    
                }
        
             
              
                // if($data=="ok"){
                //     $msg ="si";
                // }else if($data=="existe") {
                //     $msg ="La sucursal ya se encuentra registrada";
                //     }else{
                //     $msg=$data;
                // }
            }
            // else{       
            //     $data= $this->model->modificarSucursal($sucursal,$institucion,$ciudad,$direccion,$id);
            //     if($data=="modificado"){
            //             $msg ="modificado";
            //    }else{
            //         $msg="Error al modificar la sucursal";
                            
            //     }      
            // } 
            
            // if($msg=='ok'){
            //     $msg=array('ico'=>'success','msg'=> 'permisos asignados');
            // }else{
            //     $msg='Error al error al asignar los permisos';
            // }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        
        



        // $vigilantes_arr = implode(',', $vigilante);        
        // if(empty($sucursal)||empty($institucion)||empty($vigilante) ||empty($ciudad) ||empty($direccion)){
        //     $msg= "Todos los campos son obligatorios";
        //     // $msg=array('ico'=>'success','msg'=> 'permisos asignados');
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
        // echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar (int $id){
      $data=$this->model->editarSucursal($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function desactivar(int $id){
        $data=$this->model ->accionInstitucion(0,$id);
       if($data==1){
        $msg="ok";
       }else{
        $msg="Error al desactivar usuario";
       }
       echo json_encode($msg,JSON_UNESCAPED_UNICODE);
       die();
    }
    
    public function activar(int $id){
        $data=$this->model ->accionInstitucion(1,$id);
       if($data==1){
        $msg="ok";
       }else{
        $msg="Error al activar usuario";
       }
       echo json_encode($msg,JSON_UNESCAPED_UNICODE);
       die();
    }

    public function salir(){
        session_destroy();
        header("location:".base_url);
    }
}
?>  

