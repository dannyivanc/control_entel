<?php
    class Query extends Conexion{
    protected $conect;

    public function __construct() {
        $this->conect = new PDO("mysql:host=" . host . ";dbname=" . db, user, pass);
        $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function select($sql, $params = []) {
        $stmt = $this->conect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function selectAll($sql, $params = []) {
        $stmt = $this->conect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function save($sql, $params = []) {
        $stmt = $this->conect->prepare($sql);
        return $stmt->execute($params);
    }
}
?>