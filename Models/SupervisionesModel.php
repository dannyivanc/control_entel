<?php
    class SupervisionesModel extends Query{
        private $id, $fecha,$lat,$lng,$puntualidad,$pres_per,$patrulla, $epp,$libro,$verif_vehi,$id_sucursal,$id_supervisor,$id_vigilante;
  
        public function __construct(){
            parent::__construct();
        }

        public function getInstitucion(int $id){
            $sql="SELECT * FROM instituciones WHERE id = $id";
            $data= $this->select($sql);
            return $data;
        }    
        
        public function getSucursales(int $id){
            $sql="SELECT * FROM sucursales WHERE id_institucion= $id ORDER BY id DESC";
            $data= $this->selectAll($sql);
            return $data;
           
        }
        public function getVigilantes(int $id){
            // $sql="SELECT id,nombre as vigilante FROM usuarios WHERE estado = 1 and rol='vigilante'";
            $sql="SELECT u.id AS id_vigilante, u.nombre AS vigilante
            FROM sucursales AS su
            INNER JOIN suc_vig AS sv ON su.id = sv.id_sucursal
            INNER JOIN usuarios AS u ON sv.id_vigilante = u.id
            WHERE su.id_institucion = $id";
            $data= $this->selectAll($sql);
            return $data;
        }   
      


        public function listarSupervisiones(int $id){
            $sql="SELECT * FROM supervicion WHERE id_supervisor= $id ORDER BY id DESC";
            $data= $this->selectAll($sql);
            return $data;
           
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
        
        public function registrarSupervision(string $fecha,float $lat,float $lng,string $puntualidad,string $pres_per,string $patrulla,string $epp,string $libro,string $verif_vehi,int $id_sucursal,int $id_supervisor,int $id_vigilante){    
           
            $this->fecha = $fecha;
            $this->lat=$lat;
            $this->lng=$lng;
            $this->puntualidad=$puntualidad;
            $this->pres_per=$pres_per;
            $this->patrulla=$patrulla;       
            $this->epp=$epp;
            $this->libro=$libro;
            $this->verif_vehi=$verif_vehi;       
            $this->id_sucursal=$id_sucursal;
            $this->id_supervisor=$id_supervisor;
            $this->id_vigilante=$id_vigilante;
            $sql = "INSERT INTO supervicion (fecha,lat,lng,puntualidad,pres_per,patrulla,epp,libro,verif_vehi,id_sucursal,id_supervisor,id_vigilante) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $datos =array($this->fecha,$this->lat,$this->lng,$this->puntualidad,$this->pres_per,$this->patrulla,$this->epp,$this->libro,$this->verif_vehi,$this->id_sucursal,$this->id_supervisor,$this->id_vigilante);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        // public function modificarMaterial(string $fecha,string $movimiento,string $persona,string $destino,string $descripcion,string $observacion,int $id_vigilante,int $id){
            
        //     list($fecha_registro, $hora_registro) = explode('T', $fecha);
        //     $this->fecha = $fecha_registro . ' ' . substr($hora_registro, 0, 5) . ':00';
        //     $this->movimiento=$movimiento;
        //     $this->persona=$persona;
        //     $this->destino=$destino;
        //     $this->descripcion=$descripcion;
        //     $this->observacion=$observacion;       
        //     $this->id_vigilante=$id_vigilante;
        //     $this->id=$id;
        //     $sql = "UPDATE materiales SET fecha=?,movimiento=?,persona=?,destino=?,descripcion=?,observacion=?,id_vigilante=? WHERE id=?"; 
        //     $datos =array($this->fecha,$this->movimiento,$this->persona,$this->destino,$this->descripcion,$this->observacion,$this->id_vigilante,$this->id);
        //     $data =  $this-> save($sql,$datos);
        //     if($data==1){
        //         $res = "modificado";
        //     }else{
        //         $res = "error";
        //     }
        //     return $res;
        // }
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
    }
?> 
