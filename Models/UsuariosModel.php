<?php
    class UsuariosModel extends Query{
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
            $sql="SELECT * FROM instituciones WHERE estado = 1";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute();
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function getUsuarios(){
            $sql=" SELECT DISTINCT u.*, 
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
            ) AS institucion
            FROM 
                usuarios AS u
            LEFT JOIN 
                suc_vig ON u.id = suc_vig.id_vigilante
            ORDER BY 
                u.id DESC;";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute();
            $data= $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
        
        public function registrarUsuario(string $usuario, string $nombre, string $carnet, string $clave, int $id_institucion,int $cel,string $rol){
            $id_inst = ($rol == 'cliente') ? $id_institucion : 1;
            $verificar ="SELECT *FROM usuarios WHERE usuario=? OR carnet =?";
            $stmt_ver=$this->conect->prepare($verificar);
            $stmt_ver->execute([$usuario,$carnet]);
            $existe=$stmt_ver->fetch(PDO::FETCH_ASSOC);
            if(empty($existe)){
                $sql = "INSERT INTO usuarios (usuario,nombre,carnet,clave,rol,cel,id_institucion) VALUES (?,?,?,?,?,?,?)";
                $stmt=$this->conect->prepare($sql);
                $stmt->execute([$usuario,$nombre,$carnet,$clave,$rol,$cel,$id_inst]);
                $data = $stmt->rowCount();
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

        public function modificarUsuario(string $usuario, string $nombre, string $carnet, int $id_institucion, int $id,int $cel,string $rol){
            $id_inst = ($rol == 'cliente') ? $id_institucion : 1;
            $verificar ="SELECT *FROM usuarios WHERE id!=? and (carnet =? or usuario=?)";
            $stmt_ver=$this->conect->prepare($verificar);
            $stmt_ver->execute([$id,$carnet,$usuario]);
            $existe=$stmt_ver->fetchAll(PDO::FETCH_ASSOC);
            if(empty($existe)){
                $sql = "UPDATE usuarios SET usuario=?,nombre=?,carnet=?,cel=?,rol=?,id_institucion =? WHERE id=?";    
                $stmt=$this->conect->prepare($sql);
                $stmt->execute([$usuario,$nombre,$carnet,$cel,$rol,$id_inst,$id]);
                $data = $stmt->rowCount();
                if($data==1){
                    $res = "modificado";
                }else{
                    $res = "error";
                }
            }else {
                $res ="existe";
            }
            return $res;
        }
                                                    
        public function modificarUsuarioPass(string $usuario, string $nombre, string $carnet,string $clave, int $id_institucion, int $id,int $cel,string $rol){
            $id_inst = ($rol == 'cliente') ? $id_institucion : 1;
            $verificar ="SELECT *FROM usuarios WHERE id!=? and (carnet =? or usuario=?)";
            $stmt_ver=$this->conect->prepare($verificar);
            $stmt_ver->execute([$id,$carnet,$usuario]);
            $existe=$stmt_ver->fetchAll(PDO::FETCH_ASSOC);
            if(empty($existe)){
                $sql = "UPDATE usuarios SET usuario=?,nombre=?,carnet=?,clave=?,cel=?,rol=?,id_institucion=? WHERE id=?";         
                $stmt= $this->conect->prepare($sql);
                $stmt->execute([$usuario, $nombre, $carnet,$clave,$cel, $rol, $id_inst, $id]);
                $data=$stmt->rowCount();
                if($data==1){
                    $res = "modificado";
                }else{
                    $res = "error";
                }
            }else {
                $res ="existe";
            }
            return $res;
        }

        public function editarUser(int $id){
            $sql = "SELECT * FROM usuarios WHERE id=?";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            // $data= $this->select($sql);
            return $data;
        }

        public function accionUser (int $estado,int $id){
            $sql ="UPDATE usuarios SET estado =? WHERE id=?";
            $stmt= $this->conect->prepare($sql);
            $stmt->execute([$estado,$id]);
            $data=$stmt->rowCount();
            return $data;
        }
        //para permisos

        public function getUser(int $id){
            $sql="SELECT * FROM usuarios WHERE id=?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data= $stmt->fetchAll(PDO::FETCH_ASSOC);   
            return $data;
        }

        public function getPermisos(){
            $sql="SELECT * FROM permisos";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute();
            $data= $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        }
        
        public function elimiarPermisos(int $id_usuario){                
            $sql = "DELETE FROM detalle_permisos WHERE id_usuario=?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id_usuario]);
            $data= $stmt->rowCount();
            if($data>=1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        public function registrarPermisos(int $id_usuario, int $id_permiso){                
            $sql = "INSERT INTO detalle_permisos (id_usuario,id_permiso) VALUES (?,?)";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id_usuario,$id_permiso]);
            $data= $stmt->rowCount();
            if($data>=1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        public function getDetallePermisos(int $id_usuario){
            $sql="SELECT * FROM detalle_permisos WHERE id_usuario=?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id_usuario]);
            $data= $stmt->fetchAll(PDO::FETCH_ASSOC);  
            return $data;
        }

        public function  getArrPermiso(int $id_usuario){
            $sql="SELECT id_permiso  as vista FROM detalle_permisos WHERE id_usuario=?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id_usuario]);
            $data= $stmt->fetchAll(PDO::FETCH_ASSOC);  
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
