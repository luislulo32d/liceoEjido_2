<?php

require_once '../../../includes/conexion.php';

$sql = "SELECT * FROM materias as mt INNER JOIN menciones as me ON mt.mencion_id = me.mencion_id WHERE mt.estado != 0 AND mt.mencion_id = 1 ORDER BY mt.año_seleccion,mt.materia_id,mt.nombre_materia";
$query = $pdo->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < count($consulta);$i++) {
    if($consulta[$i]['estado'] == 1){
        $consulta[$i]['estado'] = '<span class="badge badge-success">Activo</span>';  
    } else{
        $consulta[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';  
    }

    $consulta[$i]['acciones'] = '
        <button class="btn btn-primary btn-sm" title="Editar" onclick="editarMateria('.$consulta[$i]['materia_id'].')">Editar</button>
        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarMateria('.$consulta[$i]['materia_id'].')">Eliminar</button>
                                ';
}

echo json_encode($consulta,JSON_UNESCAPED_UNICODE);