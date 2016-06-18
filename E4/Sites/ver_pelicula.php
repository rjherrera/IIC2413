<?php
  include 'base.php';
  redirect_if_anonymous();
  beggining_block();
  $nombre_u = $_SESSION['username'];
?>


    <div class="main-content">
      <div class="ui segment">
        <?php include 'consultas_peliculas.php';?>
        <h1 class="ui center aligned dividing header">
          <div class="content">
            <?php $nombre_p = nombre_pelicula($_GET['id']); echo $nombre_p;?>
            <!-- <div class="sub header"></div> -->
          </div>
        </h1>
        <!-- <div class="ui center aligned stackable three column grid">
          <div class="ui center aligned three column row">
            <div class="column">
              <div class="ui red inverted huge label">Info</div>
            </div>
            <div class="column">
              <div class="ui red inverted huge label">Actuan</div>
            </div>
            <div class="column">
              <div class="ui red inverted huge label">Dirigen</div>
            </div>
          </div>
          <div class="ui center aligned three column row">
            <div class="column">
            <?php detalles_pelicula($_GET['id']); ?>
            </div>
            <div class="column">
              <div>
                <?php actores_pelicula($_GET['id']);
                ?>
              </div>
            </div>
            <div class="column">
                 <?php directores_pelicula($_GET['id']);
                ?>
            </div>
          </div>

        </div> -->
        <div id="video" class="ui embed" data-url="http://www.youtube.com/embed/dQw4w9WgXcQ" data-placeholder="static/img/<?php plain_nombre_pelicula($_GET['id']);?>.jpg">
          <button id="overlay_button" class="fluid ui button" style="position:absolute;top:0;left:0;width:100%;height:100%;">Presione para reproducir (gastará 1 "visto")</button>
        </div>
        <div class="ui horizontal divider">Información</div>
        <div class="ui inverted segment">
          <div class="ui items">
            <?php item_pelicula_descripcion($_GET['id']); ?>
          </div>
        </div>
      </div>
      <div class="ui segment">
        <h2 class="ui dividing header">Comentarios (MaquiView)</h2>
        <div class="ui minimal comments" style="max-width:100%">
          <?php comentarios_pelicula($_GET['id']); ?>
        </div>

          <?php if ($_SESSION['type'] == 2) {
              include 'consultas_comentarios.php';
              echo "
              <h2 class='ui dividing header'>Mensajes Relevantes (QuiPasa)</h2>
              <div class='ui minimal comments' style='max-width:100%'>";
              mensajes_pelicula($_SESSION['username'],$_GET['id']);
              echo "<h4 class='ui dividing header'>Enviar mensaje sobre la película a un grupo o usuario</h2>
                <div class='ui error message' style='display:none;' id='error_message'>
                  <ul class='list'>
                    <li></li>
                  </ul>
                </div>
                <form class='ui fluid reply form' id='form_message' onsubmit='return false;'>
                  <div class='two fields'>
                    <div class='field'>
                      <label>Usuario Destino</label>
                      <div class='ui fluid selection dropdown'>
                        <input type='hidden' name='to_user'>
                        <i class='dropdown icon'></i>
                        <div class='default text'>Selecciona usuario</div>
                        <div class='menu'>
                          " . items_personas() . "
                        </div>
                      </div>
                    </div>
                    <div class='field'>
                      <label>Grupo Destino</label>
                      <div class='ui fluid selection dropdown'>
                        <input type='hidden' name='to_group'>
                        <i class='dropdown icon'></i>
                        <div class='default text'>Selecciona grupo</div>
                        <div class='menu'>
                          " . items_grupos($_SESSION['username']) . "
                        </div>
                      </div>
                    </div>
                  </div>
                  <input name='nombre_p' type='hidden' value='$nombre_p'>
                  <input name='nombre_u' type='hidden' value='$nombre_u'>
                  <div class='field'>
                    <textarea name='mensaje'></textarea>
                  </div>
                  <p><i>* Al mensaje se le antepondrá el nombre de la película.</i></p>
                  <div class='ui negative labeled submit icon button' id='button_message'>
                    <i class='icon edit'></i> Agregar comentario
                  </div>
                  <button type='button' class='ui grey button' onclick='$(\".dropdown\").dropdown(\"restore defaults\");'>Limpiar destinatarios</button>
                </form>
              </div>
              ";
            }
            else {
              echo "
                  <br><p><i>Para comentar por favor reingrese con un usuario que también esté registrado en QuiPasa o marque la opción de ingresar con QuiPasa.</i></p>
              ";
            }
          ?>
      </div>
    </div>


<?php bottom_block(); ?>

<script type="text/javascript">
  username = "<?php echo $_SESSION['username']; ?>";
  id_e = <?php echo $_GET['id']; ?>;
</script>