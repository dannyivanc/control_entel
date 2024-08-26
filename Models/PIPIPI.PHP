            $sql=" SELECT * FROM vehiculos
            WHERE id_sucursal =? AND salida BETWEEN ? AND ?
            ORDER BY id DESC";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id_sucursal, $inicio, $fin]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);



            $sql = "INSERT INTO patrullaje (fecha,lat,lng,descripcion,id_sucursal,id_supervisor) VALUES (?,?,?,?,?,?)";
            $stmt = $this->conect->prepare($sql);
            $stmt-> execute([$fecha,$lat,$lng,$descripcion,$id_sucursal,$id_supervisor]);
            $data = $stmt->rowCount();


            $sql = "UPDATE patrullaje SET descripcion=?,id_sucursal=? WHERE id=?"; 
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$descripcion,$id_sucursal,$id]);


            $sql = "DELETE FROM patrullaje WHERE id = ?";
            $stmt = $this->conect->prepare($sql);
            $stmt->execute([$id]);