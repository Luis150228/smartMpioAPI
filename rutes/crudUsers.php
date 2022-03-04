<?php
require_once '../classes/users.class.php';
require_once '../classes/respuesta.php';

$_admUser = new users;
$_resp = new respuesta;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $resBody = file_get_contents('php://input');
   print_r($resBody);
   $resClass = $_admUser->addUser($resBody);


    if (isset($resClass[0]['code'])) {
        $code = $resClass[0]['code'];
        http_response_code($code);
    } else {
        $codeTwo = $resClass['message']['code'];
        http_response_code($codeTwo);
    }
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($resClass);
}else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id']) || isset($_GET['pag'])) {
        if (isset($_GET['pag']) && isset($_GET['e'])) {
            $resClass = $_admUser->listUsers($_GET['pag'], $_GET['e']);
            http_response_code(200);
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($resClass);
        }else if(isset($_GET['id'])){
            $resClass = $_admUser->viewtUser($_GET['id']);
            $code = $resClass[0]['code'];
            http_response_code($code);
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($resClass);
        }else{
            http_response_code(404);
            header('Content-Type: application/json; charset=UTF-8');
        }
    }
}else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $resBody = file_get_contents('php://input');
    $resClass = $_admUser->editUser($resBody);

    if (isset($resClass[0]['code'])) {
        $code = $resClass[0]['code'];
        http_response_code($code);
    } else {
        $codeTwo = $resClass['message']['code'];
        http_response_code($codeTwo);
    }
    header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($resClass);

}else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $resBody = file_get_contents('php://input');
    $resClass = $_admUser->deleteUser($resBody);

    if (isset($resClass[0]['code'])) {
        $code = $resClass[0]['code'];
        http_response_code($code);
    } else {
        $codeTwo = $resClass['message']['code'];
        http_response_code($codeTwo);
    }
    header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($resClass);  

}else{
    http_response_code(405);
    header('Content-Type: application/json; charset=UTF-8');
}

?>