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

        public function cambiarVigilante(int $id_vigilante,int $id_sucursal){
            $this->id_vigilante=$id_vigilante;
            $this->sucursal=$id_sucursal;
            $sql = "DELETE FROM suc_vig WHERE id_vigilante=?";
            $datos =array($id_vigilante);
            $this-> save($sql,$datos);
            $sqlsuc_vib = "INSERT INTO suc_vig (id_sucursal,id_vigilante) VALUES (?,?)";
            $datos_suc_vig= array($this->sucursal, $this->id_vigilante);
            $this-> save($sqlsuc_vib,$datos_suc_vig);  
        }


        public function registrarSucursal(string $sucursal, int $id_institucion, string $ciudad, string $direccion) {
                $res='';
                $this->sucursal=$sucursal;
                $this->id_institucion=$id_institucion;
                $this->ciudad=$ciudad;
                $this->direccion=$direccion;
                $verificar ="SELECT * FROM sucursales WHERE sucursal='$this->sucursal' AND id_institucion='$this->id_institucion' ";
                $existe =$this->select($verificar);
                if(empty($existe)){
                    $sqlsuc = "INSERT INTO sucursales (sucursal,id_institucion,ciudad,direccion) VALUES (?,?,?,?)";
                    $datos= array($this->sucursal, $this->id_institucion, $this->ciudad, $this->direccion);
                    $data =  $this-> save($sqlsuc,$datos);       
                    if(!empty($data)){             
                        $sqlLastId = "SELECT id FROM sucursales ORDER BY id DESC LIMIT 1;";
                        $id= $this->select($sqlLastId);
                        $res =$id['id']; ;
                    }else{
                        $res = "error";
                    }  
                }
                else{
                    $res ="existe";
                }
                return $res;
        }

        public function modificarSucursal(string $sucursal,int $id_institucion,string $ciudad,string $direccion, int $id){
            $this->sucursal=$sucursal;
            $this->id_institucion=$id_institucion;
            $this->ciudad=$ciudad;
            $this->direccion=$direccion;
            $this->id=$id;
            $sql = "UPDATE sucursales SET sucursal=?,id_institucion=?,ciudad=?,direccion=? WHERE id=?"; 
            $datos =array( $this->sucursal,$this->id_institucion,$this->ciudad,$this->direccion,$this->id);
            $datasuc =  $this-> save($sql,$datos);
            if(!empty($datasuc)){
                $sql_del = "DELETE FROM suc_vig WHERE id_sucursal=?";
                $datos_del =array($id);                    $this-> save($sql_del,$datos_del); 
                $res = "modificado";
            }else{
                $res ="error";
            }
            return $res;            
        }
         public function editarSucursal(int $id){
            $sql = "SELECT * FROM sucursales WHERE id=$id";
            $sql2 = "SELECT s_v.id_vigilante as id  , us.nombre as vigilante FROM suc_vig as s_v INNER JOIN usuarios as us ON s_v.id_vigilante=us.id WHERE s_v.id_sucursal=$id";
            $data['sucursal']= $this->select($sql);
            $data['vigilantes']= $this->selectall($sql2);                
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
