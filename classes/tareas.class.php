<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/smartMpioApi/access.php');
include (CONECT_PATH.'cnx.php');///Cargar Datos
include (CLASS_PATH.'respuesta.php');///Cargar Datos

class tareas extends cnx{

    public $dbtabla = 'tareas';

    public function addTarea($json, $header){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);

        if (!isset($header['x-access-token']) || !isset($readJson['user']) || !isset($readJson['meta']) || !isset($readJson['sla'])) {
            return $_resp->error_416();
        } else {
            $poa = $readJson['meta'];
            $descripcion = $readJson['descripcion'];
            $sla = $readJson['sla'];
            $costo = $readJson['costo'];
            $descripcion_corta = $readJson['descripcion_corta'];
            $recurencia = $readJson['recurencia'];
            $auto_generar = $readJson['auto_generar'];
            $usr = $readJson['user'];
            $token = $header['x-access-token'];

            $data = $this->createTarea($poa, $descripcion, $sla, $costo, $descripcion_corta, $recurencia, $auto_generar, $usr, $token);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function createTarea($poa, $descripcion, $sla, $costo, $descripcion_corta, $recurencia, $auto_generar, $usr, $token){
        $t = $this->dbtabla;
        $sql = "CALL tareaCreate('$poa', '$descripcion', '$sla', '$costo', '$descripcion_corta', '$recurencia', '$auto_generar', '$usr', '$t', '$token')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])) {
            return $query;
        }
    }

    public function editTarea($json, $header){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);

        if (!isset($header['x-access-token']) || !isset($readJson['user']) || !isset($readJson['id'])) {
            return $_resp->error_416();
        } else {
            $tarea = $readJson['id'];
            $poa = $readJson['meta'];
            $descripcion = $readJson['descripcion'];
            $sla = $readJson['sla'];
            $costo = $readJson['costo'];
            $descripcion_corta = $readJson['descripcion_corta'];
            $recurencia = $readJson['recurencia'];
            $auto_generar = $readJson['auto_generar'];
            $usr = $readJson['user'];
            $status = $readJson['status'];
            $token = $header['x-access-token'];

            $data = $this->modTarea($tarea, $poa, $descripcion, $sla, $costo, $descripcion_corta, $recurencia, $auto_generar, $usr, $status, $token);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function modTarea($tarea, $poa, $descripcion, $sla, $costo, $descripcion_corta, $recurencia, $auto_generar, $usr, $status, $token){
        $t = $this->dbtabla;
        $sql = "CALL tareaEdit('$tarea', '$poa', '$descripcion', '$sla', '$costo', '$descripcion_corta', '$recurencia', '$auto_generar', '$status', '$usr', '$t', '$token')";
        // print_r($sql);
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])) {
            return $query;
        }

    }

    public function listTareas($pag, $elem, $token){
        $_resp = new respuesta;
        if ($pag >=1) {
            $data = $this->pageData($pag, $elem, $token);
            return $data;
        } else {
            return $_resp->error_416();
        }
    }
    
    public function viewtTarea($u, $token){
        $_resp = new respuesta;
        if ($u >= 1) {
            $data = $this->dataShow($u, $token);
            return $data;
        } else {
            return $_resp->error_416();
        }
    }

    private function pageData($p, $e, $tk){
        $t = $this->dbtabla;
        $sql = "CALL listData('$t', '$p', '$e', '$tk')";
        // print_r($sql);
            $query = parent::getDataPa($sql);
            if (isset($query[0]['id'])) {
                return $query;
            }else{
                return false;
            }
    }

    private function dataShow($u, $tk){
        $t = $this->dbtabla;
        $sql = "CALL viewData('$t', '$u', '$tk')";
        // print_r($sql);
            $query = parent::getDataPa($sql);
            return $query;
    }   


    
}

?>