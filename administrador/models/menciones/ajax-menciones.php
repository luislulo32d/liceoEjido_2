<?php

require_once '../../../includes/conexion.php';

if(!empty($_POST)) {
    if(empty($_POST['nombre'])) {
        $respuesta = array('status' => false,'msg' => 'Todos los campos son necesarios');
    } else {
        $idmencion = $_POST['idmencion'];
        $nombre = $_POST['nombre'];
        $estado = $_POST['listEstado'];
        $comprobanteMenciones = 0;
        $permitidos = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ_, ÁÉÍÓÚ";



        for($i=0; $i<strlen($nombre); $i++){
            if (strpos($permitidos, substr($nombre,$i,1))===false){
                $comprobanteMenciones = 1;
            }
         }
         
         if($comprobanteMenciones == 1){
            $respuesta = array('status' => false,'msg' => 'Nombre Invalido');
         }else{

        $sql = 'SELECT * FROM menciones WHERE mencion_nombre = ? AND mencion_id != ? AND mencion_estado !=0';
        $query = $pdo->prepare($sql);
        $query->execute(array($nombre,$idmencion));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result > 0){
            $respuesta = array('status' => false,'msg' => 'La Mención ya existe');
        } else {
            if($idmencion == 0){
                $sqlInsert = 'INSERT INTO menciones (mencion_nombre,mencion_estado) VALUES (?,?)';
                $queryInsert = $pdo->prepare($sqlInsert);
                $request = $queryInsert->execute(array($nombre,$estado));
                $accion = 1;
            } else {
                    $sqlUpdate = 'UPDATE menciones SET mencion_nombre = ?,mencion_estado = ? WHERE mencion_id = ?';
                    $queryUpdate = $pdo->prepare($sqlUpdate);
                    $request = $queryUpdate->execute(array($nombre,$estado,$idmencion));
                    $accion = 2;
            }
            
            if($request > 0) {
                if($accion == 1) {
                    $respuesta = array('status' => true,'msg' => 'Mención creada correctamente');
                } else {
                    $respuesta = array('status' => true,'msg' => 'Mención actualizada correctamente');
                }

            } else {
                $respuesta = array('status' => false,'msg' => 'Error al crear Mención');
            }
        }
    }
    }
    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
}