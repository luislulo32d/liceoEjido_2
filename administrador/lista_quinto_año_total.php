<?php
   
    require_once 'includes/header.php';
    require_once '../includes/conexion.php';
    require_once 'includes/modals/modal_quinto_año.php';

    $sql = "SELECT * FROM quinto_año as sg INNER JOIN alumnos as al ON sg.alumno_id = al.alumno_id INNER JOIN aulas as au ON sg.aula_id = au.aula_id INNER JOIN periodos as pe ON sg.periodo_id = pe.periodo_id INNER JOIN menciones as me ON sg.mencion_id = me.mencion_id WHERE sg.statusqn != 0 ORDER BY al.cedulaes";
    $query = $pdo->prepare($sql);
    $query->execute();
    $row = $query->rowCount();

?>

<main class="app-content">
      <div class="app-title">
        <div>
        <h1><i class="fa fa-dashboard"></i> Lista de Alumnos de Quinto Año </h1>
        <a href="seleccion_notas.php?curso=5" class="btn btn-info">Generar Notas</a>

        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="seleccion_quinto_año.php">Seleccion Quinto Año</a></li>
          <li class="breadcrumb-item"><a href="#">lista de Quinto Año</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
          <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tablequintoaño">
                  <thead>
                    <tr>
                      <th>SECCION</th>
                      <th>CEDULA ESTUDIANTIL</th>
                      <th>CEDULA DE IDENTIDAD</th>
                      <th>APELLIDO DEL ALUMNO</th>
                      <th>NOMBRE DEL ALUMNO</th>
                      <th>SEXO</th>
                      <th>MENCIÓN</th>
                      <th>ESTADO</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                      if ($row > 0) {
                        while($data = $query->fetch()) {
                        $nacimientofe = date("d-m-Y", strtotime($data['fecha_nac']));
                    ?>
                      <tr>
                        <td>SECCION <?= $data['nombre_aula']; ?></td>
                        <td><?= $data['cedu_estudiantil'];?></td>
                        <td><?= $data['nacionalidad'], $data['cedulaes']; ?></td>
                        <td><?= $data['apellido_alumno'];?></td>
                        <td><?= $data['nombre_alumno'];?></td>
                        <td><?= $data['sexo'];?></td>
                        <td><?= $data['mencion_nombre'];?></td>
                        <td><?php if($data['estado'] != 1){
                                    ?> <span class="badge badge-danger"><?php echo $data['nombre_periodo'];?> </span>
                            <?php } elseif($data['statusqn'] == 1){
                                ?>    <span class="badge badge-success">Activo <?php echo $data['nombre_periodo'];?></span>
                                <?php } elseif ($data['statusqn'] == 2){
                                ?>    <span class="badge badge-primary">Repitente <?php echo $data['nombre_periodo'];?></span>  
                                <?php } elseif ($data['statusqn'] == 3){
                                ?>    <span class="badge badge-info">Activo Remedial</span>  
                                <?php } elseif ($data['statusqn'] == 4){
                                ?>    <span class="badge badge-warning">Activo Materia Pendiente</span>  
                                <?php } else{ ?>
                                      <span class= "badge badge-danger"><?php echo $data['nombre_periodo'];?></span>
                                <?php }?>                
                        </td>


                      </tr>

                    <?php } } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>


<?php
    require_once 'includes/footer.php';
?>