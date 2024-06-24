<?php
class Supervisiones extends Controller{
    private $institucionInfo;
    public function __construct(){
        session_start();          
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }    
        parent::__construct();


        // $id = $_SESSION['id_usuario'];
        // $sucursal= $this->model->getSucursal($id);
        // $this->sucursalInfo=$sucursal;
        
       
    }
    // public function verInstitucion() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_institucion'])) {
    //         $id_institucion = $_POST['id_institucion'];
    //         // Supongamos que tienes una función en el modelo para obtener los datos de la institución por ID
    //         $institucion_data = $this->model->getInstitucion($id_institucion);

    //         if (!empty($institucion_data)) {
    //             // $data['institucion'] = $institucion_data;
    //             $this->institucionInfo= $institucion_data;
    //             // $this->views->getView($this, "verInstitucion", $data);
    //         } else {
    //             // Redirigir a una página de error o a la lista principal si no hay un ID válido
    //             header('Location: '.base_url.'Supervisiones');
    //             exit();
    //         }
    //     } else {
    //         // Redirigir a la lista principal si no hay un ID válido
    //         header('Location: '.base_url.'Supervisiones');
    //         exit();
    //     }
    // }
    public function index(){
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
        }      
      
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_institucion'])) {
            $id_institucion = $_POST['id_institucion'];
            // Supongamos que tienes una función en el modelo para obtener los datos de la institución por ID
            $institucion_data = $this->model->getInstitucion($id_institucion);
            $this->institucionInfo= $institucion_data;
            if (!empty($institucion_data)) {
                $data['institucion'] =  $institucion_data;
                // $this->institucionInfo= $institucion_data;
                $this->views->getView($this, "index", $data);
            } else {
                // Redirigir a una página de error o a la lista principal si no hay un ID válido
                header('Location: '.base_url.'Proyectos');
                exit();
            }
        } 
        else {
            // Redirigir a la lista principal si no hay un ID válido
            header('Location: '.base_url.'Proyectos');
            exit();
        }


    }

    public function perrie(){
        print_r($_SESSION['id_usuario']);
        print_r('---');
        print_r($this->institucionInfo);
    }

}
?>


