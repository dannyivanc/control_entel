<?php
    class VehiculosModel extends Query{
        private $id,$salida,$retorno,$tipo,$placa,$km_salida,$km_retorno,$conductor,$destino,$estado,$id_sucursal,$id_vigilante;
  
        public function __construct(){
            parent::__construct();
        }
        public function getSucursal(int $id){
            $sql="SELECT su.id,su.sucursal,su.id_institucion,su.id_vigilante,inst.institucion  FROM sucursales as su
            INNER JOIN instituciones as inst ON su.id_institucion = inst.id
            WHERE id_vigilante = $id";
            $data= $this->select($sql);
            return $data;
        }      
        
        // public function getVigilantes(){
        //     $sql="SELECT id,nombre as vigilante FROM usuarios WHERE estado = 1 and rol='vigilante'";
        //     $data= $this->selectAll($sql);
        //     return $data;
        // }       
        
        // public function getSucursales(){
        //     // $sql="SELECT s.*, i.id AS id_institucion, i.institucion 
        //     // FROM sucursales as s
        //     // INNER JOIN instituciones as i ON s.id_institucion = i.id
        //     // ORDER BY id DESC;";
        //     $sql="SELECT s.*, i.id AS id_institucion, i.institucion, u.id AS id_vigilante,u.nombre as vigilante
        //     FROM sucursales as s
        //     INNER JOIN instituciones as i ON s.id_institucion = i.id
        //     INNER JOIN usuarios as u ON s.id_vigilante = u.id
        //     ORDER BY id DESC;";
        //     $data= $this->selectAll($sql);
        //     return $data;
        // }

        // $salida,$retorno,$tipo,$placa,$km_salida,$km_retorno,$conductor,$destino,$estado,$id_sucursal,$id_vigilante
        public function registrarVehiculo(string $salida,string $retorno,string $tipo,string $placa,int $km_salida,int $km_retorno,string $conductor,string $destino,int $id_sucursal,int $id_vigilante){    

  
            list($fecha_salida, $hora_salida) = explode('T', $salida);
            list($fecha_retorno, $hora_retorno) = explode('T', $retorno);
            
            $this->salida = $fecha_salida . ' ' . substr($hora_salida, 0, 5) . ':00';
            $this->retorno = $fecha_retorno . ' ' . substr($hora_retorno, 0, 5) . ':00';
            $this->tipo=$tipo;
            $this->placa=$placa;
            $this->km_salida=$km_salida;
            $this->km_retorno=$km_retorno;
            $this->conductor=$conductor;
            $this->destino=$destino;
            $this->id_sucursal=$id_sucursal;
            $this->id_vigilante=$id_vigilante;
            // $res =   $this->salida;
            $sql = "INSERT INTO vehiculos (salida,retorno,tipo,placa,km_salida,km_retorno,conductor,destino,id_vigilante,id_sucursal) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $datos =array($this->salida,$this->retorno,$this->tipo,$this->placa,$this->km_salida,$this->km_retorno,$this->conductor,$this->destino,$this->id_sucursal,$this->id_vigilante);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res;
        }

        // public function modificarSucursal(string $sucursal,int $id_institucion,int $id_vigilante,string $ciudad,string $direccion, int $id){
        //     $this->sucursal=$sucursal;
        //     $this->id_institucion=$id_institucion;
        //     $this->id_vigilante=$id_vigilante;
        //     $this->ciudad=$ciudad;
        //     $this->direccion=$direccion;
        //     $this->id=$id;
        //     $sql = "UPDATE sucursales SET sucursal=?,id_institucion=?,id_vigilante=?,ciudad=?,direccion=? WHERE id=?"; 
        //     $datos =array( $this->sucursal,$this->id_institucion,$this->id_vigilante,$this->ciudad,$this->direccion,$this->id);
        //     $data =  $this-> save($sql,$datos);
        //     if($data==1){
        //         $res = "modificado";
        //     }else{
        //         $res = "error";
        //     }
        //     return $res;
        // }
        // public function editarSucursal(int $id){
        //     $sql = "SELECT * FROM sucursales WHERE id=$id";
        //     $data= $this->select($sql);
        //     return $data;
        // }
        // public function accionInstitucion (int $estado,int $id){
        //     $this->id = $id;
        //     $this->estado = $estado;
        //     $sql ="UPDATE sucursales SET estado =? WHERE id=?";
        //     $datos=array($this->estado,$this->id);
        //     $data = $this->save($sql,$datos);
        //     return $data;
        // }
    }
?> 
