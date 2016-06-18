<?php
  include 'base.php';
  redirect_if_anonymous();
  beggining_block();
?>

<div class="main-content">
  <div class="ui three column centered grid">
    <div class="column">
      <div class="ui center aligned segment">
        <h2>Recomendaciones Series</h2>
      </div>
    </div>
    <?php include 'consultas_quipasa.php'; ?>
    <div class="ui stackable four column centered row">
      <div class="ui four doubling red cards">
        <?php recomendaciones_series($_SESSION['username']); ?>
      </div>
    </div>
  </div>

<?php bottom_block(); ?>
