<?php 

require_once '../classes/poa_pbr.class.php';
require_once '../classes/respuesta.php';

$_admMeta = new metas;
$_resp = new respuesta;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # code...
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    # code...
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    # code...
} else {
    http_response_code(405);
    header('Content-Type: application/json; charset=UTF-8');
}

?>