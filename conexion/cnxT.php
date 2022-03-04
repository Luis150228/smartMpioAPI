<?php

class cnx{
    private $dns;
    private $user;
    private $password;
    private $conn;

// Realizamos la conexion
    function __construct()
    {
        $keys = $this->datoscnx();

        foreach($keys as $key => $value){
            $this->dns = $value['dns'];
            $this->user = $value['user'];
            $this->password = $value['password'];
        }

        $opciones = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        );

        try{
            $this->conn = new PDO($this->dns,$this->user,$this->password, $opciones);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, );
            // if ($this->conn) {
            //     echo "Conexion Exitosa";
            // };
        }
        catch(PDOException $e){
            echo "PDO error ".$e->getMessage();
            die();
        }
    }

//Conectamos con el archivo config
    private function datoscnx(){
        $locfile = dirname(__FILE__);
        $jsondata = file_get_contents($locfile . "/" . "config" );
        return json_decode($jsondata, true);
    }


//Consulta de Datos
    public function getData($sql)
    {
 
        $data = array();
        $result = $this->conn->query($sql);
 
        $error = $this->conn->errorInfo();
        if ($error[0] === "00000") {
            $result->execute();
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    array_push($data, $row);
                }
            }
        } else {
            throw new Exception($error[2]);
        }
        return $data;
    }

//Numero de Filas
    public function numRows($sql)
    {
        $result = $this->conn->query($sql);
        $error = $this->conn->errorInfo();

        if ($error[0] === "00000") {
            $result->execute();
            return $result->rowCount();
        } else {
            throw new Exception($error[2]);
        }
    }

//Mostrar solo un registro
    public function getDataSingle($sql)
    {

        $result = $this->conn->query($sql);

        $error = $this->conn->errorInfo();

        if ($error[0] === "00000") {
            $result->execute();
            if ($result->rowCount() > 0) {
                return $result->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            throw new Exception($error[2]);
        }
        return null;
    }

//Ejecutar Instruccion
    public function validaQuery($sql)
    {
 
        $result = $this->conn->query($sql);

        $error = $this->conn->errorInfo();
 
        // if ($error[0] === "00000") {
        //     $result->execute();
        //     return $result->rowCount() > 0;
        // } else {
        //     throw new Exception($error[2]);
        // }

        if ($error[0] === "00000") {
            $result->execute();
            return $result->rowCount() > 0;
        } else {
            throw new Exception($error[2]);
        }
    }

//Cerrar Conexion
    public function close()
    {
        $this->conn = null;
    }

//Ulti
    public function getLastId()
    {
        return $this->conn->lastInsertId();
    }
 
}

?>