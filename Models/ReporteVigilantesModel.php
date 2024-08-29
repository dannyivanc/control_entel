<?php
class ReporteVigilantesModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getUsuario(string $usuario, string $clave) {
        try {
            $sql = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$usuario, $clave]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }
    
    public function getInstituciones(){
        $sql="SELECT * FROM instituciones WHERE estado = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->execute([1]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getUsuarios(){
        $sql=" SELECT u.nombre,u.cel,u.carnet,u.estado,
        COALESCE(
            (SELECT instituciones.institucion 
            FROM suc_vig 
            INNER JOIN sucursales ON suc_vig.id_sucursal = sucursales.id 
            INNER JOIN instituciones ON instituciones.id = sucursales.id_institucion 
            WHERE suc_vig.id_vigilante = u.id
            LIMIT 1), 
            (SELECT instituciones.institucion FROM instituciones
                    INNER JOIN usuarios ON instituciones.id= usuarios.id_institucion 
                    WHERE usuarios.id = u.id AND usuarios.id_institucion!=1 LIMIT 1), 'Sin asignar'
        ) AS institucion,
        COALESCE(
            (SELECT sucursales.sucursal FROM suc_vig 
            INNER JOIN sucursales ON suc_vig.id_sucursal = sucursales.id 
            WHERE suc_vig.id_vigilante = u.id LIMIT 1), 'Sin asignar'
        ) AS sucursal
        FROM usuarios AS u
        LEFT JOIN suc_vig ON u.id = suc_vig.id_vigilante
        WHERE u.rol='vigilante'
        ORDER BY u.id DESC";
        $stmt = $this->conect->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getUsuarios2(int $id_institucion){
        $sql="SELECT u.nombre,u.carnet,u.cel,u.estado,sucursales.sucursal as sucursal,instituciones.institucion FROM usuarios as u
        INNER JOIN suc_vig ON suc_vig.id_vigilante= u.id
        INNER JOIN sucursales ON suc_vig.id_sucursal = sucursales.id 
        INNER JOIN instituciones ON sucursales.id_institucion= instituciones.id 
        WHERE instituciones.id= ?
        ORDER BY u.id DESC";
        $stmt = $this->conect->prepare($sql);
        $stmt->execute([$id_institucion]);
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
