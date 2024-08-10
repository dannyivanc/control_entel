<?php
    class InstitucionesModel extends Query{
        public function __construct(){
            parent::__construct();
        }                 
        public function getInstituciones(){
            $sql="SELECT * FROM instituciones ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
           
        }
        public function registrarInstitucion(string $institucion){          
            $verificar ="SELECT *FROM instituciones WHERE institucion=?";
            $stmt = $this->conect->prepare($verificar);
            $stmt->execute([$institucion]);
            $existe = $stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($existe)){
                $sql = "INSERT INTO instituciones (institucion) VALUES (?)";
                $stmt = $this->conect->prepare($sql);
                $stmt->execute([$institucion]);
                $data =  $stmt->rowCount();
                if($data==1){
                    $res = "ok";
                }else{
                    $res = "error";
                }
            }else {
                $res ="existe";
            }
            return $res;
        }
        public function modificarInstitucion(string $institucion, int $id){
            $verificar ="SELECT *FROM instituciones WHERE institucion=?";
            $stmt = $this->conect->prepare($verificar);
            $stmt->execute([$institucion]);
            $existe = $stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($existe)){
                $sql = "UPDATE instituciones SET institucion=? WHERE id=?";       
                $stmt = $this->conect->prepare($sql);
                $stmt->execute([$institucion, $id]);
                $data = $stmt->rowCount();
                if ($data==1) {
                    $res = "modificado";
                } else {
                    $res = "error";
                }
            }else {
                $res ="existe";
            }
            return $res;
        }
        public function editarInstitucion(int $id){
            $sql = "SELECT * FROM instituciones WHERE id=?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
        public function accionInstitucion (int $estado,int $id){
            $sql ="UPDATE instituciones SET estado =? WHERE id=?";            
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$estado, $id]);
            $data = $stmt->rowCount();
            if ($data==1) {
                $sql_suc ="UPDATE sucursales SET estado =? WHERE id_institucion=?";
                $stmt = $this->conect->prepare($sql_suc);
                $stmt->execute([$estado, $id]);
            }
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
