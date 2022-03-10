<?php

class respuesta{
    public $response = [
        "status" => 'ok',
        "message" => array()
    ];
    
    public function error_200($str = 'Correcto'){
        $this->response['status'] = 'correcto';
        $this->response['message'] = array(
            'code'=>"200",
            'code_msg'=> $str
        );
        return $this->response;
    }
    
    public function error_400(){
        $this->response['status'] = 'error';
        $this->response['message'] = array(
            'code'=>"400",
            'code_msg'=>"Error del Servidor"
        );
        return $this->response;
    }

    public function error_401(){
        $this->response['status'] = 'error';
        $this->response['message'] = array(
            'code'=>"401",
            'code_msg'=>"Usuario No Autorizado verifique sus credenciales"
        );
        return $this->response;
    }

    public function error_405(){
        $this->response['status'] = 'error';
        $this->response['message'] = array(
            'code'=>"405",
            'code_msg'=>"Metodo no permitido"
        );
        return $this->response;
    }

    public function error_416(){
        $this->response['status'] = 'error';
        $this->response['message'] = array(
            'code'=>"416",
            'code_msg'=>"Datos incorrectos revizar documentacion"
        );
        return $this->response;
    }

    public function error_409(){
        $this->response['status'] = 'error';
        $this->response['message'] = array(
            'code'=>"409",
            'code_msg'=>"Posibles problemas con las claves foraneas de DB"
        );
        return $this->response;
    }

}

?>