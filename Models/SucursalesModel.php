<?php
    class SucursalesModel extends Query{
        private $id,$sucursal,$id_institucion,$id_vigilante,$ciudad,$direccion,$estado;
  
        public function __construct(){
            parent::__construct();
        }

   
        public function getInstituciones(){
            $sql="SELECT * FROM instituciones WHERE estado = 1";
            $data= $this->selectAll($sql);
            return $data;
        }           
        
        public function getSucursales(){
            $sql="SELECT s.*, i.id AS id_institucion, i.institucion 
            FROM sucursales as s
            INNER JOIN instituciones as i ON s.id_institucion = i.id
            ORDER BY id DESC;";
            $data= $this->selectAll($sql);
            return $data;
        }


        public function registrarSucursal(string $sucursal,string $id_institucion,string $id_vigilante,string $ciudad,string $direccion){          
            $this->sucursal=$sucursal;
            $this->id_institucion=$id_institucion;
            $this->id_vigilante=$id_vigilante;
            $this->ciudad=$ciudad;
            $this->direccion=$direccion;
            $verificar ="SELECT *FROM sucursales WHERE sucursal='$this->sucursal'";
            $existe =$this->select($verificar);
            if(empty($existe)){
                $sql = "INSERT INTO sucursales (sucursal,id_institucion,id_vigilante,ciudad,direccion) VALUES (?,?,?,?,?)";
                $datos =array($this->sucursal,$this->id_institucion,$this->id_vigilante,$this->ciudad,$this->direccion);
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
        // public function modificarInstitucion(string $institucion, int $id){

        //     $this->institucion=$institucion;
        //     $this->id=$id;
        //     $sql = "UPDATE instituciones SET institucion=? WHERE id=?";         
        //     $datos =array($this->institucion,$this->id);
        //     $data =  $this-> save($sql,$datos);
        //     if($data==1){
        //         $res = "modificado";
        //     }else{
        //         $res = "error";
        //     }
        //     return $res;
        
        // }
        // public function editarInstitucion(int $id){
        //     $sql = "SELECT * FROM instituciones WHERE id=$id";
        //     $data= $this->select($sql);
        //     return $data;
        // }

 
  
        public function accionInstitucion (int $estado,int $id){
            $this->id = $id;
            $this->estado = $estado;
            $sql ="UPDATE sucursales SET estado =? WHERE id=?";
            $datos=array($this->estado,$this->id);
            $data = $this->save($sql,$datos);
            return $data;
        }
    }
?> 
