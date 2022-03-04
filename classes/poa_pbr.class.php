<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/smartMpioApi/access.php'); ///Conecion General Al ROOT
include (CONECT_PATH.'cnx.php');///Cargar Datos
include (CLASS_PATH.'respuesta.php');///Cargar Datos

class metas extends cnx {

    private $dbtabla = 'metas';

    public function addMeta($json){
        $readJson = json_decode($json, true);
        if (!isset($readJson['cvd'])) {
            # code...
        }
    }
    
}



?>