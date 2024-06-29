<?php
    class SucursalesModel extends Query{
        private $id,$sucursal,$id_institucion,$id_vigilante,$ciudad,$direccion,$estado;
  
        public function __construct(){
            parent::__construct();
  
          
        }
        public function getInstituciones(){
            $sql="SELECT * FROM instituciones WHERE estado = 1";
            $data= $this->selectAll($sql);
            return $data;
        }      
        
        public function getVigilantes(){
            $sql="SELECT id,nombre as vigilante FROM usuarios WHERE estado = 1 and rol='vigilante'";
            $data= $this->selectAll($sql);
            return $data;
        }       
        
        public function getSucursales(){ 
            $sql="SELECT s.*, i.id AS id_institucion, i.institucion,
                  GROUP_CONCAT(u.nombre SEPARATOR ', ') AS vigilante
            FROM 
                sucursales AS s
                INNER JOIN instituciones AS i ON s.id_institucion = i.id
                LEFT JOIN suc_vig AS sv ON s.id = sv.id_sucursal
                LEFT JOIN usuarios AS u ON sv.id_vigilante = u.id
            GROUP BY 
                s.id, i.id
            ORDER BY 
                s.id DESC" ;  
                
            $data= $this->selectAll($sql);
            return $data;

        }
        // public function getSucursales(){

        //     // $sql="SELECT s.*, i.id AS id_institucion, i.institucion, u.id AS id_vigilante, u.nombre AS vigilante
        //     // FROM sucursales AS s
        //     // INNER JOIN instituciones AS i ON s.id_institucion = i.id
        //     // LEFT JOIN usuarios AS u ON s.id_vigilante = u.id
        //     // ORDER BY s.id DESC;";            
        //     // $data= $this->selectAll($sql);
        //     // return $data;

        //         // Consulta para obtener las sucursales
        //     $sql = "SELECT s.*, i.id AS id_institucion, i.institucion, s.id_vigilante
        //     FROM sucursales AS s
        //     INNER JOIN instituciones AS i ON s.id_institucion = i.id
        //     ORDER BY s.id DESC";    

        //     $sucursales = $this->selectAll($sql);

        //     // Si no hay sucursales, retorna inmediatamente
        //     if (empty($sucursales)) {
        //     return $sucursales;
        //     }

        //     // Obtener todos los IDs de vigilantes únicos
        //     $vigilante_ids = [];
        //     foreach ($sucursales as $sucursal) {
        //     $ids = explode(',', $sucursal['id_vigilante']);
        //     foreach ($ids as $id) {
        //         $vigilante_ids[] = intval($id);
        //     }
        //     }

        //     $vigilante_ids = array_unique($vigilante_ids);
        //     if (empty($vigilante_ids)) {
        //     return $sucursales; // Si no hay IDs de vigilantes, retornar directamente las sucursales
        //     }

        //     $id_list = implode(',', $vigilante_ids);

        //     // Consulta para obtener los nombres de los vigilantes
        //     $sql = "SELECT id, nombre AS vigilante FROM usuarios WHERE id IN ($id_list)";
        //     $vigilantes = $this->selectAll($sql);

        //     // Mapear los vigilantes por su ID
        //     $vigilante_map = [];
        //     foreach ($vigilantes as $vigilante) {
        //     $vigilante_map[$vigilante['id']] = $vigilante['vigilante'];
        //     }

        //     // Asociar los nombres de los vigilantes con las sucursales
        //     foreach ($sucursales as &$sucursal) {
        //     $ids = explode(',', $sucursal['id_vigilante']);
        //     $sucursal['vigilantes'] = [];
        //     foreach ($ids as $id) {
        //         if (isset($vigilante_map[intval($id)])) {
        //             $sucursal['vigilantes'][] = $vigilante_map[intval($id)];
        //         }
        //     }
        //     }
        //     return $sucursales;
        // }
        
        public function registrarSucursal(string $sucursal, int $id_institucion, string $id_vigilante, string $ciudad, string $direccion) {
            $this->sucursal=$sucursal;
            $this->id_institucion=$id_institucion;
            $this->id_vigilante=$id_vigilante;
            $this->ciudad=$ciudad;
            $this->direccion=$direccion;

            $verificar ="SELECT *FROM sucursales WHERE sucursal='$this->sucursal'";
            $existe =$this->select($verificar);
            if(empty($existe)){
                $sqlsuc = "INSERT INTO sucursales (sucursal,id_institucion,ciudad,direccion) VALUES (?,?,?,?)";
                $stmt = $this-> conn->prepare($sqlsuc);
                $stmt->bind_param("siss", $sucursal, $id_institucion, $ciudad, $direccion);
                $stmt->execute();
                $data = $this-> conn->insert_id;

                $ids = array_map('intval', explode(",", $id_vigilante)); 
                foreach ($ids as $valor) {
                    $sql_suc_vig = "DELETE FROM suc_vig WHERE id_vigilante = $valor";                    
                    $this->conn->query($sql_suc_vig);

                    $sql_reg = "INSERT INTO suc_vig (id_sucursal,id_vigilante ) VALUES (?,?)";
                    $datos_Reg =array($data,$valor);
                    $this-> save($sql_reg,$datos_Reg);
                }                
                if(!empty($data)){
                    $res = "ok";
                }else{
                    $res = "error";
                }  
            }
            else {
                $res ="existe";
            }
            return $res;

        }

        public function modificarSucursal(string $sucursal,int $id_institucion,string $id_vigilante,string $ciudad,string $direccion, int $id){
            $this->sucursal=$sucursal;
            $this->id_institucion=$id_institucion;
            $this->id_vigilante=$id_vigilante;
            $this->ciudad=$ciudad;
            $this->direccion=$direccion;
            $this->id=$id;
            $sql = "UPDATE sucursales SET sucursal=?,id_institucion=?,ciudad=?,direccion=? WHERE id=?"; 
            $datos =array( $this->sucursal,$this->id_institucion,$this->ciudad,$this->direccion,$this->id);
            $datasuc =  $this-> save($sql,$datos);
            $ids = array_map('intval', explode(",", $id_vigilante)); 
            foreach ($ids as $valor) {
             

                $sql_suc_vig = "DELETE FROM suc_vig WHERE id_vigilante = $valor";                    
                $this->conn->query($sql_suc_vig);

                $sql_reg = "INSERT INTO suc_vig (id_sucursal,id_vigilante ) VALUES (?,?)";
                $datos_Reg =array($id,$valor);
                $this-> save($sql_reg,$datos_Reg);

                // $sql_reg = "INSERT INTO suc_vig (id_sucursal,id_vigilante ) VALUES (?,?)";
                // $datos_Reg =array($data,$valor);
                // $this-> save($sql_reg,$datos_Reg);



               
            } 

            if(!empty($datasuc)){
                $res = "modificado";
            }else{
                $res ="error";
            }
            return $res;
        
        }
        // public function registrarSucursal(string $sucursal, int $id_institucion, string $id_vigilante, string $ciudad, string $direccion) {
        //     $this->sucursal=$sucursal;
        //     $this->id_institucion=$id_institucion;
        //     $this->id_vigilante=$id_vigilante;
        //     $this->ciudad=$ciudad;
        //     $this->direccion=$direccion;
        //     $verificar ="SELECT *FROM sucursales WHERE sucursal='$this->sucursal'";
        //     $existe =$this->select($verificar);
        //     if(empty($existe)){
        //             $ids = array_map('intval', explode(",", $id_vigilante)); 
        //             foreach ($ids as $valor) {
        //                 $sql = "UPDATE sucursales 
        //                 SET id_vigilante = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', id_vigilante, ','), ',$valor,', ','))
        //                 WHERE FIND_IN_SET($valor, id_vigilante) > 0";                    
        //                 $this->conn->query($sql);
        //             }
        //             $sql = "INSERT INTO sucursales (sucursal,id_institucion,id_vigilante,ciudad,direccion) VALUES (?,?,?,?,?)";
        //             $datos =array($this->sucursal,$this->id_institucion,$this->id_vigilante,$this->ciudad,$this->direccion);
        //             $data =  $this-> save($sql,$datos);
        //             if($data==1){
        //                 $res = "ok";
        //             }else{
        //                 $res = "error";
        //             }  
        //     }else {
        //         $res ="existe";
        //     }
        //     return $res;
        // }
                          
        // public function modificarSucursal(string $sucursal,int $id_institucion,string $id_vigilante,string $ciudad,string $direccion, int $id){
        //     $this->sucursal=$sucursal;
        //     $this->id_institucion=$id_institucion;
        //     $this->id_vigilante=$id_vigilante;
        //     $this->ciudad=$ciudad;
        //     $this->direccion=$direccion;
        //     $this->id=$id;
        //     $ids = array_map('intval', explode(",", $id_vigilante)); 
        //     foreach ($ids as $valor) {
        //         $sql = "UPDATE sucursales 
        //         SET id_vigilante = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', id_vigilante, ','), ',$valor,', ','))
        //         WHERE FIND_IN_SET($valor, id_vigilante) > 0";                    
        //         $this->conn->query($sql);
        //     }
    
        //     $vigilantes ="SELECT id_vigilante FROM sucursales WHERE id='$this->id'";
        //     $resultado =$this->select($vigilantes);
        //     $ids_actual = $resultado['id_vigilante'];
        //     $unidos = $ids_actual.','.$id_vigilante;

        //     $sql = "UPDATE sucursales SET sucursal=?,id_institucion=?,id_vigilante=?,ciudad=?,direccion=? WHERE id=?"; 
        //     $datos =array( $this->sucursal,$this->id_institucion,$unidos,$this->ciudad,$this->direccion,$this->id);
        //     $data =  $this-> save($sql,$datos);
        //     if($data==1){
        //         $res = "modificado";
        //     }else{
        //         $res ="error";
        //     }
        //     return $res;
        // }


        public function editarSucursal(int $id){
            $sql = "SELECT * FROM sucursales WHERE id=$id";
            $data= $this->select($sql);
            return $data;
        }

 
  
        public function accionInstitucion (int $estado,int $id){
            $this->id = $id;
            $this->estado = $estado;
            $sql ="UPDATE sucursales SET estado =? WHERE id=?";
            $datos=array($this->estado,$this->id);
            $data = $this->save($sql,$datos);
            return $data;
        }
    }
?> 
