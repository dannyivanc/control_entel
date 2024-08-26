<?php
    class ProyectoSucursalModel extends Query{
        private $id,$fecha,$movimiento,$persona,$destino,$descripcion,$observacion,$id_sucursal,$id_vigilante;
  
        public function __construct(){
            parent::__construct();
        }

        public function getSucursales(int $id_institucion){
            $sql="SELECT id,sucursal FROM sucursales WHERE id_institucion = ?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_institucion]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }  
        public function getInstitucion(int $id_institucion){
            $sql="SELECT id,institucion FROM instituciones WHERE id = ?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_institucion]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
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
