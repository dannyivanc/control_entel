<?php
    class SucursalesModel extends Query{
        public function __construct(){
            parent::__construct();
  
          
        }
        public function getInstituciones(){
            $sql="SELECT * FROM instituciones WHERE estado = 1";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute();
            $data= $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }      
        
        public function getVigilantes(){
            $sql="SELECT id,nombre as vigilante FROM usuarios WHERE estado = 1 and rol='vigilante'";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute();
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }       
        
        public function getSucursales(){ 
            $sql="SELECT s.*, i.id AS id_institucion, i.institucion,
                  GROUP_CONCAT(u.nombre SEPARATOR ', ') AS vigilante
            FROM sucursales AS s
                INNER JOIN instituciones AS i ON s.id_institucion = i.id
                LEFT JOIN suc_vig AS sv ON s.id = sv.id_sucursal
                LEFT JOIN usuarios AS u ON sv.id_vigilante = u.id
            GROUP BY s.id, i.id
            ORDER BY s.id DESC" ;        
            $stmt=$this->conect->prepare($sql);
            $stmt->execute();
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;

        } 

     


        public function registrarSucursal(string $sucursal, int $id_institucion, string $ciudad, string $direccion) {
                $res='';
                $verificar ="SELECT * FROM sucursales WHERE sucursal=? AND id_institucion=? ";
                $stmt_ver= $this->conect->prepare($verificar);
                $stmt_ver->execute([$sucursal,$id_institucion]);
                $existe = $stmt_ver->fetch(PDO::FETCH_ASSOC);
                if(empty($existe)){
                    $sqlsuc = "INSERT INTO sucursales (sucursal,id_institucion,ciudad,direccion) VALUES (?,?,?,?)";
                    $stmt=$this->conect->prepare($sqlsuc);
                    $stmt->execute([$sucursal, $id_institucion, $ciudad, $direccion]);

                    $lastId = $this->conect->lastInsertId();
                    $sql = "SELECT * FROM sucursales WHERE id = ?";
                    $stmt2 = $this->conect->prepare($sql);
                    $stmt2->execute([$lastId]);
                    $data = $stmt2->fetch(PDO::FETCH_ASSOC);
                    $res=$data['id'];
                }
                else{
                    $res = 'error';
                }
                return $res;
        }
        
        public function cambiarVigilante(int $id_vigilante,int $id_sucursal){
            $sql = "DELETE FROM suc_vig WHERE id_vigilante=?";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([$id_vigilante]);       
            $sqlsuc_vib = "INSERT INTO suc_vig (id_sucursal,id_vigilante) VALUES (?,?)";
            $stmt2= $this->conect->prepare($sqlsuc_vib);
            $stmt2->execute([$id_sucursal,$id_vigilante]);
           
        }

        public function modificarSucursal(string $sucursal,int $id_institucion,string $ciudad,string $direccion, int $id){            
            $sql = "UPDATE sucursales SET sucursal=?,id_institucion=?,ciudad=?,direccion=? WHERE id=?"; 
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([$sucursal,$id_institucion,$ciudad,$direccion,$id]);
            $sql_del = "DELETE FROM suc_vig WHERE id_sucursal=?";
            $stmt2= $this->conect->prepare($sql_del);
            $stmt2->execute([$id]);
            $res='modificado';            
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
            $sql ="UPDATE sucursales SET estado =? WHERE id=?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$estado, $id]);
            $data = $stmt->rowCount();
            return $data;
        }
        
        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=? AND p.permiso=?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_user,$nombre]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }

        
?> 
