<?php
    class MaterialesModel extends Query{
        private $id,$fecha,$movimiento,$persona,$destino,$descripcion,$observacion,$id_sucursal,$id_vigilante;
  
        public function __construct(){
            parent::__construct();
        }
        public function getSucursal(int $id){
            $sql="SELECT su.id,su.sucursal,su.id_institucion,inst.institucion  FROM sucursales as su
            INNER JOIN instituciones as inst ON su.id_institucion = inst.id
            INNER JOIN suc_vig ON su.id = suc_vig.id_sucursal
            WHERE suc_vig.id_vigilante = $id";
            $data= $this->select($sql);
            return $data;
        }           
        public function getMateriales(int $id_suc){
            // $sql="SELECT *
            // FROM materiales 
            // WHERE id_sucursal = $id_suc and estado = 1
            // ORDER BY id DESC";
            $sql="SELECT *
            FROM materiales
            WHERE id_sucursal = $id_suc and estado = 1 
            and MONTH(fecha) = MONTH(CURRENT_DATE())
            and YEAR(fecha) = YEAR(CURRENT_DATE())
            ORDER BY id DESC";




            $data= $this->selectAll($sql);
            return $data;
        }
        
        public function registrarMaterial(string $fecha,string $movimiento,string $persona,string $destino,string $descripcion,string $observacion,int $id_sucursal,int $id_vigilante){    

            list($fecha_registro, $hora_registro) = explode('T', $fecha);
          
            $this->fecha = $fecha_registro . ' ' . substr($hora_registro, 0, 5) . ':00';
            $this->movimiento=$movimiento;
            $this->persona=$persona;
            $this->destino=$destino;
            $this->descripcion=$descripcion;
            $this->observacion=$observacion;       
            $this->id_vigilante=$id_vigilante;
            $this->id_sucursal=$id_sucursal;
            $sql = "INSERT INTO materiales (fecha,movimiento,persona,destino,descripcion,observacion,id_vigilante,id_sucursal) VALUES (?,?,?,?,?,?,?,?)";
            $datos =array($this->fecha,$this->movimiento,$this->persona,$this->destino,$this->descripcion,$this->observacion,$this->id_vigilante,$this->id_sucursal);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        public function modificarMaterial(string $fecha,string $movimiento,string $persona,string $destino,string $descripcion,string $observacion,int $id_vigilante,int $id){
            
            list($fecha_registro, $hora_registro) = explode('T', $fecha);
            $this->fecha = $fecha_registro . ' ' . substr($hora_registro, 0, 5) . ':00';
            $this->movimiento=$movimiento;
            $this->persona=$persona;
            $this->destino=$destino;
            $this->descripcion=$descripcion;
            $this->observacion=$observacion;       
            $this->id_vigilante=$id_vigilante;
            $this->id=$id;
            $sql = "UPDATE materiales SET fecha=?,movimiento=?,persona=?,destino=?,descripcion=?,observacion=?,id_vigilante=? WHERE id=?"; 
            $datos =array($this->fecha,$this->movimiento,$this->persona,$this->destino,$this->descripcion,$this->observacion,$this->id_vigilante,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        }
        public function editarMaterial(int $id){
            $sql = "SELECT * FROM materiales WHERE id=$id";
            $data= $this->select($sql);
            return $data;
        }



        public function accionVehiculo (int $id){
            $this->id = $id;
            // $this->estado = $estado;
            // $sql ="UPDATE vehiculos SET estado =? WHERE id=?";
            // $datos=array($this->estado,$this->id);
            // $data = $this->save($sql,$datos);
            // return $data;
            $verificar ="SELECT *FROM vehiculos WHERE id=$id AND retorno!= '0000-00-00 00:00:00' AND km_retorno != 0";           
            $existe =$this->select($verificar);
            if(!empty($existe)){
                $sql ="UPDATE vehiculos SET estado =? WHERE id=?";
                $datos=array(0,$this->id);
                $data =  $this-> save($sql,$datos);
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
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=$id_user AND p.permiso='$nombre'";
            $data= $this-> selectAll($sql);
            return $data;
        }
    }
?> 
