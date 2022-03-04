<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/smartMpioApi/access.php'); ///Conecion General Al ROOT
include (CONECT_PATH.'cnx.php');///Cargar Datos
include (CLASS_PATH.'respuesta.php');///Cargar Datos

class users extends cnx{

    private $dbtabla = 'usuarios';
    
    public function addUser($json){
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

               $data = $this->regUser($numDep, $usr, $nombre, $cargo, $area, $psw, $estatus);
               if ($data) {
                   return $data;
                }else{
                   return $_resp->error_401();
               }
        }
    }

    private function regUser($numDep, $usr, $nombre, $cargo, $area, $psw, $estatus){
        $password = password_hash($psw, PASSWORD_DEFAULT);
        $sql = "CALL regUser('$numDep', '$usr', '$nombre', '$cargo', '$area', '$password', '$estatus')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code']) && isset($query[0]['code_msg'])) {
            return $query;
        }else{
            return false;
        }
    }

    public function listUsers($pag, $elem){
        $_resp = new respuesta;
        // return "Se muestran ".$elem. " elementos en la pag ". $pag;
        if ($pag >=1) {
            $data = $this->pageUsers($pag, $elem);
            // print_r($data);
            return $data;
        } else {
            return $_resp->error_416();
        }


    }

    private function pageUsers($p, $e){
        $t = $this->dbtabla;
        $sql = "CALL listUsers('$t', '$p', '$e')";
        // print_r($sql);
            $query = parent::getDataPa($sql);
            // echo $query[0]['id'];
            if (isset($query[0]['id'])) {
                return $query;
            }else{
                return false;
            }
    }

    
    public function viewtUser($u){
        // $_resp = new respuesta;
        if ($u >= 1) {
            $data = $this->dataUser($u);
            return $data;
        }
    }

    private function dataUser($u){
        $t = $this->dbtabla;
        $sql = "CALL dataUser('$t', '$u')";
            $query = parent::getDataPa($sql);
            $logg = array_slice($query[0], 0, 10);
            return $logg;
    }
    
    public function editUser($json){
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

            $data = $this->updateUser($id, $numDep, $nombre, $cargo, $area, $pswn, $estatus);
            return $data;
        }
    }

    private function updateUser($id, $numDep, $nombre, $cargo, $area, $pswn, $estatus){
        $t = $this->dbtabla;
        if ($pswn == '') {
            $password = '';
        }else{
            $password = password_hash($pswn, PASSWORD_DEFAULT);
        }

        $sql = "CALL userUpdate('$id', '$numDep', '$nombre', '$cargo', '$area', '$password', '$estatus', '$t')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code']) && isset($query[0]['code_msg'])) {
            return $query;
        }else{
            return $query;
            // return false;
        }
    }

    public function deleteUser($json){
        $_resp = new respuesta;
        $info = json_decode($json, true);
        if (!isset($info['id'])) {
            return $_resp->error_416();
        } else {
            $id = $info['id'];

            $data = $this->userErase($id);
            return $data;
        }
    }

    private function userErase($id){
        $t = $this->dbtabla;
        $sql = "CALL deleteData('$id', '$t')";
        $query = parent::getDataPa($sql);
        if (isset($query[0]['code']) && isset($query[0]['code_msg'])) {
            return $query;
        }
    }

}


?>