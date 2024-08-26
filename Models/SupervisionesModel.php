<?php
    class SupervisionesModel extends Query{
        public function __construct(){
            parent::__construct();
        }

        public function getInstitucion(int $id){
            $sql="SELECT * FROM instituciones WHERE id=?";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }    
      
        public function getSucursales(int $id){
            $sql="SELECT * FROM sucursales WHERE id_institucion=? ORDER BY id DESC";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;      
        }

        public function getVigilantes(int $id){
            $sql="SELECT u.id AS id_vigilante, u.nombre AS vigilante
            FROM sucursales AS su
            INNER JOIN suc_vig AS sv ON su.id = sv.id_sucursal
            INNER JOIN usuarios AS u ON sv.id_vigilante = u.id
            WHERE su.id_institucion =?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;   
        }   

        public function listarSupervisiones(int $id){
            $sql=" SELECT su.id, su.fecha, su.puntualidad, su.pres_per, su.patrulla, su.epp, su.libro, su.verif_vehi, us.nombre AS id_vigilante, sucursales.sucursal AS id_sucursal
            FROM supervision AS su
            INNER JOIN usuarios AS us ON us.id = su.id_vigilante
            INNER JOIN sucursales ON sucursales.id = su.id_sucursal
            INNER JOIN instituciones ON instituciones.id = sucursales.id_institucion
            WHERE instituciones.id = ?
            AND su.fecha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            ORDER BY su.id DESC";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;    
        }

        public function getSucursal(int $id){
            $sql="SELECT su.id,su.sucursal,su.id_institucion,inst.institucion  FROM sucursales as su
            INNER JOIN instituciones as inst ON su.id_institucion = inst.id
            INNER JOIN suc_vig ON su.id = suc_vig.id_sucursal
            WHERE suc_vig.id_vigilante =?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            return $data;   
        }   
               
        public function getMateriales(int $id_suc){
            $sql="SELECT * FROM materiales
            WHERE id_sucursal =? and estado = 1 
            and MONTH(fecha) = MONTH(CURRENT_DATE())
            and YEAR(fecha) = YEAR(CURRENT_DATE())
            ORDER BY id DESC";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id_suc]);
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;   
        }
        
        public function registrarSupervision(string $fecha,float $lat,float $lng,string $puntualidad,string $pres_per,string $patrulla,string $epp,string $libro,string $verif_vehi,int $id_sucursal,int $id_supervisor,int $id_vigilante){    
            $sql = "INSERT INTO supervision (fecha,lat,lng,puntualidad,pres_per,patrulla,epp,libro,verif_vehi,id_sucursal,id_supervisor,id_vigilante) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([$fecha,$lat,$lng,$puntualidad,$pres_per,$patrulla,$epp,$libro,$verif_vehi,$id_sucursal,$id_supervisor,$id_vigilante]);
            $data = $stmt->rowCount();
            if($data==1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        public function modificarSupervision(string $puntualidad,string $pres_per,string $patrulla,string $epp,string $libro,string $verif_vehi,int $id_sucursal,int $id_vigilante,int $id){
            $sql = "UPDATE supervision SET puntualidad=?,pres_per=?,patrulla=?,epp=?,libro=?,verif_vehi=?,id_sucursal=?,id_vigilante=? WHERE id=?"; 
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$puntualidad,$pres_per,$patrulla,$epp,$libro,$verif_vehi,$id_sucursal,$id_vigilante,$id]);
            $data=$stmt->rowCount();
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        }

        public function editarSupervision(int $id){
            $sql = "SELECT * FROM supervision WHERE id=?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
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
