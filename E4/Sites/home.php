<?php
  include 'base.php';
  redirect_if_anonymous();
  beggining_block();
?>

<?php
  if ($_SESSION['type'] == 2){
    $string_tipo = "Logueado en MaquiView + QuiPasa";
  }
  else {
    $string_tipo = "Logueado en MaquiView";
  }
?>

<script type="text/javascript" src="static/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="static/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="static/daterangepicker/daterangepicker.min.css" />

    <div class="main-content">
      <div class="ui segment">
        <div class="ui red huge inverted label"><?php echo $string_tipo;?></div>
        <div class="ui divider"></div>
        <div id="search-container" class="ui grid">
          <div class="four wide column" id="search-type">
            <div class="ui floating labeled icon dropdown button">
              <i class="filter icon"></i>
              <span class="text">Buscar por</span>
              <div class="menu">
                <div class="item" data-value="nombre">
                  Nombre
                </div>
                <div class="item" data-value="genero">
                  Género
                </div>
                <div class="item" data-value="fecha">
                  Fecha de estreno
                </div>
                <div class="item" data-value="nombre-fecha">
                  Nombre/Fecha de estreno
                </div>
                <div class="item" data-value="genero-fecha">
                  Género/Fecha de estreno
                </div>
              </div>
            </div>
          </div>
          <div class="seven wide column" id="search-inputs">
            <div class="ui icon fluid input">
              <input type="text" placeholder="Buscar...">
              <i class="search icon"></i>
            </div>
          </div>
          <div class="five wide column" id="search-content-type">
            <div class="ui selection dropdown">
              <input type="hidden" name="tipo">
              <i class="dropdown icon"></i>
              <div class="default text">Tipo</div>
              <div class="menu">
                <div class="item" data-value="peliculas">Películas</div>
                <div class="item" data-value="series">Series</div>
              </div>
            </div>
              <div class="ui red button">
                Buscar
              </div>
            </div>

          </div>
        </div>
        <div class="ui divider"></div>
        <div class="ui two stackable cards">
          <a class="ui inverted card" href="peliculas.php">
            <div class="content">
              <div class="header">Ver películas!</div>
              <div class="description">
                Descubre las increíbles películas que MaquiPasa tiene disponibles para ti!
              </div>
            </div>
            <div class="ui bottom attached red button">
              <i class="add icon"></i>
              Ir a películas!
            </div>
          </a>
          <a class="ui card" href="peliculas.php#series">
            <div class="content">
              <div class="header">Ver series!</div>
              <div class="description">
                Descubre las increíbles series que MaquiPasa tiene disponibles para ti!
              </div>
            </div>
            <div class="ui bottom attached red button">
              <i class="add icon"></i>
              Ir a series!
            </div>
          </a>
        </div>

        <div id="search-results" class="hidden">
            <div class="ui divider"></div>
            <div class="ui stackable four column centered row">
              <div class="ui four doubling red cards">

              </div>
            </div>
        </div>

      </div>
    </div>


<?php bottom_block(); ?>
