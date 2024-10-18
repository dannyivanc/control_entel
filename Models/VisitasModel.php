<?php
    class VisitasModel extends Query{ 
        public function __construct(){
            parent::__construct();
        }
        public function getSucursal(int $id){
            $sql="SELECT su.id,su.sucursal,su.id_institucion,inst.institucion  
            FROM sucursales as su
            INNER JOIN instituciones as inst ON su.id_institucion = inst.id
            INNER JOIN suc_vig ON su.id = suc_vig.id_sucursal
            WHERE suc_vig.id_vigilante = ?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }    
      
        public function getVisitas(int $id_suc){
            $sql="SELECT * FROM visitas 
            WHERE id_sucursal=? and estado=?
            ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_suc,1]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function registrarVisita(string $ingreso,string $salida,string $nombre,string $carnet,string $detalle,int $id_sucursal,int $id_vigilante){    
            list($fecha_ingreso, $hora_ingreso) = explode('T', $ingreso);
            list($fecha_salida, $hora_salida) = explode('T', $salida);            
            $ingreso_f = $fecha_ingreso . ' ' . substr($hora_ingreso, 0, 5) . ':00';
            $salida_f = $fecha_salida . ' ' . substr($hora_salida, 0, 5) . ':00';     
            
            $sql = "INSERT INTO visitas (ingreso,salida,nombre,carnet,detalle,id_sucursal,id_vigilante) VALUES (?,?,?,?,?,?,?)";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$ingreso_f, $salida_f, $nombre, $carnet, $detalle, $id_sucursal, $id_vigilante]);
            $data= $stmt->rowCount();            
            if($data==1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        public function modificarVisita(string $ingreso,string $salida,string $nombre,string $carnet,string $detalle,int $id_vigilante,int $id){
            list($fecha_ingreso, $hora_ingreso) = explode('T', $ingreso);
            list($fecha_salida, $hora_salida) = explode('T', $salida);            
            $ingreso_f = $fecha_ingreso . ' ' . substr($hora_ingreso, 0, 5) . ':00';
            $salida_f = $fecha_salida . ' ' . substr($hora_salida, 0, 5) . ':00';           
            $sql = "UPDATE visitas SET ingreso=?,salida=?,nombre=?,carnet=?,detalle=?,id_vigilante=? WHERE id=?"; 
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$ingreso_f, $salida_f, $nombre, $carnet, $detalle, $id_vigilante, $id]);
            $data= $stmt->rowCount(); 
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        }
        public function editarVisita(int $id){
            $sql = "SELECT * FROM visitas WHERE id=?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        public function accionVisita (int $id){
            $verificar ="SELECT *FROM visitas WHERE id=? AND salida!= '0000-00-00 00:00:00'";  
            $stmt_ver = $this->conect->prepare($verificar);
            $stmt_ver->execute([$id]);   
            $existe=$stmt_ver->fetchAll(PDO::FETCH_ASSOC);    
            if(!empty($existe)){
                $sql ="UPDATE visitas SET estado =? WHERE id=?";
                $stmt = $this->conect->prepare($sql);
                $stmt->execute([0,$id]);   
                $data=$stmt->rowCount();
                if($data==1){
                    $res = "ok";
                }else{
                    $res = "error";
                }
            }else {
                $res ="void";
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
