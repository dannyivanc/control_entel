<?php
    class VehiculosModel extends Query{
        private $id,$salida,$retorno,$tipo,$placa,$km_salida,$km_retorno,$conductor,$destino,$estado,$id_sucursal,$id_vigilante;
  
        public function __construct(){
            parent::__construct();
        }
        public function getSucursal(int $id){
            $sql="SELECT su.id,su.sucursal,su.id_institucion,inst.institucion  
            FROM sucursales as su
            INNER JOIN instituciones as inst ON su.id_institucion = inst.id
            INNER JOIN suc_vig ON su.id = suc_vig.id_sucursal
            WHERE suc_vig.id_vigilante = $id";
            $data= $this->select($sql);
            return $data;
        }           
        public function getVehiculos(int $id_suc){
            $sql="SELECT * FROM vehiculos 
            WHERE id_sucursal = $id_suc and estado = 1
            ORDER BY id DESC";
            $data= $this->selectAll($sql);
            return $data;
        }
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

        public function modificarVehiculo(string $salida,string $retorno,string $tipo,string $placa,int $km_salida,int $km_retorno,string $conductor,string $destino,int $id_vigilante,int $id){
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
            $this->id_vigilante=$id_vigilante;
            $this->id=$id;
            $sql = "UPDATE vehiculos SET salida=?,retorno=?,tipo=?,placa=?,km_salida=?,km_retorno=?,conductor=?,destino=?,id_vigilante=? WHERE id=?"; 
            $datos =array($this->salida,$this->retorno,$this->tipo,$this->placa,$this->km_salida,$this->km_retorno,$this->conductor,$this->destino,$this->id_vigilante,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res;
        }
        public function editarVehiculo(int $id){
            $sql = "SELECT * FROM vehiculos WHERE id=$id";
            $data= $this->select($sql);
            return $data;
        }



        public function accionVehiculo (int $id){
            $this->id = $id;
            // $this->estado = $estado;
            // $sql ="UPDATE vehiculos SET estado =? WHERE id=?";
            // $datos=array($this->estado,$this->id);
            // $data = $this->save($sql,$datos);
            // return $data;
            $verificar ="SELECT *FROM vehiculos WHERE id=$id AND retorno!= '0000-00-00 00:00:00' AND km_retorno != 0";           
            $existe =$this->select($verificar);
            if(!empty($existe)){
                $sql ="UPDATE vehiculos SET estado =? WHERE id=?";
                $datos=array(0,$this->id);
                $data =  $this-> save($sql,$datos);
                if($data==1){
                    $res = "ok";
                }else{
                    $res = "error";
                }
            }else {
                $res ="void";
            }
            return $res;
          
        }

        public function verificarPermiso(int $id_user, string $nombre){
            $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id=d.id_permiso WHERE d.id_usuario=$id_user AND p.permiso='$nombre'";
            $data= $this-> selectAll($sql);
            return $data;
        }
    }
?> 
