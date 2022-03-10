<?php 

require_once '../classes/poa_pbr.class.php';
require_once '../classes/respuesta.php';

$_admMeta = new metas;
$_resp = new respuesta;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resBody = file_get_contents('php://input');
    $respClass = $_admMeta->addMeta($resBody);
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
    $resBody = file_get_contents('php://input');
    $respClass = $_admMeta->editMeta($resBody);
    if (isset($respClass[0]['code'])) {
        $code = $respClass[0]['code'];
        http_response_code($code);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($respClass);
    }else {
        $codeTwo = $respClass['message']['code'];
        http_response_code($codeTwo);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $resBody = file_get_contents('php://input');
    $respClass = $_admMeta->deleteMeta($resBody);
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
    if (isset($_GET['id']) || isset($_GET['pag'])) {
        if (isset($_GET['pag']) && isset($_GET['e'])) {
            $resClass = $_admMeta->listMetas($_GET['pag'], $_GET['e']);
            http_response_code(200);
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($resClass);
        }else if(isset($_GET['id'])){
            $resClass = $_admMeta->viewtMetas($_GET['id']);
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