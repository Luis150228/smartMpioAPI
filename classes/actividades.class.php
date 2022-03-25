<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/smartMpioApi/access.php');
include (CONECT_PATH.'cnx.php');///Cargar Datos
include (CLASS_PATH.'respuesta.php');///Cargar Datos

class actividades extends cnx{
    public $dbtabla = 'actividad';

    public function addActividad($json, $header){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);

        if (!isset($header['x-access-token']) || !isset($readJson['tarea']) || !isset($readJson['user']) || !isset($readJson['nombres']) || !isset($readJson['asignado'])) {
            return $_resp->error_416();
        } else {
            $tarea = $readJson['tarea'];
            $descripcion = $readJson['descripcion'];
            $nombres = $readJson['nombres'];
            $paterno = $readJson['paterno'];
            $materno = $readJson['materno'];
            $curp = $readJson['curp'];
            $direccion = $readJson['direccion'];
            $colonia = $readJson['colonia'];
            $telefono = $readJson['telefono'];
            $mail = $readJson['mail'];
            $importe = $readJson['importe'];
            $user = $readJson['user'];
            $asignado = $readJson['asignado'];
            $obs = $readJson['observaciones'];
            $token = $header['x-access-token'];
        
            $data = $this->createActividad($tarea,$descripcion, $nombres, $paterno, $materno, $curp, $direccion, $colonia, $telefono, $mail, $importe, $user, $asignado, $obs, $token);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function createActividad($tarea,$descripcion, $nombres, $paterno, $materno, $curp, $direccion, $colonia, $telefono, $mail, $importe, $user, $asignado, $obs, $token){
        $t = $this->dbtabla;
        $sql = "CALL actCreate('$tarea', '$descripcion', '$nombres', '$paterno', '$materno', '$curp', '$direccion', '$colonia', '$telefono', '$mail', '$importe', '$user', '$asignado', '$obs', '$t', '$token')";
        // print_r($sql);
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])) {
            return $query;
        }
    }

    public function editActividad($json, $header){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);

        if (!isset($header['x-access-token']) || !isset($readJson['id']) || !isset($readJson['user']) || !isset($readJson['nombres']) || !isset($readJson['asignado'])) {
            return $_resp->error_416();
        } else {
            $id = $readJson['id'];
            $tarea = $readJson['tarea'];
            $descripcion = $readJson['descripcion'];
            $nombres = $readJson['nombres'];
            $paterno = $readJson['paterno'];
            $materno = $readJson['materno'];
            $curp = $readJson['curp'];
            $direccion = $readJson['direccion'];
            $colonia = $readJson['colonia'];
            $telefono = $readJson['telefono'];
            $mail = $readJson['mail'];
            $importe = $readJson['importe'];
            $user = $readJson['user'];
            $asignado = $readJson['asignado'];
            $estatus = $readJson['estatus'];
            $obs = $readJson['observaciones'];
            $token = $header['x-access-token'];
        
            $data = $this->modActividad($id, $tarea,$descripcion, $nombres, $paterno, $materno, $curp, $direccion, $colonia, $telefono, $mail, $importe, $user, $asignado, $estatus, $obs, $token);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function modActividad($id, $tarea,$descripcion, $nombres, $paterno, $materno, $curp, $direccion, $colonia, $telefono, $mail, $importe, $user, $asignado, $estatus, $obs, $token){
        $t = $this->dbtabla;
        $sql = "CALL actEdit('$id', '$tarea', '$descripcion', '$nombres', '$paterno', '$materno', '$curp', '$direccion', '$colonia', '$telefono', '$mail', '$importe', '$user', '$asignado', '$estatus', '$obs', '$t', '$token')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])) {
            return $query;
        }
    }

    public function listActividades($pag, $elem, $token){
        $_resp = new respuesta;
        if ($pag >=1) {
            $data = $this->pageData($pag, $elem, $token);
            return $data;
        } else {
            return $_resp->error_416();
        }
    }
    
    public function viewtActividad($u, $token){
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
            if (isset($query[0]['code'])) {
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