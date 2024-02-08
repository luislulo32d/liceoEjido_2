<?php
  if(!empty($_GET['mencion']) && !empty($_GET['nombreMencion'])) {
        $mencionid = $_GET['mencion'];
        $nombreMencion = $_GET['nombreMencion'];
    }else {
      echo '<script> alert("Ups! No se a seleccionado correctamente la sección o el año")</script>';
    }
    require_once 'includes/header.php';
    require_once '../includes/conexion.php';
?>
    <!-- MODAL MATERIA-->


        <div class="modal fade" id="modalMateriaTecnica" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tituloModal">Nueva Materia Técnica</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="formMateriaTecnica" name="formMateriaTecnica">
            <input type="hidden" name="idmateriatecnica" id="idmateriatecnica" value="">
              <div class="form-group">
                <label for="control-label">Nombre de la materia:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
              <div class="form-group">
                <label for="control-label">Siglas de la materia:</label>
                <input type="text" class="form-control" name="siglas" id="siglas" maxlength="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
              <div class="form-group">
                <label for="listAño">Año de la Materia</label>
                <select class="form-control" name="listAño" id="listAño">
                    <option value="1">Primer Año</option>
                    <option value="2">Segundo Año</option>
                    <option value="3">Tercer Año</option>
                    <option value="4">Cuarto Año</option>
                    <option value="5">Quinto Año</option>
                </select>         
              </div>

              <div class="form-group">
                <label for="listMencion">Seleccione la Mención</label>
                <select class="form-control" name="listMencion" id="listMencion">
                  <option value="<?= $mencionid?>" hidden><?= $nombreMencion?></option>
                    <!-- CONSULTA MYSQL -->
                    <?php 

                        $sql = "SELECT mencion_id,mencion_nombre FROM menciones WHERE mencion_estado = 1 AND mencion_id != 1";
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $row = $query->rowCount();

                        if ($row > 0) {
                            while($data = $query->fetch()) {?>
                            <option value="<?php echo $data['mencion_id'];?>"><?php echo $data['mencion_nombre'];?></option>
                        <?php
                        }}
                    ?>

                </select>         
              </div>

              <div class="form-group">
                <label for="listEstado">Estado</label>
                <select class="form-control" name="listEstado" id="listEstado">
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                </select>         
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id ="action">Guardar</button>
              </div>
            </form>
          </div>
          
        </div>
      </div>
        </div>

    <!-- MAIN CONTENT -->

     <!-- CONSULTA MYSQL -->
     <?php 

        $sql = "SELECT * FROM materias as mt INNER JOIN menciones as me ON mt.mencion_id = me.mencion_id WHERE mt.estado != 0 AND mt.mencion_id = $mencionid ORDER BY mt.año_seleccion,mt.materia_id,mt.nombre_materia";
        $query = $pdo->prepare($sql);
        $query->execute();
        $row = $query->rowCount();
    ?>
    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Lista de Materias de la Mención: <?= $nombreMencion?></h1>
            <button class="btn btn-success" type="button" onclick="openModalMateriaTecnica()">Nueva Materia Técnica</button>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">lista de materias técnicas</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
          <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tablemateriastecnicas">
                  <thead>
                    <tr>
                      <th>ACCIONES</th>
                      <th>NOMBRE DE LA MATERIA</th>
                      <th>SIGLAS</th>
                      <th>AÑO</th>
                      <th>MENCION</th>
                      <th>ESTADO</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  <?php
                      if ($row > 0) {
                        while($data = $query->fetch()) {
                    ?>
                      <tr>
                        <td><?php
                        if ($privilegios == 1){
                            $data['acciones'] = '
                            <button class="btn btn-primary btn-sm" title="Editar" onclick="editarMateriaTecnica('.$data['materia_id'].')">Editar</button>
                            <button class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarMateria('.$data['materia_id'].')">Eliminar</button> 
                                                '; //se usa para eliminar la función de materia normal, ya que no hay diferencia para eso
                        }elseif ($privilegios == 2){
                          $data['acciones'] = '
                            <button class="btn btn-primary btn-sm" title="Editar" onclick="editarMateriaTecnica('.$data['materia_id'].')">Editar</button>
                          ';
                        }
                        echo $data['acciones'];
                        ?></td>
                        <td><?= $data['nombre_materia']; ?></td>
                        <td><?= $data['siglas'];?></td>
                        <td><?= $data['año_seleccion'];?></td>
                        <td><?= $data['mencion_nombre'];?></td>
                        <td><?php if($data['estado'] == 1){
                          ?>    <span class="badge badge-success">Activo</span>
                            <?php } else{
                              ?> <span class="badge badge-danger">Inactivo </span>
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