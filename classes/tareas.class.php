<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/smartMpioApi/access.php');
include (CONECT_PATH.'cnx.php');///Cargar Datos
include (CLASS_PATH.'respuesta.php');///Cargar Datos

class tareas extends cnx{

    public $tabla = 'tareas';

    public function addTarea($json){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);

        if (!isset($readJson['user']) || !isset($readJson['numDep']) || !isset($readJson['meta']) || !isset($readJson['tipo'])) {
            return $_resp->error_416();
        } else {
            $dep = $readJson['iddependencia'];
            $poa = $readJson['idpoa_pbr'];
            $descripcion = $readJson['descripcion'];
            $tipo = $readJson['tipo'];
            $sla = $readJson['sla'];
            $costo = $readJson['costo'];
            $descripcion_corta = $readJson['descripcion_corta'];
            $usr = $readJson['usr'];
            $data = $this->createTarea($dep, $poa, $descripcion, $tipo, $sla, $costo, $descripcion_corta, $usr);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function createTarea($depend, $poa, $descripcion, $tipo, $sla, $costo, $descripcion_corta, $usr){
        $t = $this->tabla;
        $sql = "CALL ('$depend', '$poa', '$descripcion', '$tipo', '$sla', '$costo', '$descripcion_corta', '$usr', '$t')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])) {
            return $query;
        }

    }

    public function editTarea($json){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);

        if (!isset($readJson['user']) || !isset($readJson['numDep']) || !isset($readJson['meta']) || !isset($readJson['tipo'])) {
            return $_resp->error_416();
        } else {
            $dep = $readJson['iddependencia'];
            $poa = $readJson['idpoa_pbr'];
            $descripcion = $readJson['descripcion'];
            $tipo = $readJson['tipo'];
            $sla = $readJson['sla'];
            $costo = $readJson['costo'];
            $descripcion_corta = $readJson['descripcion_corta'];
            $usr = $readJson['usr'];
            $status = $readJson['status'];

            $data = $this->modTarea($dep, $poa, $descripcion, $tipo, $sla, $costo, $descripcion_corta, $usr, $status);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function modTarea($depend, $poa, $descripcion, $tipo, $sla, $costo, $descripcion_corta, $usr, $status){
        $t = $this->tabla;
        $sql = "CALL ('$depend', '$poa', '$descripcion', '$tipo', '$sla', '$costo', '$descripcion_corta', '$usr', '$status', '$t')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])) {
            return $query;
        }

    }


    
}

?>