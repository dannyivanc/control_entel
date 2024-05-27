<?php
    class PerfilModel extends Query{
        private $id,$clave;
  
        public function __construct(){
            parent::__construct();
        }
        public function getPerfil(){
            $id = $_SESSION['id_usuario'];          
            $sql="SELECT *
            FROM usuarios 
            where id=$id";
            $data= $this->select($sql);
            return $data;
        }

        public function modificarPerfilPass(string $clave,int $id){
            $this->clave=$clave;
            $this->id=$id;
            $sql = "UPDATE usuarios SET clave=? WHERE id=?";         
            $datos =array($this->clave,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;

        }
   
    }
?> 
