<?php
    class UsuariosModel extends Query{
        public function __construct()
        {
            parent::__construct();
        }
        public function getUsuario(string $usuario, string $clave)
        {
            $sql="SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave ='$clave'";
            $data= $this->select($sql);
            return $data;
        }

        public function getUsuarios()
        {
            $sql="SELECT u.* , i.id, i.institucion FROM usuarios u INNER JOIN institucion i where  u.id_institucion = i.id";
            $data= $this->selectAll($sql);
            return $data;
        }
    }
?> 
