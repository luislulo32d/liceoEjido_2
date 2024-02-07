<?php

require_once '../../../includes/conexion.php';

if($_POST) {
    $idmencion = $_POST['idmencion'];

    $sql = "UPDATE menciones SET mencion_estado = 0 WHERE mencion_id = ?";
    $query = $pdo->prepare($sql);
    $result = $query->execute(array($idmencion));

    if($result) {
        $respuesta = array('status' => true,'msg' => 'Mención eliminada correctamente');
    } else {
        $respuesta = array('status' => false,'msg' => 'Error al eliminar');
    }
    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
}