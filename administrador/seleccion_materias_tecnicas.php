<?php
    require_once 'includes/header.php';
    require_once '../includes/conexion.php';

    $sql = "SELECT * FROM menciones WHERE mencion_estado = 1 AND mencion_id != 1";
    $query = $pdo->prepare($sql);
    $query->execute();
    $row = $query->rowCount();

?>

<main class="app-content">
  <div class="row">
      <div class="col-md-12 border shadow p-2 bg-info text-white">
        <h3 class="display-4 text-center">SISTEMA ESCOLAR - LICEO BOLIVARIANO EJIDO</h3>
        
      </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center border mt-3 p-4 bg-light">
      <h4> MATERIAS TÉCNICAS </h4>
    </div>
  </div>
  <div class="row">
    <?php if($row > 0) {
      while($data = $query->fetch()) {
    ?>
    <div class="col-md-4 text-center border mt-3 p-1 bg-light">
        <div class="card m-2 shadow" style="width: 20rem;">
          <div class="card-body">
            <a href="lista_materias_tecnicas.php?mencion=<?= $data['mencion_id'] ?>&nombreMencion=<?= $data['mencion_nombre']?>" class="btn btn-primary"><?= $data['mencion_nombre']?></a>
          </div>
        </div>
    </div>
    <?php } } ?>
  </div>
</main>

<?php
require_once 'includes/footer.php';
?>