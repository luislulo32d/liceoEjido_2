<?php

require_once '../../../includes/conexion.php';

$sql = "SELECT * FROM menciones WHERE mencion_estado != 0 AND mencion_id != 1 ORDER BY mencion_nombre,mencion_id";
$query = $pdo->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < count($consulta);$i++) {
    if($consulta[$i]['mencion_estado'] == 1){
        $consulta[$i]['mencion_estado'] = '<span class="badge badge-success">Activo</span>';  
    } else{
        $consulta[$i]['mencion_estado'] = '<span class="badge badge-danger">Inactivo</span>';  
    }

    $consulta[$i]['acciones'] = '
        <button class="btn btn-primary btn-sm" title="Editar" onclick="editarMencion('.$consulta[$i]['mencion_id'].')">Editar</button>
        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarMenciones('.$consulta[$i]['mencion_id'].')">Eliminar</button>
                                ';
}

echo json_encode($consulta,JSON_UNESCAPED_UNICODE);