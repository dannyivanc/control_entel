<?php
    class UsuariosModel extends Query{
        private $id,$usuario,$nombre,$carnet,$clave,$id_institucion,$estado;
  
        public function __construct(){
            parent::__construct();
        }
        public function getUsuario(string $usuario, string $clave){
            $sql="SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave ='$clave'";
            $data= $this->select($sql);
            return $data;
        }

        public function getInstituciones(){
            $sql="SELECT * FROM institucion WHERE estado = 1";
            $data= $this->selectAll($sql);
            return $data;
        }

        public function getUsuarios(){
            $sql="SELECT u.* , i.id as id_institucion, i.institucion FROM usuarios u INNER JOIN institucion i where u.id_institucion = i.id ";
            $data= $this->selectAll($sql);
            return $data;
        }
        public function registrarUsuario(string $usuario, string $nombre, string $carnet, string $clave, int $id_institucion){
            $this->usuario=$usuario;
            $this->nombre=$nombre;
            $this->carnet=$carnet;
            $this->clave=$clave;
            $this->id_institucion=$id_institucion;
            $verificar ="SELECT *FROM usuarios WHERE usuario='$this->usuario' OR carnet ='$this->carnet'";
            $existe =$this->select($verificar);
            if(empty($existe)){
                $sql = "INSERT INTO usuarios (usuario,nombre,carnet,clave,id_institucion) VALUES (?,?,?,?,?)";
                $datos =array($this->usuario,$this->nombre,$this->carnet,$this->clave,$this->id_institucion);
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
        public function modificarUsuario(string $usuario, string $nombre, string $carnet, int $id_institucion, int $id){
            $this->usuario=$usuario;
            $this->nombre=$nombre;
            $this->carnet=$carnet;
            $this->id_institucion=$id_institucion;
            $this->id=$id;
            $sql = "UPDATE usuarios SET usuario=?,nombre=?,carnet=?,id_institucion =? WHERE id=?";         
            $datos =array($this->usuario,$this->nombre,$this->carnet,$this->id_institucion,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;

        }

        public function modificarUsuarioPass(string $usuario, string $nombre, string $carnet,string $clave, int $id_institucion, int $id){
            $this->usuario=$usuario;
            $this->nombre=$nombre;
            $this->carnet=$carnet;
            $this->clave=$clave;
            $this->id_institucion=$id_institucion;
            $this->id=$id;
            $sql = "UPDATE usuarios SET usuario=?,nombre=?,carnet=?,clave=?,id_institucion =? WHERE id=?";         
            $datos =array($this->usuario,$this->nombre,$this->carnet,$this->clave,$this->id_institucion,$this->id);
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