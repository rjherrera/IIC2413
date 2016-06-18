<?php
  include 'base.php';
  redirect_if_anonymous();
  beggining_block();

?>

    <div class="main-content">
      <div class="ui three column centered grid">
        <div class="column"></div>
        <div class="column">
          <div class="ui center aligned segment">
            <h2>Resultados</h2>
          </div>
              <div class="ui error message" style="display:none;" id="error_search">
                <ul class="list">
                  <li></li>
                </ul>
              </div>
        </div>
        <?php include 'consultas_peliculas.php'; ?>
        <div class="ui stackable four column centered row">
          <div class="ui four doubling red cards">
            <?php items_peliculas("SELECT e.nombre, e.duracion, e.fecha, p.oscares, e.id
  FROM entretenimientos AS e, peliculas AS p
  WHERE e.id = p.id_entretenimiento"); ?>
          </div>
        </div>
      </div>

<?php bottom_block(); ?>