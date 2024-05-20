<?php
    class SucursalesModel extends Query{
        private $id,$sucursal,$institucion,$vigilante,$ciudad,$direccion,$estado;
  
        public function __construct(){
            parent::__construct();
        }

   
                        
        public function getSucursales(){
            $sql="SELECT * FROM sucursales ORDER BY id DESC";
            $data= $this->selectAll($sql);
            return $data;
           
        }


        public function registrarSucursal(string $sucursal,string $institucion,string $vigilante,string $ciudad,string $direccion){          
            $this->sucursal=$sucursal;
            $this->institucion=$institucion;
            $this->vigilante=$vigilante;
            $this->ciudad=$ciudad;
            $this->direccion=$direccion;
            $verificar ="SELECT *FROM sucursales WHERE sucursal='$this->sucursal'";
            $existe =$this->select($verificar);
            if(empty($existe)){
                $sql = "INSERT INTO sucursales (sucursal,institucion,vigilante,ciudad,direccion) VALUES (?,?,?,?,?)";
                $datos =array($this->sucursal,$this->institucion,$this->vigilante,$this->ciudad,$this->direccion);
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
        public function modificarInstitucion(string $institucion, int $id){

            $this->institucion=$institucion;
            $this->id=$id;
            $sql = "UPDATE instituciones SET institucion=? WHERE id=?";         
            $datos =array($this->institucion,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        
        }
        public function editarInstitucion(int $id){
            $sql = "SELECT * FROM instituciones WHERE id=$id";
            $data= $this->select($sql);
            return $data;
        }

 
  
        public function accionInstitucion (int $estado,int $id){
            $this->id = $id;
            $this->estado = $estado;
            $sql ="UPDATE instituciones SET estado =? WHERE id=?";
            $datos=array($this->estado,$this->id);
            $data = $this->save($sql,$datos);
            return $data;
        }
    }
?> 
