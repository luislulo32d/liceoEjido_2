<?php

require_once '../../../includes/conexion.php';

if(!empty($_POST)) {
    if(empty($_POST['nombre']) || empty($_POST['siglas'])) {
        $respuesta = array('status' => false,'msg' => 'Todos los campos son necesarios');
    } else {
        $idmateria = $_POST['idmateriatecnica'];
        $nombre = $_POST['nombre'];
        $siglas = $_POST['siglas'];
        $año = $_POST['listAño'];
        $mencion = $_POST['listMencion'];
        $estado = $_POST['listEstado'];
        
        $comprobanteMateria = 0;
        $permitidos = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ_, ÁÉÍÓÚ";



        for($i=0; $i<strlen($nombre); $i++){
            if (strpos($permitidos, substr($nombre,$i,1))===false){
                $comprobanteMateria = 1;
            }
         }
         for($i=0; $i<strlen($siglas); $i++){
            if (strpos($permitidos, substr($siglas,$i,1))===false){
                $comprobanteMateria = 1;
            }
         }
         if($comprobanteMateria == 1){
            $respuesta = array('status' => false,'msg' => 'Nombre o Sigla Invalido');
         }else{

        $sql = 'SELECT * FROM materias WHERE nombre_materia = ? AND materia_id != ? AND año_seleccion = ? AND mencion_id = ? AND estado !=0';
        $query = $pdo->prepare($sql);
        $query->execute(array($nombre,$idmateria,$año,$mencion));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result > 0){
            $respuesta = array('status' => false,'msg' => 'La materia ya existe');
        } else {
            if($idmateria == 0){
                $sqlInsert = 'INSERT INTO materias (nombre_materia,siglas,año_seleccion,mencion_id,estado) VALUES (?,?,?,?,?)';
                $queryInsert = $pdo->prepare($sqlInsert);
                $request = $queryInsert->execute(array($nombre,$siglas,$año,$mencion,$estado));
                $accion = 1;
            } else {
                    $sqlUpdate = 'UPDATE materias SET nombre_materia = ?,siglas = ?,año_seleccion = ?,mencion_id = ?,estado = ? WHERE materia_id = ?';
                    $queryUpdate = $pdo->prepare($sqlUpdate);
                    $request = $queryUpdate->execute(array($nombre,$siglas,$año,$mencion,$estado,$idmateria));
                    $accion = 2;
            }
            
            if($request > 0) {
                if($accion == 1) {
                    $respuesta = array('status' => true,'msg' => 'Materia creada correctamente');
                } else {
                    $respuesta = array('status' => true,'msg' => 'Materia actualizada correctamente');
                }

            } else {
                $respuesta = array('status' => false,'msg' => 'Error al crear Materia');
            }
        }
    }
    }
    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
}