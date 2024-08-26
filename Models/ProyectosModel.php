<?php
    class ProyectosModel extends Query{  
        public function __construct(){
            parent::__construct();
        }

        public function getInstituciones(){
            $sql="SELECT * FROM instituciones WHERE estado = 1";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }    
        
        public function getSucursal(int $id){
            $sql="SELECT su.id,su.sucursal,su.id_institucion,inst.institucion  FROM sucursales as su
            INNER JOIN instituciones as inst ON su.id_institucion = inst.id
            INNER JOIN suc_vig ON su.id = suc_vig.id_sucursal
            WHERE suc_vig.id_vigilante = ?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }  
        
        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=? AND p.permiso=?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id_user,$nombre]);
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }     
    }
?> 
