<?php
    class SucursalesModel extends Query{
        private $id,$sucursal,$id_institucion,$id_vigilante,$ciudad,$direccion,$estado;
        private $conn;
  
        public function __construct(){
            parent::__construct();
            $this->conn = new mysqli(host, user, pass, db);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset(charset);
          
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

            // $sql="SELECT s.*, i.id AS id_institucion, i.institucion, u.id AS id_vigilante, u.nombre AS vigilante
            // FROM sucursales AS s
            // INNER JOIN instituciones AS i ON s.id_institucion = i.id
            // LEFT JOIN usuarios AS u ON s.id_vigilante = u.id
            // ORDER BY s.id DESC;";            
            // $data= $this->selectAll($sql);
            // return $data;

                // Consulta para obtener las sucursales
            $sql = "SELECT s.*, i.id AS id_institucion, i.institucion, s.id_vigilante
            FROM sucursales AS s
            INNER JOIN instituciones AS i ON s.id_institucion = i.id
            ORDER BY s.id DESC";    

            $sucursales = $this->selectAll($sql);

            // Si no hay sucursales, retorna inmediatamente
            if (empty($sucursales)) {
            return $sucursales;
            }

            // Obtener todos los IDs de vigilantes únicos
            $vigilante_ids = [];
            foreach ($sucursales as $sucursal) {
            $ids = explode(',', $sucursal['id_vigilante']);
            foreach ($ids as $id) {
                $vigilante_ids[] = intval($id);
            }
            }

            $vigilante_ids = array_unique($vigilante_ids);
            if (empty($vigilante_ids)) {
            return $sucursales; // Si no hay IDs de vigilantes, retornar directamente las sucursales
            }

            $id_list = implode(',', $vigilante_ids);

            // Consulta para obtener los nombres de los vigilantes
            $sql = "SELECT id, nombre AS vigilante FROM usuarios WHERE id IN ($id_list)";
            $vigilantes = $this->selectAll($sql);

            // Mapear los vigilantes por su ID
            $vigilante_map = [];
            foreach ($vigilantes as $vigilante) {
            $vigilante_map[$vigilante['id']] = $vigilante['vigilante'];
            }

            // Asociar los nombres de los vigilantes con las sucursales
            foreach ($sucursales as &$sucursal) {
            $ids = explode(',', $sucursal['id_vigilante']);
            $sucursal['vigilantes'] = [];
            foreach ($ids as $id) {
                if (isset($vigilante_map[intval($id)])) {
                    $sucursal['vigilantes'][] = $vigilante_map[intval($id)];
                }
            }
            }
            return $sucursales;
        }
        


        // public function registrarSucursal(string $sucursal,int $id_institucion,string $id_vigilante,string $ciudad,string $direccion){          
        //     $this->sucursal=$sucursal;
        //     $this->id_institucion=$id_institucion;
        //     $this->id_vigilante=$id_vigilante;
        //     $this->ciudad=$ciudad;
        //     $this->direccion=$direccion;
        //     $verificar ="SELECT *FROM sucursales WHERE sucursal='$this->sucursal'";
        //     $existe =$this->select($verificar);
        //     // if(empty($existe)){
        //     //         $res="'asd";

        //             // $sql = "INSERT INTO sucursales (sucursal,id_institucion,id_vigilante,ciudad,direccion) VALUES (?,?,?,?,?)";
        //             // $datos =array($this->sucursal,$this->id_institucion,$this->id_vigilante,$this->ciudad,$this->direccion);
        //             // $data =  $this-> save($sql,$datos);
        //             // if($data==1){
        //             //     $res = "ok";
        //             // }else{
        //             //     $res = "error";
        //             // }
                    
                
        //     // }else {
        //     //     $res ="existe";
        //     // }
        //     return $existe;
        // }
        // public function registrarSucursal(string $sucursal, int $id_institucion, string $id_vigilante, string $ciudad, string $direccion) {
        //     $this->sucursal = $sucursal;
        //     $this->id_institucion = $id_institucion;
        //     $this->id_vigilante = $id_vigilante;
        //     $this->ciudad = $ciudad;
        //     $this->direccion = $direccion;
        
        //     // Verificar si la sucursal ya existe
        //     $verificar = "SELECT * FROM sucursales WHERE sucursal = ?";
        //     $existe = $this->select($verificar, [$this->sucursal]);
        
        //     if (empty($existe)) {
        //         // Verificar y eliminar vigilante de otras sucursales
        //         $vigilante_ids = explode(',', $this->id_vigilante);
        //         foreach ($vigilante_ids as $id) {
        //             $id = intval($id);
        //             $verificar_vigilante = "SELECT * FROM sucursales WHERE FIND_IN_SET(?, id_vigilante)";
        //             $sucursal_con_vigilante = $this->select($verificar_vigilante, [$id]);
        
        //             if (!empty($sucursal_con_vigilante)) {
        //                 // Remover el vigilante de la sucursal anterior
        //                 $id_sucursal_anterior = $sucursal_con_vigilante['id'];
        //                 $id_vigilante_anterior = $sucursal_con_vigilante['id_vigilante'];
        //                 $id_vigilante_anterior_array = explode(',', $id_vigilante_anterior);
        //                 $id_vigilante_anterior_array = array_diff($id_vigilante_anterior_array, [$id]);
        
        //                 // Asegurarse de que el array es correcto antes de usar implode
        //                 if (!empty($id_vigilante_anterior_array)) {
        //                     $id_vigilante_anterior = implode(',', $id_vigilante_anterior_array);
        //                 } else {
        //                     $id_vigilante_anterior = '';
        //                 }
        
        //                 $actualizar_vigilante = "UPDATE sucursales SET id_vigilante = ? WHERE id = ?";
        //                 $this->save($actualizar_vigilante, [$id_vigilante_anterior, $id_sucursal_anterior]);
        //             }
        //         }
        
        //         // Insertar la nueva sucursal
        //         $sql = "INSERT INTO sucursales (sucursal, id_institucion, id_vigilante, ciudad, direccion) VALUES (?, ?, ?, ?, ?)";
        //         $datos = [$this->sucursal, $this->id_institucion, $this->id_vigilante, $this->ciudad, $this->direccion];
        //         $data = $this->save($sql, $datos);
        
        //         if ($data == 1) {
        //             $res = "ok";
        //         } else {
        //             $res = "error";
        //         }
        //     } else {
        //         $res = "existe";
        //     }
        //     return $res;
        // }
        // public function registrarSucursal(string $sucursal, int $id_institucion, string $id_vigilante, string $ciudad, string $direccion) {
        //     $this->sucursal = $sucursal;
        //     $this->id_institucion = $id_institucion;
        //     $this->id_vigilante = $id_vigilante;
        //     $this->ciudad = $ciudad;
        //     $this->direccion = $direccion;
        
        //     // Verificar si la sucursal ya existe
        //     $verificar = "SELECT * FROM sucursales WHERE sucursal = ?";
        //     $existe = $this->select($verificar, [$this->sucursal]);
        
        //     if (empty($existe)) {
        //         // Verificar y eliminar vigilante de otras sucursales
        //         $vigilante_ids = explode(',', $this->id_vigilante);
        //         foreach ($vigilante_ids as $id) {
        //             $id = intval($id);
        //             $verificar_vigilante = "SELECT * FROM sucursales WHERE FIND_IN_SET(?, id_vigilante)";
        //             $sucursal_con_vigilante = $this->select($verificar_vigilante, [$id]);
        
        //             if (!empty($sucursal_con_vigilante)) {
        //                 // Remover el vigilante de la sucursal anterior
        //                 $id_sucursal_anterior = $sucursal_con_vigilante['id'];
        //                 $id_vigilante_anterior = $sucursal_con_vigilante['id_vigilante'];
        //                 $id_vigilante_anterior_array = explode(',', $id_vigilante_anterior);
        
        //                 // Eliminar el vigilante actual de la lista anterior
        //                 $key = array_search($id, $id_vigilante_anterior_array);
        //                 if ($key !== false) {
        //                     unset($id_vigilante_anterior_array[$key]);
        //                 }
        
        //                 // Reindexar el array después de la eliminación
        //                 $id_vigilante_anterior_array = array_values($id_vigilante_anterior_array);
        
        //                 // Convertir el array de IDs de vigilantes de nuevo a cadena
        //                 $id_vigilante_anterior = implode(',', $id_vigilante_anterior_array);
        
        //                 // Actualizar la base de datos con la nueva lista de vigilantes
        //                 $actualizar_vigilante = "UPDATE sucursales SET id_vigilante = ? WHERE id = ?";
        //                 $this->save($actualizar_vigilante, [$id_vigilante_anterior, $id_sucursal_anterior]);
        //             }
        //         }
        
        //         // Insertar la nueva sucursal
        //         $sql = "INSERT INTO sucursales (sucursal, id_institucion, id_vigilante, ciudad, direccion) VALUES (?, ?, ?, ?, ?)";
        //         $datos = [$this->sucursal, $this->id_institucion, $this->id_vigilante, $this->ciudad, $this->direccion];
        //         $data = $this->save($sql, $datos);
        
        //         if ($data == 1) {
        //             $res = "ok";
        //         } else {
        //             $res = "error";
        //         }
        //     } else {
        //         $res = "existe";
        //     }
        //     return $res;
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
                    $ids = array_map('intval', explode(",", $id_vigilante)); 
                    foreach ($ids as $valor) {
                        $sql = "UPDATE sucursales 
                        SET id_vigilante = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', id_vigilante, ','), ',$valor,', ','))
                        WHERE FIND_IN_SET($valor, id_vigilante) > 0";                    
                        $this->conn->query($sql);
                    }
                    $sql = "INSERT INTO sucursales (sucursal,id_institucion,id_vigilante,ciudad,direccion) VALUES (?,?,?,?,?)";
                    $datos =array($this->sucursal,$this->id_institucion,$this->id_vigilante,$this->ciudad,$this->direccion);
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
                          
        public function modificarSucursal(string $sucursal,int $id_institucion,string $id_vigilante,string $ciudad,string $direccion, int $id){
            $this->sucursal=$sucursal;
            $this->id_institucion=$id_institucion;
            $this->id_vigilante=$id_vigilante;
            $this->ciudad=$ciudad;
            $this->direccion=$direccion;
            $this->id=$id;

            // $updateVi = "UPDATE sucursales SET id_vigilante = NULL WHERE id_vigilante = ?";
            // $dataVi = array($this->id_vigilante);
            // $this->save($updateVi, $dataVi);
            $ids = array_map('intval', explode(",", $id_vigilante)); 
            foreach ($ids as $valor) {
                $sql = "UPDATE sucursales 
                SET id_vigilante = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', id_vigilante, ','), ',$valor,', ','))
                WHERE FIND_IN_SET($valor, id_vigilante) > 0";                    
                $this->conn->query($sql);
            }
    
            $vigilantes ="SELECT id_vigilante FROM sucursales WHERE id='$this->id'";
            $resultado =$this->select($vigilantes);
            $ids_actual = $resultado['id_vigilante'];
            $unidos = $ids_actual.','.$id_vigilante;

            $sql = "UPDATE sucursales SET sucursal=?,id_institucion=?,id_vigilante=?,ciudad=?,direccion=? WHERE id=?"; 
            $datos =array( $this->sucursal,$this->id_institucion,$unidos,$this->ciudad,$this->direccion,$this->id);
            $data =  $this-> save($sql,$datos);
            if($data==1){
                $res = "modificado";
            }else{
                $res ="error";
            }
            return $res;
        }


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
