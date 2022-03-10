<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/smartMpioApi/access.php');
include (CONECT_PATH.'cnx.php');///Cargar Datos
include (CLASS_PATH.'respuesta.php');///Cargar Datos

class metas extends cnx {

    public $dbtabla = 'metas';

    public function addMeta($json){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);
        if (!isset($readJson['user']) || !isset($readJson['des_meta']) || !isset($readJson['des_mcorta']) || !isset($readJson['des_objetivo'])) {
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

            $data = $this->addPoa($numDep, $des_meta, $des_mcorta, $des_objetivo, $tipo, $user, $cuantifica, $inicio, $fin);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function addPoa ($numDep, $des_meta, $des_mcorta, $des_objetivo, $tipo, $user, $cuantifica, $inicio, $fin){
        $sql = "CALL metaCreate('$numDep', '$des_meta', '$des_mcorta', '$des_objetivo', '$tipo', '$user', '$cuantifica', '$inicio', '$fin', 'metas')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])){
            return $query;
        }
    }

    public function editMeta ($json){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);
        if (!isset($readJson['user']) || !isset($readJson['idmeta']) || !isset($readJson['des_meta']) || !isset($readJson['des_mcorta']) || !isset($readJson['des_objetivo'])) {
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

            $data = $this->edtPoa($idmeta, $numDep, $des_meta, $des_mcorta, $des_objetivo, $tipo, $user, $cuantifica, $inicio, $fin, $edo);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }        
    }

    private function edtPoa($idmeta, $numDep, $des_meta, $des_mcorta, $des_objetivo, $tipo, $user, $cuantifica, $inicio, $fin, $edo){
        // $m = $this->$dbtablam;
        $sql = "CALL metaEdit('$idmeta', '$numDep', '$des_meta', '$des_mcorta', '$des_objetivo', '$tipo', '$user', '$cuantifica', '$inicio', '$fin', '$edo', 'metas')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])){
            return $query;
        }
    }


    public function deleteMeta($json){
        $_resp = new respuesta;
        $readJson = json_decode($json, true);
        if (!isset($readJson['idmeta']) || !isset($readJson['edo'])) {
            return $_resp->error_416();
        }else{
            $idmeta = $readJson['idmeta'];
            
            $data = $this->delMeta($idmeta);
            if ($data) {
                return $data;
            } else {
                return $_resp->error_409();
            }
        }
    }

    private function delMeta($id){
        $sql = "CALL deleteData('$id', 'metas')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code'])){
            return $query;
        }
    }
    

    public function listMetas($pag, $elem){
        $_resp = new respuesta;
        if ($pag >=1) {
            $data = $this->pageData($pag, $elem);
            // print_r($data);
            return $data;
        } else {
            return $_resp->error_416();
        }
    }
    
    public function viewtMetas($u){
        $_resp = new respuesta;
        if ($u >= 1) {
            $data = $this->dataShow($u);
            return $data;
        } else {
            return $_resp->error_416();
        }
    }

    private function pageData($p, $e){
        $t = $this->dbtabla;
        $sql = "CALL listData('$t', '$p', '$e')";
            $query = parent::getDataPa($sql);
            if (isset($query[0]['id'])) {
                return $query;
            }else{
                return false;
            }
    }

    private function dataShow($u){
        $t = $this->dbtabla;
        $sql = "CALL viewData('$t', '$u')";
            $query = parent::getDataPa($sql);
            return $query;
    }


}



?>