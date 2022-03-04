<?php
require_once './classes/auth.class.php';
require_once './classes/respuesta.php';

$_auth = new auth;
$_resp = new respuesta;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Recepcion de datos del cliente
   $resBody = file_get_contents('php://input');

    //Se envian los datos a los controladores de Clases
    $resClass = $_auth->login($resBody);
        $code = intval($resClass['code']);
        http_response_code($code);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($resClass);
}else{
    header('Content-Type: application/json; charset=UTF-8');
        $resp = $_resp->error_405();
        echo json_encode($resClass);
}

?>