<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/smartMpioApi/access.php');
include_once (ROOT_PATH.'/access.php');///Root
include (CONECT_PATH.'cnx.php');///Cargar Datos
include (CLASS_PATH.'respuesta.php');///Cargar Datos

class users extends cnx{

    private $dbtabla = 'usuarios';
    
    public function addUser($json, $header){
        $_resp = new respuesta;
        $info = json_decode($json, true);
        if ( !isset($info['numDep']) || !isset($info['usr']) || !isset($info['psw']) ) {
            // return $info['usr'];
            return $_resp->error_416();
        }else{
               $numDep = $info['numDep'];
               $usr = $info['usr'];
               $nombre = $info['nombre'];
               $cargo = $info['cargo'];
               $area = $info['area'];
               $psw = $info['psw'];
               $estatus = $info['estatus'];
               $token = $header['x-access-token'];

               $data = $this->regUser($numDep, $usr, $nombre, $cargo, $area, $psw, $estatus, $token);
               if ($data) {
                   return $data;
                }else{
                   return $_resp->error_401();
               }
        }
    }

    private function regUser($numDep, $usr, $nombre, $cargo, $area, $psw, $estatus, $tk){
        $password = password_hash($psw, PASSWORD_DEFAULT);
        $sql = "CALL regUser('$numDep', '$usr', '$nombre', '$cargo', '$area', '$password', '$estatus', '$tk')";
        // print_r($sql);
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code']) && isset($query[0]['code_msg'])) {
            return $query;
        }else{
            return false;
        }
    }

    public function listUsers($pag, $elem, $token){
        // return "Se muestran ".$elem. " elementos en la pag ". $pag;
        if ($pag >=1) {
            $data = $this->pageUsers($pag, $elem, $token);
            return $data;
        }


    }

    private function pageUsers($p, $e, $tk){
        $t = $this->dbtabla;
        $sql = "CALL listData('$t', '$p', '$e', '$tk')";
        $query = parent::getDataPa($sql);
        
        return $query;
        
    }

    
    public function viewtUser($u, $tk){
        // $_resp = new respuesta;
        if ($u >= 1) {
            $data = $this->dataUser($u, $tk);
            return $data;
        }
    }
    
    private function dataUser($u, $tk){
        $t = $this->dbtabla;
        $sql = "CALL viewData('$t', '$u', '$tk')";
        // print_r($sql);
            $query = parent::getDataPa($sql);
            $logg = array_slice($query[0], 0, 10);
            return $logg;
    }
    
    public function editUser($json, $header){
        $_resp = new respuesta;
        $info = json_decode($json, true);
        if (!isset($info['id'])) {
            return $_resp->error_416();
        } else {
            $id = $info['id'];
            $numDep = $info['numDep'];
            $nombre = $info['nombre'];
            $cargo = $info['cargo'];
            $area = $info['area'];
            $pswn = $info['psw'];
            $estatus = $info['estatus'];
            $token = $header['x-access-token'];

            $data = $this->updateUser($id, $numDep, $nombre, $cargo, $area, $pswn, $estatus, $token);
            return $data;
        }
    }

    private function updateUser($id, $numDep, $nombre, $cargo, $area, $pswn, $estatus, $token){
        $t = $this->dbtabla;
        if ($pswn == '') {
            $password = '';
        }else{
            $password = password_hash($pswn, PASSWORD_DEFAULT);
        }

        $sql = "CALL userUpdate('$id', '$numDep', '$nombre', '$cargo', '$area', '$password', '$estatus', '$t', '$token')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code']) && isset($query[0]['code_msg'])) {
            return $query;
        }else{
            return $query;
            // return false;
        }
    }

    public function deleteUser($json, $header){
        $_resp = new respuesta;
        $info = json_decode($json, true);
        if (!isset($info['id']) && !$header['x-access-token']) {
            return $_resp->error_416();
        } else {
            $id = $info['id'];
            $token = $header['x-access-token'];
            $data = $this->userErase($id, $token);
            return $data;
        }
    }

    private function userErase($id, $tk){
        $t = $this->dbtabla;
        $sql = "CALL deleteData('$id', '$t', '$tk')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code']) && isset($query[0]['code_msg'])) {
            return $query;
        }
    }

}


?>