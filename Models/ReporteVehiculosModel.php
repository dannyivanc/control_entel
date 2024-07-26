<?php
    class ReporteVehiculosModel extends Query{
    public function __construct() {
        parent::__construct();
    }

        public function getVehiculos(int $id_sucursal) {   
            $sql=" SELECT * FROM vehiculos WHERE id_sucursal=? and estado = 1
            AND salida >= DATE_SUB(CURDATE(), INTERVAL 31 DAY)
            ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_sucursal]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }



        public function getInstituciones(){
            $sql="SELECT * FROM instituciones WHERE estado = 1";
            $data= $this->selectAll($sql);
            return $data;
        }

        public function getUsuarios(){
            
            $sql="SELECT u.* , i.id as id_institucion, i.institucion 
            FROM usuarios as u 
            INNER JOIN instituciones as i ON u.id_institucion = i.id  
            ORDER BY id DESC";
            $data= $this->selectAll($sql);
            return $data;
        }
        
  

     
        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=$id_user AND p.permiso='$nombre'";
            $data= $this-> selectAll($sql);
            return $data;
        }

       

        public function listarRango(int $id_inst,string $inicio,string $fin){
            $sql=" SELECT su.*, us.nombre AS id_vigilante, sucursales.sucursal AS id_sucursal
            FROM supervision AS su
            INNER JOIN usuarios AS us ON us.id = su.id_vigilante
            INNER JOIN sucursales ON sucursales.id = su.id_sucursal
            INNER JOIN instituciones ON instituciones.id = sucursales.id_institucion
            WHERE instituciones.id =? AND su.fecha BETWEEN ? AND ?
            ORDER BY su.fecha DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_inst, $inicio, $fin]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }
?> 
