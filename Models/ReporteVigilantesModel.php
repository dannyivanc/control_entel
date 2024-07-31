<?php
    class ReporteVigilantesModel extends Query{
         private $id, $usuario, $nombre, $carnet, $clave, $id_institucion, $estado, $cel, $rol;

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
            $data= $this->selectAll($sql);
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
            ORDER BY u.id DESC   ";


            // $sql="SELECT u.nombre,u.carnet,u.cel,
            //   COALESCE(
            //     (SELECT sucursales.sucursal FROM sucursales  
            //     INNER JOIN suc_vig ON suc_vig.id_sucursal = sucursales.id
            //     WHERE suc_vig.id_vigilante = u.id)
            //     ,'Sin asignar'
            // ) AS sucursal,
            // instituciones.institucion FROM usuarios as u
            //  INNER JOIN suc_vig ON suc_vig.id_vigilante= u.id
            //  INNER JOIN sucursales ON suc_vig.id_sucursal = sucursales.id 
            //  INNER JOIN instituciones ON sucursales.id_institucion= instituciones.id 
            //  ORDER BY u.id DESC";

            // $sql="SELECT u.nombre,u.carnet,u.cel,
            // sucursales.sucursal as sucursal,
            // instituciones.institucion FROM usuarios as u
            //  INNER JOIN suc_vig ON suc_vig.id_vigilante= u.id
            //  INNER JOIN sucursales ON suc_vig.id_sucursal = sucursales.id 
            //  INNER JOIN instituciones ON sucursales.id_institucion= instituciones.id 
            //  ORDER BY u.id DESC";
            $data= $this->selectAll($sql);
            return $data;
        }
        public function getUsuarios2(int $id_institucion){
            $sql="SELECT u.nombre,u.carnet,u.cel,u.estado,sucursales.sucursal as sucursal,instituciones.institucion FROM usuarios as u
             INNER JOIN suc_vig ON suc_vig.id_vigilante= u.id
             INNER JOIN sucursales ON suc_vig.id_sucursal = sucursales.id 
             INNER JOIN instituciones ON sucursales.id_institucion= instituciones.id 
             WHERE instituciones.id= $id_institucion
             ORDER BY u.id DESC";
            $data= $this->selectAll($sql);
            return $data;
        }
        
        public function registrarUsuario(string $usuario, string $nombre, string $carnet, string $clave, int $id_institucion,int $cel,string $rol){
            $this->usuario=$usuario;
            $this->nombre=$nombre;
            $this->carnet=$carnet;
            $this->clave=$clave;
            $this->cel=$cel;
            $this->rol=$rol;
            $this->id_institucion=$id_institucion;
            $verificar ="SELECT *FROM usuarios WHERE usuario='$this->usuario' OR carnet ='$this->carnet'";
            $existe =$this->select($verificar);
            if(empty($existe)){
                $sql = "INSERT INTO usuarios (usuario,nombre,carnet,clave,rol,cel,id_institucion) VALUES (?,?,?,?,?,?,?)";
                $datos =array($this->usuario,$this->nombre,$this->carnet,$this->clave,$this->rol,$this->cel,$this->id_institucion);
                $data =  $this-> save($sql,$datos);
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
            $this->usuario=$usuario;
            $this->nombre=$nombre;
            $this->carnet=$carnet;
            $this->cel=$cel;
            $this->rol=$rol;
            $this->id_institucion=$id_institucion;
            $this->id=$id;
            $sql = "UPDATE usuarios SET usuario=?,nombre=?,carnet=?,cel=?,rol=?,id_institucion =? WHERE id=?";         
            $datos =array($this->usuario,$this->nombre,$this->carnet,$this->cel,$this->rol,$this->id_institucion,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;

        }

        public function modificarUsuarioPass(string $usuario, string $nombre, string $carnet,string $clave, int $id_institucion, int $id,int $cel,string $rol){
            $this->usuario=$usuario;
            $this->nombre=$nombre;
            $this->carnet=$carnet;
            $this->clave=$clave;
            $this->cel=$cel;
            $this->rol=$rol;
            $this->id_institucion=$id_institucion;
            $this->id=$id;
            $sql = "UPDATE usuarios SET usuario=?,nombre=?,carnet=?,clave=?,cel=?rol=?,id_institucion =? WHERE id=?";         
            $datos =array($this->usuario,$this->nombre,$this->carnet,$this->cel,$this->rol,$this->clave,$this->id_institucion,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;

        }
        public function editarUser(int $id){
            $sql = "SELECT * FROM usuarios WHERE id=$id";
            $data= $this->select($sql);
            return $data;
        }
        public function accionUser (int $estado,int $id){
            $this->id = $id;
            $this->estado = $estado;
            $sql ="UPDATE usuarios SET estado =? WHERE id=?";
            $datos=array($this->estado,$this->id);
            $data = $this->save($sql,$datos);
            return $data;
        }

        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=$id_user AND p.permiso='$nombre'";
            $data= $this-> selectAll($sql);
            return $data;
        }
    }
?> 
