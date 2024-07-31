<?php
    class ReportePatrullajesModel extends Query{
         private $id, $usuario, $nombre, $carnet, $clave, $id_institucion, $estado, $cel, $rol;

    public function __construct() {
        parent::__construct();
    }

        public function getPatrullajes(int $id_inst) {   
                $sql=" SELECT pa.*, us.nombre AS id_supervisor, sucursales.sucursal AS id_sucursal
                FROM patrullaje AS pa
                INNER JOIN usuarios AS us ON us.id = pa.id_supervisor
                INNER JOIN sucursales ON sucursales.id = pa.id_sucursal
                INNER JOIN instituciones ON instituciones.id = sucursales.id_institucion
                WHERE instituciones.id =?
                AND pa.fecha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                ORDER BY pa.id DESC";
                $stmt = $this->conect->prepare($sql);
                $stmt->execute([$id_inst]);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $data;
        }


        public function getInstituciones(){
            $sql="SELECT * FROM instituciones WHERE estado = 1";
            $data= $this->selectAll($sql);
            return $data;
        }

       
        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=$id_user AND p.permiso='$nombre'";
            $data= $this-> selectAll($sql);
            return $data;
        }

        public function listarRango(int $id_inst,string $inicio,string $fin){
                $sql=" SELECT pa.*, us.nombre AS id_supervisor, sucursales.sucursal AS id_sucursal
                FROM patrullaje AS pa
                INNER JOIN usuarios AS us ON us.id = pa.id_supervisor
                INNER JOIN sucursales ON sucursales.id = pa.id_sucursal
                INNER JOIN instituciones ON instituciones.id = sucursales.id_institucion
                WHERE instituciones.id =? AND pa.fecha BETWEEN ? AND ?
                ORDER BY pa.fecha DESC";
                $stmt = $this->conect->prepare($sql);
                $stmt->execute([$id_inst,$inicio,$fin]);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $data;
        }
    }
?> 
