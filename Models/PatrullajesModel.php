<?php
    class PatrullajesModel extends Query{
        public function __construct(){
            parent::__construct();
        }

        public function getInstitucion(int $id){
            $sql="SELECT * FROM instituciones WHERE id =?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }    
        
        public function getSucursales(int $id){
            $sql="SELECT * FROM sucursales WHERE id_institucion=? ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
 
        public function listarPatrullajes(int $id){
            $sql=" SELECT pa.id, pa.fecha,pa.descripcion, us.nombre AS id_supervisor, sucursales.sucursal AS id_sucursal
            FROM patrullaje AS pa
            INNER JOIN usuarios AS us ON us.id = pa.id_supervisor
            INNER JOIN sucursales ON sucursales.id = pa.id_sucursal
            INNER JOIN instituciones ON instituciones.id = sucursales.id_institucion
            WHERE instituciones.id =?
            AND pa.fecha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            ORDER BY pa.id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function getSucursal(int $id){
            $sql="SELECT su.id,su.sucursal,su.id_institucion,inst.institucion  FROM sucursales as su
            INNER JOIN instituciones as inst ON su.id_institucion = inst.id
            INNER JOIN suc_vig ON su.id = suc_vig.id_sucursal
            WHERE suc_vig.id_vigilante =?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }           

        public function registrarPatrullaje(string $fecha,float $lat,float $lng,string $descripcion,int $id_sucursal,int $id_supervisor){    
            $sql = "INSERT INTO patrullaje (fecha,lat,lng,descripcion,id_sucursal,id_supervisor) VALUES (?,?,?,?,?,?)";
            $stmt = $this->conect->prepare($sql);
            $stmt-> execute([$fecha,$lat,$lng,$descripcion,$id_sucursal,$id_supervisor]);
            $data = $stmt->rowCount();
            if($data==1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        public function modificarPatrullaje(string $descripcion,int $id_sucursal,int $id){
            $sql = "UPDATE patrullaje SET descripcion=?,id_sucursal=? WHERE id=?"; 
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$descripcion,$id_sucursal,$id]);
            $data = $stmt->rowCount();
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        }


        public function editarPatrullaje(int $id){
            $sql = "SELECT * FROM patrullaje WHERE id=?";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data= $stmt->fetch(PDO::FETCH_ASSOC);
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
