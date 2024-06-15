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
        
        public function getVigilantes(){
            $sql="SELECT id,nombre as vigilante FROM usuarios WHERE estado = 1 and rol='vigilante'";
            $data= $this->selectAll($sql);
            return $data;
        }       
        
        public function getSucursales(){
            // $sql="SELECT s.*, i.id AS id_institucion, i.institucion 
            // FROM sucursales as s
            // INNER JOIN instituciones as i ON s.id_institucion = i.id
            // ORDER BY id DESC;";

            // $sql="SELECT s.*, i.id AS id_institucion, i.institucion, u.id AS id_vigilante,u.nombre as vigilante
            // FROM sucursales as s
            // INNER JOIN instituciones as i ON s.id_institucion = i.id
            // INNER JOIN usuarios as u ON s.id_vigilante = u.id
            // ORDER BY id DESC;";

            $sql="SELECT s.*, i.id AS id_institucion, i.institucion, u.id AS id_vigilante, u.nombre AS vigilante
            FROM sucursales AS s
            INNER JOIN instituciones AS i ON s.id_institucion = i.id
            LEFT JOIN usuarios AS u ON s.id_vigilante = u.id
            ORDER BY s.id DESC;";

            $data= $this->selectAll($sql);
            return $data;
        }


        public function registrarSucursal(string $sucursal,int $id_institucion,string $id_vigilante,string $ciudad,string $direccion){          
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
        
        public function modificarSucursal(string $sucursal,int $id_institucion,int $id_vigilante,string $ciudad,string $direccion, int $id){
            $this->sucursal=$sucursal;
            $this->id_institucion=$id_institucion;
            $this->id_vigilante=$id_vigilante;
            $this->ciudad=$ciudad;
            $this->direccion=$direccion;
            $this->id=$id;

            $updateVi = "UPDATE sucursales SET id_vigilante = NULL WHERE id_vigilante = ?";
            $dataVi = array($this->id_vigilante);
            $this->save($updateVi, $dataVi);
            
            $sql = "UPDATE sucursales SET sucursal=?,id_institucion=?,id_vigilante=?,ciudad=?,direccion=? WHERE id=?"; 
            $datos =array( $this->sucursal,$this->id_institucion,$this->id_vigilante,$this->ciudad,$this->direccion,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        }
        public function editarSucursal(int $id){
            $sql = "SELECT * FROM sucursales WHERE id=$id";
            $data= $this->select($sql);
            return $data;
        }

 
  
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
