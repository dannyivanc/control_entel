<?php
    class SucursalesModel extends Query{
        private $id,$sucursal,$id_institucion,$id_vigilante,$ciudad,$direccion,$estado;
        private $conn;
  
        public function __construct(){
            parent::__construct();
            $this->conn = new mysqli(host, user, pass, db);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset(charset);
          
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
            $sql="SELECT s.*, i.id AS id_institucion, i.institucion,
                  GROUP_CONCAT(u.nombre SEPARATOR ', ') AS vigilante
            FROM 
                sucursales AS s
                INNER JOIN instituciones AS i ON s.id_institucion = i.id
                LEFT JOIN suc_vig AS sv ON s.id = sv.id_sucursal
                LEFT JOIN usuarios AS u ON sv.id_vigilante = u.id
            GROUP BY 
                s.id, i.id
            ORDER BY 
                s.id DESC" ;  
                
            $data= $this->selectAll($sql);
            return $data;

        }
        public function registrarSucursal(string $sucursal, int $id_institucion, string $id_vigilante, string $ciudad, string $direccion) {
            $this->sucursal=$sucursal;
            $this->id_institucion=$id_institucion;
            $this->id_vigilante=$id_vigilante;
            $this->ciudad=$ciudad;
            $this->direccion=$direccion;

            $verificar ="SELECT *FROM sucursales WHERE sucursal='$this->sucursal'";
            $existe =$this->select($verificar);
            if(empty($existe)){
                $sqlsuc = "INSERT INTO sucursales (sucursal,id_institucion,ciudad,direccion) VALUES (?,?,?,?)";
                $stmt = $this-> conn->prepare($sqlsuc);
                $stmt->bind_param("siss", $sucursal, $id_institucion, $ciudad, $direccion);
                $stmt->execute();
                $data = $this-> conn->insert_id;

                $ids = array_map('intval', explode(",", $id_vigilante)); 
                foreach ($ids as $valor) {
                    $sql_suc_vig = "DELETE FROM suc_vig WHERE id_vigilante = $valor";                    
                    $this->conn->query($sql_suc_vig);

                    $sql_reg = "INSERT INTO suc_vig (id_sucursal,id_vigilante ) VALUES (?,?)";
                    $datos_Reg =array($data,$valor);
                    $this-> save($sql_reg,$datos_Reg);
                }                
                if(!empty($data)){
                    $res = "ok";
                }else{
                    $res = "error";
                }  
            }
            else {
                $res ="existe";
            }
            return $res;

        }

        public function modificarSucursal(string $sucursal,int $id_institucion,string $id_vigilante,string $ciudad,string $direccion, int $id){
            $this->sucursal=$sucursal;
            $this->id_institucion=$id_institucion;
            $this->id_vigilante=$id_vigilante;
            $this->ciudad=$ciudad;
            $this->direccion=$direccion;
            $this->id=$id;
            $sql = "UPDATE sucursales SET sucursal=?,id_institucion=?,ciudad=?,direccion=? WHERE id=?"; 
            $datos =array( $this->sucursal,$this->id_institucion,$this->ciudad,$this->direccion,$this->id);
            $datasuc =  $this-> save($sql,$datos);
            $ids = array_map('intval', explode(",", $id_vigilante)); 
            foreach ($ids as $valor) {
             

                $sql_suc_vig = "DELETE FROM suc_vig WHERE id_vigilante = $valor";                    
                $this->conn->query($sql_suc_vig);

                $sql_reg = "INSERT INTO suc_vig (id_sucursal,id_vigilante ) VALUES (?,?)";
                $datos_Reg =array($id,$valor);
                $this-> save($sql_reg,$datos_Reg);              
            } 

            if(!empty($datasuc)){
                $res = "modificado";
            }else{
                $res ="error";
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
