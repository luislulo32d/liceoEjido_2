<!-- MODAL TERCER AÑO-->


<div class="modal fade" id="modalTercerAño" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Nuevo Registro Tercer Año</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formTercerAño" name="formTercerAño">

        <input type="hidden" name="idterceraño" id="idterceraño" value="">

        <div class="form-group">
            <label for="listEstudiante">Seleccione el Estudiante</label>
            <select class="form-control" name="listEstudiante" id="listEstudiante">
                <!-- CONTENIDO AJAX -->
            </select>         
          </div>

          <div class="form-group">
            <label for="listAula">Seleccione la seccion</label>
            <select class="form-control" name="listAula" id="listAula">
                <!-- CONTENIDO AJAX -->
            </select>         
          </div>
          
          <div class="form-group">
            <label for="listPeriodo">Seleccione el Periodo</label>
            <select class="form-control" name="listPeriodo" id="listPeriodo">
                <!-- CONTENIDO AJAX -->
            </select>         
          </div>
          
          <div class="form-group">
            <label for="listGrupos">Seleccione el Grupo Estable</label>
            <select class="form-control" name="listGrupos" id="listGrupos">
                <!-- CONTENIDO AJAX -->
            </select>         
          </div>

          <div class="form-group">
                <label for="listMencion">Seleccione la Mención</label>
                <select class="form-control" name="listMencion" id="listMencion">
                  <option value="" hidden>MENCIÓN</option>
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
                <option value="2">Activo-Repitente</option>
                <option value="3">Activo-Remedial</option>
                <option value="4">Materia Pendiente</option>
                <option value="5">Inactivo</option>
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