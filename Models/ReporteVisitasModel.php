<?php
    class ReporteVisitasModel extends Query{
    public function __construct() {
        parent::__construct();
    }
        public function getVisitas(int $id_sucursal) {   
            $sql=" SELECT * FROM visitas WHERE id_sucursal=?
            AND ingreso >= DATE_SUB(CURDATE(), INTERVAL 31 DAY)
            ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_sucursal]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function getInstituciones(){
            $sql="SELECT * FROM instituciones WHERE estado = ?";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([1]);
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function getUsuarios(){
            
            $sql="SELECT u.* , i.id as id_institucion, i.institucion 
            FROM usuarios as u 
            INNER JOIN instituciones as i ON u.id_institucion = i.id  
            ORDER BY id DESC";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute();
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
        
        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p 
            INNER JOIN detalle_permisos d ON p.id=d.id_permiso 
            WHERE d.id_usuario=? AND p.permiso=?";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([$id_user,$nombre]);
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function listarRango(int $id_sucursal,string $inicio,string $fin){
            $sql=" SELECT * FROM visitas
            WHERE id_sucursal =? AND ingreso BETWEEN ? AND ?
            ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_sucursal, $inicio, $fin]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }
?> 
