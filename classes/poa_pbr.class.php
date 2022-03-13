<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/smartMpioApi/access.php');
include (CONECT_PATH.'cnx.php');///Cargar Datos
include (CLASS_PATH.'respuesta.php');///Cargar Datos

class metas extends cnx {

    public $dbtabla = 'metas';

    public function addMeta($json, $header){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);
        if (!isset($readJson['user']) || !isset($readJson['des_meta']) || !isset($readJson['des_mcorta']) || !isset($readJson['des_objetivo']) || !isset($header['x-access-token'])) {
            return $_resp->error_416();
        } else {
            $numDep = $readJson['numDep'];
            $des_meta = $readJson['des_meta'];
            $des_mcorta = $readJson['des_mcorta'];
            $des_objetivo = $readJson['des_objetivo'];
            $tipo = $readJson['tipo'];
            $cuantifica = $readJson['cuantifica'];
            $user = $readJson['user'];
            $inicio = $readJson['inicio'];
            $fin = $readJson['fin'];
            $tk = $header['x-access-token'];

            $data = $this->addPoa($numDep, $des_meta, $des_mcorta, $des_objetivo, $tipo, $user, $cuantifica, $inicio, $fin, $tk);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function addPoa ($numDep, $des_meta, $des_mcorta, $des_objetivo, $tipo, $user, $cuantifica, $inicio, $fin, $tk){
        $t = $this->dbtabla;
        $sql = "CALL metaCreate('$numDep', '$des_meta', '$des_mcorta', '$des_objetivo', '$tipo', '$user', '$cuantifica', '$inicio', '$fin', '$t', '$tk')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])){
            return $query;
        }
    }

    public function editMeta ($json, $header){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);
        if (!isset($header['x-access-token']) || !isset($readJson['user']) || !isset($readJson['idmeta']) || !isset($readJson['des_meta']) || !isset($readJson['des_mcorta']) || !isset($readJson['des_objetivo'])) {
            return $_resp->error_416();
        } else {
            $idmeta = $readJson['idmeta'];
            $numDep = $readJson['numDep'];
            $des_meta = $readJson['des_meta'];
            $des_mcorta = $readJson['des_mcorta'];
            $des_objetivo = $readJson['des_objetivo'];
            $tipo = $readJson['tipo'];
            $user = $readJson['user'];
            $cuantifica = $readJson['cuantifica'];
            $inicio = $readJson['inicio'];
            $fin = $readJson['fin'];
            $edo = $readJson['edo'];
            $token = $header['x-access-token'];

            $data = $this->edtPoa($idmeta, $numDep, $des_meta, $des_mcorta, $des_objetivo, $tipo, $user, $cuantifica, $inicio, $fin, $edo, $token);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }        
    }

    private function edtPoa($idmeta, $numDep, $des_meta, $des_mcorta, $des_objetivo, $tipo, $user, $cuantifica, $inicio, $fin, $edo, $token){
        $t = $this->dbtablam;
        $sql = "CALL metaEdit('$idmeta', '$numDep', '$des_meta', '$des_mcorta', '$des_objetivo', '$tipo', '$user', '$cuantifica', '$inicio', '$fin', '$edo', '$t', '$token')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])){
            return $query;
        }
    }


    public function deleteMeta($json, $header){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);
        if (!isset($header['x-access-token']) || !isset($readJson['idmeta']) || !isset($readJson['edo']) || !isset($readJson['user'])) {
            return $_resp->error_416();
        }else{
            $idmeta = $readJson['idmeta'];
            $token = $header['x-access-token'];
            
            $data = $this->delMeta($idmeta, $token);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function delMeta($id, $tk){
        $t = $this->dbtabla;
        $sql = "CALL deleteData('$id', '$t', '$tk')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])){
            return $query;
        }
    }
    

    public function listMetas($pag, $elem, $token){
        $_resp = new respuesta;
        if ($pag >=1) {
            $data = $this->pageData($pag, $elem, $token);
            // print_r($data);
            return $data;
        } else {
            return $_resp->error_416();
        }
    }
    
    public function viewtMetas($u, $token){
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
            $query = parent::getDataPa($sql);
            return $query;
    }


}



?>