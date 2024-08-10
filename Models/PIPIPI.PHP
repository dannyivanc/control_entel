        $sql=" SELECT * FROM vehiculos
            WHERE id_sucursal =? AND salida BETWEEN ? AND ?
            ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_sucursal, $inicio, $fin]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);



            $sql = "UPDATE usuarios SET usuario=?,nombre=?,carnet=?,clave=?,cel=?rol=?,id_institucion =? WHERE id=?";         
            $datos =array($this->usuario,$this->nombre,$this->carnet,$this->cel,$this->rol,$this->clave,$this->id_institucion,$this->id);
            $data =  $this-> save($sql,$datos);


            $sql = "INSERT INTO usuarios (usuario,nombre,carnet,clave,rol,cel,id_institucion) VALUES (?,?,?,?,?,?,?)";
                $datos =array($this->usuario,$this->nombre,$this->carnet,$this->clave,$this->rol,$this->cel,$this->id_institucion);
                $data =  $this-> save($sql,$datos);