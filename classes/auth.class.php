<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/smartMpioApi/access.php');
include (CONECT_PATH.'cnx.php');///Cargar Datos
include (CLASS_PATH.'respuesta.php');///Cargar Datos

class auth extends cnx{
    public function login($json){
        $_resp = new respuesta;
        $info = json_decode($json, true);
        if ( !isset($info['user']) || !isset($info['pass']) ) {
           //Muestra un error
            return $_resp->error_416();
        }else{
                //Inicia el loggeo
               $user = $info['user'];
               $pass = $info['pass'];
               $data = $this->dbUser($user, $pass);
               return $data;
            }
    }

    private function dbUser($usr, $psw){
        $sql = "CALL userLogg('$usr')";
        $query = parent::getDataPA($sql);        
        $i = $query[0]['id'];

        if ($query[0]['code'] == 403) {
            return $query;
        }
        
        if (password_verify($psw, $query[0]['Password'])) {
            $loggin = $this->tokenCreate($i);
            return $loggin;
        }
        
        $naLogg = array(
            'code'=>"401",
            'code_msg'=>"Usuario No Autorizado verifique sus credenciales");

        return $naLogg;
    }
    
    private function tokenCreate($id)
    {
        $sql = "CALL userCreateToken('$id')";
        $query = parent::getDataPa($sql);
        return $query;
    }
    
}


?>