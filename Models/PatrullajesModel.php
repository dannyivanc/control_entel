<?php
    class PatrullajesModel extends Query{
        private $id,$fecha,$lat,$lng,$descripcion,$id_sucursal,$id_supervisor;
  
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
 
        public function listarPatrullajes(int $id){
            $sql=" SELECT pa.id, pa.fecha,pa.descripcion, us.nombre AS id_supervisor, sucursales.sucursal AS id_sucursal
            FROM patrullaje AS pa
            INNER JOIN usuarios AS us ON us.id = pa.id_supervisor
            INNER JOIN sucursales ON sucursales.id = pa.id_sucursal
            INNER JOIN instituciones ON instituciones.id = sucursales.id_institucion
            WHERE instituciones.id = $id
            AND pa.fecha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            ORDER BY pa.id DESC";
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

 
        public function registrarPatrullaje(string $fecha,float $lat,float $lng,string $descripcion,int $id_sucursal,int $id_supervisor){    
            $this->fecha = $fecha;
            $this->lat=$lat;
            $this->lng=$lng;
            $this->descripcion=$descripcion;       
            $this->id_sucursal=$id_sucursal;
            $this->id_supervisor=$id_supervisor;
            $sql = "INSERT INTO patrullaje (fecha,lat,lng,descripcion,id_sucursal,id_supervisor) VALUES (?,?,?,?,?,?)";
            $datos =array($this->fecha,$this->lat,$this->lng,$this->descripcion,$this->id_sucursal,$this->id_supervisor);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        // $puntualidad,$pres_per,$patrulla, $epp,$libro,$verif_vehi,$id_sucursal,$id_vigilante,$id
        public function modificarPatrullaje(string $descripcion,int $id_sucursal,int $id){
            
            $this->descripcion=$descripcion;       
            $this->id_sucursal=$id_sucursal;
            $this->id=$id;
            $sql = "UPDATE supervision SET descripcion=?,id_sucursal=? WHERE id=?"; 
            $datos =array($this->descripcion,$this->id_sucursal,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        }


        public function editarPatrullaje(int $id){
            $sql = "SELECT * FROM supervision WHERE id=$id";
            $data= $this->select($sql);
            return $data;
        }

        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=$id_user AND p.permiso='$nombre'";
            $data= $this-> selectAll($sql);
            return $data;
        }
    }
?> 
