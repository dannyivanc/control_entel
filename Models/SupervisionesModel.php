<?php
    class SupervisionesModel extends Query{
        private $id,$fecha,$movimiento,$persona,$destino,$descripcion,$observacion,$id_sucursal,$id_vigilante;
  
        public function __construct(){
            parent::__construct();
        }

        public function getInstituciones(){
            $sql="SELECT * FROM instituciones WHERE estado = 1";
            $data= $this->selectAll($sql);
            return $data;
        }    
        
        public function getSucursal(int $id){
            $sql="SELECT su.id,su.sucursal,su.id_institucion,inst.institucion  FROM sucursales as su
            INNER JOIN instituciones as inst ON su.id_institucion = inst.id
            INNER JOIN suc_vig ON su.id = suc_vig.id_sucursal
            WHERE suc_vig.id_vigilante = $id";
            $data= $this->select($sql);
            return $data;
        }           
             
    }
?> 
