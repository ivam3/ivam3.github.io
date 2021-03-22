<?php

class Conexion {
    private $servidor = "0.0.0.0";
    private $usuario = "user";
    private $contrasena = "password";
    private $based = "databasename";
    private $conn;
    public function conectar() {
        $this->conn = new mysqli(
                $this->servidor, $this->usuario, $this->contrasena, $this->based
        );
        if ($this->conn->connect_errno) {
            echo "Fallo al contenctar a MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error;
        }
//        echo $this->conn->host_info . "\n";
    }
    public function desconectar() {
        self::conectar();
        $this->conn->close();
    }
}
$ejemplo = new Conexion();
$ejemplo->conectar();
?>
