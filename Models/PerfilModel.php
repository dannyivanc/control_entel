<?php
    class PerfilModel extends Query{  
        public function __construct(){
            parent::__construct();
        }
        public function getPerfil(){
            $id = $_SESSION['id_usuario'];          
            $sql="SELECT * FROM usuarios where id=?";
            $stmt=$this->conect->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
        public function modificarPerfilPass(string $actual,string $clave,int $id){
            $verificar ="SELECT clave FROM usuarios WHERE id=?";
            $stmt = $this->conect->prepare($verificar);
            $stmt->execute([$id]);
            $existe = $stmt->fetch(PDO::FETCH_ASSOC);
            $clave_value = json_decode(json_encode($existe),true)['clave'];
            if($actual!= $clave_value ){
                $res = "incorrecto";
            }
            else{
                $sql = "UPDATE usuarios SET clave=? WHERE id=?";   
                $stmt=$this->conect->prepare($sql);
                $stmt->execute([$clave,$id]);   
                $data = $stmt->rowCount();   
                if($data==1){
                    $res = "modificado";
                }else{
                    $res = "error";
                }
            }
            return $res;
        }
    }
?> 
