<?php
    class MaterialesModel extends Query{
        public function __construct(){
            parent::__construct();
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
        public function getMateriales(int $id_suc){
            $sql="SELECT * FROM materiales WHERE id_sucursal = ? and estado = 1 
            ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_suc]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
        
        public function registrarMaterial(string $fecha,string $movimiento,string $persona,string $destino,string $descripcion,int $cantidad, string $observacion,int $id_sucursal,int $id_vigilante){    
            list($fecha_registro, $hora_registro) = explode('T', $fecha);
            $fecha_final = $fecha_registro . ' ' . substr($hora_registro, 0, 5) . ':00';
            $sql = "INSERT INTO materiales (fecha,movimiento,persona,destino,descripcion,cantidad,observacion,id_vigilante,id_sucursal) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$fecha_final,$movimiento,$persona,$destino,$descripcion,$cantidad,$observacion,$id_vigilante,$id_sucursal]);
            $data =  $stmt->rowCount();
            if($data==1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }
        public function modificarMaterial(string $fecha,string $movimiento,string $persona,string $destino,string $descripcion,int $cantidad,string $observacion,int $id_vigilante,int $id){
            list($fecha_registro, $hora_registro) = explode('T', $fecha);
            $fecha_final = $fecha_registro . ' ' . substr($hora_registro, 0, 5) . ':00';
            $sql = "UPDATE materiales SET fecha=?,movimiento=?,persona=?,destino=?,descripcion=?,cantidad=?,observacion=?,id_vigilante=? WHERE id=?"; 
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$fecha_final,$movimiento,$persona,$destino,$descripcion,$cantidad,$observacion,$id_vigilante,$id]);
            $data = $stmt->rowCount();
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        }
        public function editarMaterial(int $id){
            $sql = "SELECT * FROM materiales WHERE id=?";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
        public function accionMaterial (int $id){
            $verificar ="SELECT *FROM materiales WHERE id=? ";       
            $stmt = $this->conect->prepare($verificar);
            $stmt->execute([$id]);
            $existe = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($existe)){
                $sql ="UPDATE materiales SET estado =? WHERE id=?";
                $stmt = $this->conect->prepare($sql);
                $stmt->execute([0,$id]);
                $data = $stmt->rowCount();
                if($data==1){
                    $res = "ok";
                }else{
                    $res = "error";
                }
            }else {
                $res ="vacio";
            }
            return $res;
        }
        
        public function getSucursalOthers(int $id){
            $sql="SELECT su.id,su.sucursal,su.id_institucion,inst.institucion  FROM sucursales as su
            INNER JOIN instituciones as inst ON inst.id=su.id_institucion
            WHERE su.id =?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
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
