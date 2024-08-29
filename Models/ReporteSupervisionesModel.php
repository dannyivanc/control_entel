<?php
class ReporteSupervisionesModel extends Query{
    public function __construct() {
        parent::__construct();
    }
    //
    public function getSupervisiones(int $id_inst) {   
            $sql=" SELECT su.*, us.nombre AS id_vigilante, sucursales.sucursal AS id_sucursal
            FROM supervision AS su
            INNER JOIN usuarios AS us ON us.id = su.id_vigilante
            INNER JOIN sucursales ON sucursales.id = su.id_sucursal
            INNER JOIN instituciones ON instituciones.id = sucursales.id_institucion
            WHERE instituciones.id =? AND su.fecha >= DATE_SUB(CURDATE(), INTERVAL 31 DAY)
            ORDER BY su.fecha DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_inst]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
    }
    public function getInstituciones(){
        $sql="SELECT * FROM instituciones WHERE estado = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->execute([1]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function verificarPermiso(int $id_user, string $nombre){
        $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=? AND p.permiso=?";
        $stmt = $this->conect->prepare($sql);
        $stmt->execute([$id_user,$nombre]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data; 
    }
    
}
?> 
