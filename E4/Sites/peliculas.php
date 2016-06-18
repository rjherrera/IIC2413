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
            <h2>Seleccionar Peliculas</h2>
          </div>
        </div>
        <div class="column">
          <a class="ui red large button" href="recomendaciones_peliculas.php">
            Recomendaciones
          </a>
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

      <div class="ui horizontal divider" id="series"></div>
      <div class="ui horizontal divider"></div>
      <div class="ui divider"></div>
      <div class="ui horizontal divider"></div>
      <div class="ui horizontal divider"></div>

      <div class="ui three column centered grid">
        <div class="column"></div>
        <div class="column">
          <div class="ui center aligned segment">
            <h2>Seleccionar Series</h2>
          </div>
        </div>
        <div class="column">
          <a class="ui red large button" href="recomendaciones_series.php">
            Recomendaciones
          </a>
        </div>
        <div class="ui stackable four column centered row">
          <div class="ui four doubling red cards">
            <?php items_series_general("SELECT s.nombre, s.caps_por_temp, s.id
  FROM series AS s"); ?>
          </div>
        </div>
      </div>
    </div>

<!-- "SELECT e.nombre, e.duracion, e.fecha, s.nombre, e.id
  FROM entretenimientos AS e, capitulos AS c, pertenece AS p, series AS s
  WHERE e.id = c.id_entretenimiento AND c.id_entretenimiento = p.id_capitulo
  AND p.id_serie = s.id" -->

<script type="text/javascript">
  cantidad_series = "<?php numero_de_series(); ?>";
</script>
<?php bottom_block(); ?>
<!-- id_e = <?php echo $_GET['id']; ?>; -->