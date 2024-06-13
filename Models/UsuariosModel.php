<?php
    class UsuariosModel extends Query{
        private $id,$usuario,$nombre,$carnet,$clave,$id_institucion,$estado,$cel,$rol;
        private $conn;
  
        public function __construct(){
            parent::__construct();
         
         
             // para cborrar 
            $this->conn = new mysqli(host, user, pass, db);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset(charset);
            //para borrar
        }
        public function getUsuario(string $usuario, string $clave){
            // $sql="SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave ='$clave'";
            // $data= $this->select($sql);
            // return $data;

            //cambiar
            try {
                // Preparar la consulta SQL
                $sql = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
                $stmt = $this->conn->prepare($sql);
                if ($stmt === false) {
                    throw new Exception("Error al preparar la declaración: " . $this->conn->error);
                }
                $stmt->bind_param("ss", $usuario, $clave);
                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
                $stmt->close();
                return $data;
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
                return null;
            }

            //cambiar
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
                $sql = "INSERT INTO usuarios (usuario,nombre,carnet,clave,cel,rol,id_institucion) VALUES (?,?,?,?,?,?,?)";
                $datos =array($this->usuario,$this->nombre,$this->carnet,$this->clave,$this->cel,$this->rol,$this->id_institucion);
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
    }
?> 
