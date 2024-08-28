<?php
    class VehiculosModel extends Query{ 
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
      
        public function getVehiculos(int $id_suc){
            $sql="SELECT * FROM vehiculos 
            WHERE id_sucursal=? and estado=?
            ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_suc,1]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
        
        public function registrarVehiculo(string $salida,string $retorno,string $tipo,string $placa,int $km_salida,int $km_retorno,string $conductor,string $destino,int $id_sucursal,int $id_vigilante){    
            list($fecha_salida, $hora_salida) = explode('T', $salida);
            list($fecha_retorno, $hora_retorno) = explode('T', $retorno);            
            $salida_f = $fecha_salida . ' ' . substr($hora_salida, 0, 5) . ':00';
            $retorno_f = $fecha_retorno . ' ' . substr($hora_retorno, 0, 5) . ':00';        
            $sql = "INSERT INTO vehiculos (salida,retorno,tipo,placa,km_salida,km_retorno,conductor,destino,id_vigilante,id_sucursal) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$salida_f, $retorno_f, $tipo, $placa, $km_salida, $km_retorno, $conductor, $destino, $id_sucursal, $id_vigilante]);
            $data= $stmt->rowCount();            
            if($data==1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        public function modificarVehiculo(string $salida,string $retorno,string $tipo,string $placa,int $km_salida,int $km_retorno,string $conductor,string $destino,int $id_vigilante,int $id){
            list($fecha_salida, $hora_salida) = explode('T', $salida);
            list($fecha_retorno, $hora_retorno) = explode('T', $retorno);
            $salida_f = $fecha_salida . ' ' . substr($hora_salida, 0, 5) . ':00';
            $retorno_f = $fecha_retorno . ' ' . substr($hora_retorno, 0, 5) . ':00';          
            $sql = "UPDATE vehiculos SET salida=?,retorno=?,tipo=?,placa=?,km_salida=?,km_retorno=?,conductor=?,destino=?,id_vigilante=? WHERE id=?"; 
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$salida_f, $retorno_f, $tipo, $placa, $km_salida, $km_retorno, $conductor, $destino, $id_vigilante, $id]);
            $data= $stmt->rowCount(); 
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        }
        public function editarVehiculo(int $id){
            $sql = "SELECT * FROM vehiculos WHERE id=?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        public function accionVehiculo (int $id){
            $verificar ="SELECT *FROM vehiculos WHERE id=? AND retorno!= '0000-00-00 00:00:00' AND km_retorno != 0";  
            $stmt_ver = $this->conect->prepare($verificar);
            $stmt_ver->execute([$id]);   
            $existe=$stmt_ver->fetchAll(PDO::FETCH_ASSOC);    
            if(!empty($existe)){
                $sql ="UPDATE vehiculos SET estado =? WHERE id=?";
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

        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=? AND p.permiso=?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_user,$nombre]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data; 

        }
    }
?> 
