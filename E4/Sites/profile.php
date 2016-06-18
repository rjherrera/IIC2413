<?php
  include 'base.php';
  redirect_if_anonymous();
  beggining_block();
?>




  <?php include 'consultas_planes.php';?>
    <div class="main-content">
      <div class="ui segment">
      <h1 class="ui center aligned dividing header">
        <div class="content">Perfil de <?php echo $_SESSION['username']; ?>
        </div>
      </h1>
        <div id="actual" class="ui large red inverted header">Plan actual contratado: <?php plan_actual($_SESSION['username']); ?></div>
        <p><?php restantes($_SESSION['username']); ?>. Recuerda que una película equivale a 1, y un capítulo a 1/4.</p>
        <div class="ui stackable three column centered row">
          <div class="ui three red cards">
            <a id="plan_basico" class="card">
              <div class="content">
                <div class="header">Plan Básico</div>
                <div class="meta">$10.000 CLP</div>
                <div class="description">
                  Puedes ver 10 peliculas mensuales.
                </div>
              </div>
            </a>
            <a id="plan_medio" class="card">
              <div class="content">
                <div class="header">Plan Medio</div>
                <div class="meta">$15.000 CLP</div>
                <div class="description">
                  Puedes ver 20 peliculas mensuales.
                </div>
              </div>
            </a>
            <a id="plan_premium" class="card">
              <div class="content">
                <div class="header">Plan Premium</div>
                <div class="meta">$20.000 CLP</div>
                <div class="description">
                   Puedes ver 30 peliculas mensuales.
                </div>
              </div>
            </a>
          </div>
        </div>

      </div>

      <div id="container_mostrar" class="ui segment center aligned">
        <div id="mostrar" class="ui red basic active inverted button"></div>
      </div>
    </div>



<?php bottom_block(); ?>

<script type="text/javascript">
  username = "<?php echo $_SESSION['username']; ?>";
</script>
