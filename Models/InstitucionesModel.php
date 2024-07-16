<?php
    class InstitucionesModel extends Query{
        private $id,$institucion,$estado;
  
        public function __construct(){
            parent::__construct();
        }                 
        public function getInstituciones(){
            $sql="SELECT * FROM instituciones ORDER BY id DESC";
            $data= $this->selectAll($sql);
            return $data;
           
        }
        public function registrarInstitucion(string $institucion){          
            $this->institucion=$institucion;
            $verificar ="SELECT *FROM instituciones WHERE institucion='$this->institucion'";
            $existe =$this->select($verificar);
            if(empty($existe)){
                $sql = "INSERT INTO instituciones (institucion) VALUES (?)";
                $datos =array($this->institucion);
                $data =  $this-> save($sql,$datos);
                if($data==1){
                    $res = "ok";
                }else{
                    $res = "error";
                }
            }else {
                $res ="existe";
            }
          
            return $res;

        }
        public function modificarInstitucion(string $institucion, int $id){

            $this->institucion=$institucion;
            $this->id=$id;
            $sql = "UPDATE instituciones SET institucion=? WHERE id=?";         
            $datos =array($this->institucion,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        
        }
        public function editarInstitucion(int $id){
            $sql = "SELECT * FROM instituciones WHERE id=$id";
            $data= $this->select($sql);
            return $data;
        }
        public function accionInstitucion (int $estado,int $id){
            $this->id = $id;
            $this->estado = $estado;
            $sql ="UPDATE instituciones SET estado =? WHERE id=?";          
            $datos=array($this->estado,$this->id);
            $data = $this->save($sql,$datos);

            $sql_suc ="UPDATE sucursales SET estado =? WHERE id_institucion=?";
            $datos_suc=array($this->estado,$this->id);
            $this->save($sql_suc,$datos_suc);

            return $data;
        }

        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=$id_user AND p.permiso='$nombre'";
            $data= $this-> selectAll($sql);
            return $data;
        }
    }
?> 
