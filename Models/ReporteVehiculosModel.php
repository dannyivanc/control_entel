<?php
    class ReporteVehiculosModel extends Query{
         private $id, $usuario, $nombre, $carnet, $clave, $id_institucion, $estado, $cel, $rol;

    public function __construct() {
        parent::__construct();
    }

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