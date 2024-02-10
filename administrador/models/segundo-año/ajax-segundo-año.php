<?php

require_once '../../../includes/conexion.php';

if(!empty($_POST)) {
    if(empty($_POST['listEstudiante']) || empty($_POST['listAula']) || empty($_POST['listPeriodo']) || empty($_POST['listMencion'] || empty($_POST['listEstado']))) {
        $respuesta = array('status' => false,'msg' => 'Todos los campos son necesarios');
    } else {
        $idsegundoaño = $_POST['idsegundoaño'];
        $estudiante = $_POST['listEstudiante'];
        $aula = $_POST['listAula'];
        $periodo = $_POST['listPeriodo'];
        $listMencion = $_POST['listMencion'];
        $grupo = $_POST['listGrupos'];
        $estado = $_POST['listEstado'];

      
        $sql = "SELECT * FROM segundo_año WHERE segundo_id != ? AND alumno_id = ? AND periodo_id = ? AND statussg != 0";
        $query = $pdo->prepare($sql);
        $query->execute(array($idsegundoaño,$estudiante,$periodo));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result > 0){
            $respuesta = array('status' => false,'msg' => 'Error, El estudiante ya esta registrado en una sección de segundo año.');
        } else {
            if($idsegundoaño == 0){
                $sqlInsert = "INSERT INTO segundo_año (alumno_id,aula_id,periodo_id,mencion_id,statussg,grupo_id) VALUES (?,?,?,?,?,?)";
                $queryInsert = $pdo->prepare($sqlInsert);
                $request = $queryInsert->execute(array($estudiante,$aula,$periodo,$listMencion,$estado,$grupo));
                $accion = 1;
            } else {
                    $sqlUpdate = 'UPDATE segundo_año SET alumno_id = ?,aula_id = ?,periodo_id = ?,mencion_id = ?,statussg = ?,grupo_id = ? WHERE segundo_id = ?';
                    $queryUpdate = $pdo->prepare($sqlUpdate);
                    $request = $queryUpdate->execute(array($estudiante,$aula,$periodo,$listMencion,$estado,$grupo,$idsegundoaño));
                    $accion = 2;
            }
            
            if($request > 0) {
                if($accion == 1) {
                    $respuesta = array('status' => true,'msg' => 'Registro creado correctamente');
                } else {
                    $respuesta = array('status' => true,'msg' => 'Registro actualizado correctamente');
                }

            } else {
                $respuesta = array('status' => false,'msg' => 'Error al crear el proceso');
            }
        }
    }
    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
}