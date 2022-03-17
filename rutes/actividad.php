<?php
require_once '../classes/actividades.class.php';
require_once '../classes/respuesta.php';

$_admActiv = new actividades;
$_resp = new respuesta;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $header = getallheaders();
    $resBody = file_get_contents('php://input');
    $respClass = $_admActiv->addActividad($resBody, $header);
    if (isset($respClass[0]['code'])) {
        $code = $respClass[0]['code'];
        http_response_code($code);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($respClass);
    }else {
        $codeTwo = $respClass['message']['code'];
        http_response_code($codeTwo);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $header = getallheaders();
    $resBody = file_get_contents('php://input');
    $respClass = $_admActiv->editActividad($resBody, $header);
    if (isset($respClass[0]['code'])) {
        $code = $respClass[0]['code'];
        http_response_code($code);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($respClass);
    }else {
        $codeTwo = $respClass['message']['code'];
        http_response_code($codeTwo);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $header = getallheaders();
    if (isset($header['x-access-token'])) {
        if (isset($_GET['pag']) && isset($_GET['e'])) {
            $resClass = $_admActiv->listActividades($_GET['pag'], $_GET['e'], $header['x-access-token']);
            http_response_code(200);
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($resClass);
        }else if(isset($_GET['id']) || isset($header['x-access-token'])){
            $resClass = $_admActiv->viewtActividad($_GET['id'], $header['x-access-token']);
            $code = $resClass[0]['code'];
            http_response_code($code);
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($resClass);
        }else{
            http_response_code(404);
            header('Content-Type: application/json; charset=UTF-8');
        }
    }
} else {
    http_response_code(405);
    header('Content-Type: application/json; charset=UTF-8');
}

?>