<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <!-- FIRST INCLUDES -->
    <link href="static/main.css" type="text/css" rel="stylesheet"/>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Semantic UI -->
    <link rel="stylesheet" type="text/css" href="static/semantic/semantic.min.css">
    <script src="static/semantic/semantic.min.js"></script>
    <!-- Prism -->
    <script src="static/prism.js"></script>
    <link href="static/prism.css" rel="stylesheet"/>
    <!-- END FIRST INCLUDES -->
    <title>MaquiView | Grupo 14</title>
  </head>
  <body>
    <div class="ui fluid fixed inverted one item main menu">
      <div class="borderless item" style="font:Verdana;font-weight: lighter;">
        <i><b>MAQUI</b></i><i class="big orange inverted film icon" style="margin-left:2px;margin-right:1px;"></i><i><b>VIEW</b></i>
      </div>
    </div>
    <div class="main-content">
      <h2 class="ui header">
        <i class="film orange icon"></i>
        <div class="content">
          MaquiView
          <div class="sub header">Vea consultas especializadas sobre el servicio MaquiView</div>
        </div>
      </h2>
      <div class="ui horizontal divider"></div>

      <!-- TABS MENU -->
      <div class="ui top attached tabular menu">
        <a class="active item" data-tab="general">
          Consultas Generales
        </a>
        <a class="item" data-tab="specific">
          Consultas Específicas
        </a>
      </div>
      <!-- END OF TABS MENU -->

      <!-- TAB 1 CONTENT -->
      <div class="ui bottom attached active tab segment" data-tab="general">
        <h3 class="ui dividing header">
          <div class="content">
            Datos interesantes
            <!-- <div class="sub header">Hola</div> -->
          </div>
        </h3>
        <?php include 'maximos.php'; ?>
        <div class="ui two column stackable grid">
          <div class="four wide column">
            <div class="ui secondary vertical fluid pointing menu">
              <a class="active item" data-tab="consulta_7">Director con más películas o capítulos de serie</a>
              <a class="item" data-tab="consulta_8">Película más vista del año</a>
            </div>
          </div>
          <div class="twelve wide column">
            <div class="ui active tab" data-tab="consulta_7">
              <h4 class="ui dividing header">
                <div class="content">
                  Resultado
                </div>
              </h4>
              <?php director_maximo(); ?>
              <h4 class="ui dividing header">
                <div class="content">
                  Consulta SQL
                </div>
              </h4>
              <div class="ui secondary tall stacked segment">
                <pre>
                  <code class="language-sql">
              SELECT
                  nombre, c
              FROM
                  Directores AS d,
                  (SELECT id_director, COUNT(*) as c
                   FROM dirige
                   GROUP BY id_director
                   HAVING COUNT(*) >= ALL (SELECT COUNT(*)
                                           FROM dirige
                                           GROUP BY id_director)) AS dc
              WHERE d.id = dc.id_director;
                  </code>
                </pre>
              </div>
            </div>
            <div class="ui tab" data-tab="consulta_8">
              <h4 class="ui dividing header">
                <div class="content">
                  Resultado
                </div>
              </h4>
              <?php pelicula_maxima(); ?>
              <h4 class="ui dividing header">
                <div class="content">
                  Consulta SQL
                </div>
              </h4>
              <div class="ui secondary tall stacked segment">
                <pre>
                  <code class="language-sql">
              CREATE VIEW VistosPeliculas AS
                  SELECT v.id_entretenimiento, COUNT(*) as cant
                  FROM Vistos as v, Peliculas as p
                  WHERE v.id_entretenimiento = p.id_entretenimiento AND
                        fecha >= '2016-01-01' AND fecha < '2017-01-01'
                  GROUP BY v.id_entretenimiento;

              SELECT nombre, cant
              FROM VistosPeliculas, Entretenimientos
              WHERE cant = (SELECT MAX(cant) FROM VistosPeliculas) AND
                    id_entretenimiento = id;
                  </code>
                </pre>
              </div>
            </div>
          </div>
        </div>

        <h3 class="ui dividing header">
          <div class="content">
            Información general
          </div>
        </h3>
        <?php include 'stats.php'; ?>
            <div class="ui orange attached icon message">
              <i class="sort numeric ascending icon"></i>
              <div class="content">
                <div class="header">Cantidades</div>
              </div>
            </div>
            <div class="ui attached segment">
              <div class="ui stackable two column grid">
                <div class="column">
                  <div class="ui small horizontal statistic">
                    <div class="value" id="users"><?php n_usuarios(); ?></div>
                    <div class="label">Usuarios</div>
                  </div><br>
                  <div class="ui small horizontal statistic">
                    <div class="value" id="peliculas"><?php n_peliculas(); ?></div>
                    <div class="label">Películas</div>
                  </div><br>
                  <div class="ui small horizontal statistic">
                    <div class="value" id="series"><?php n_series(); ?></div>
                    <div class="label">Series</div>
                  </div><br>
                </div>
                <div class="column">
                  <div class="ui small horizontal statistic">
                    <div class="value" id="capitulos"><?php n_capitulos(); ?></div>
                    <div class="label">Capitulos</div>
                  </div><br>
                  <div class="ui small horizontal statistic">
                    <div class="value" id="directores"><?php n_directores(); ?></div>
                    <div class="label">Directores</div>
                  </div><br>
                  <div class="ui small horizontal statistic">
                    <div class="value" id="comentarios"><?php n_comentarios(); ?></div>
                    <div class="label">Comentarios</div>
                  </div>
                </div>
              </div>

            </div>
          <div class="ui horizontal divider"></div>
          <div class="ui horizontal divider"></div>

      </div>
      <!-- END OF TAB 1 CONTENT -->

      <!-- TAB 2 CONTENT -->
      <div class="ui bottom attached tab segment" data-tab="specific">
        <h3 class="ui dividing header">
          <div class="content">
            Otros
          </div>
        </h3>
        <?php include 'consultas.php'; ?>
        <div class="ui two column stackable grid">
          <div class="four wide column">
            <div class="ui secondary vertical fluid pointing menu">
              <a class="active item" data-tab="consulta_1">Plan y películas/series restantes del mes actual de un usuario</a>
              <a class="item" data-tab="consulta_2">Películas que ha visto un usuario en el año</a>
              <a class="item" data-tab="consulta_3">Películas para un género y/o fecha</a>
              <a class="item" data-tab="consulta_4">Películas donde actúa un actor/actriz</a>
              <a class="item" data-tab="consulta_5">Temporadas y capítulos de una serie</a>
            </div>
          </div>
          <div class="twelve wide column">
          <!-- CONSULTA 1 -->
            <div class="ui active tab" data-tab="consulta_1">
              <div class="ui two column stackable grid">
                <div class="eight wide column">
                  <form class="ui form" onsubmit="return false;" id="form_consulta_1">
                    <h4 class="ui dividing header">
                      <div class="content">
                        Películas y/o series restantes del mes actual
                      </div>
                    </h4>
                    <p>Seleccione el usuario que desea observar. Recuerde que 1 película equivale a 4 capítulos de serie.</p>
                    <div class="field">
                      <input type="hidden" name="consulta" value="consulta_1">
                    </div>
                    <div class="field">
                      <label>Usuario</label>
                      <div class="ui fluid selection dropdown">
                        <input type="hidden" name="user">
                        <i class="dropdown icon"></i>
                        <div class="default text">Selecciona Usuario</div>
                        <div class="menu">
                          <?php items_usuarios(); ?>
                        </div>
                      </div>
                    </div>
                    <div class="ui blue submit button" type="button" id="button_consulta_1">Consultar</div>
                  </form>
                </div>
                <div class="eight wide column">
                  <div class="ui cards" id="cards_consulta_1"></div>
                </div>
              </div>
            </div>
            <!-- CONSULTA 2 -->
            <div class="ui tab" data-tab="consulta_2">
              <div class="ui two column stackable grid">
                <div class="eight wide column">
                  <form class="ui form" onsubmit="return false;" id="form_consulta_2">
                    <h4 class="ui dividing header">
                      <div class="content">
                        Películas vistas en el año actual
                      </div>
                    </h4>
                    <p>Seleccione el usuario del que desea observar sus películas vistas.</p>
                    <div class="field">
                      <input type="hidden" name="consulta" value="consulta_2">
                    </div>
                    <div class="field">
                      <label>Usuario</label>
                      <div class="ui fluid selection dropdown">
                        <input type="hidden" name="user">
                        <i class="dropdown icon"></i>
                        <div class="default text">Selecciona Usuario</div>
                        <div class="menu">
                          <?php items_usuarios(); ?>
                        </div>
                      </div>
                    </div>
                    <div class="ui blue submit button" type="button" id="button_consulta_2">Consultar</div>
                    <p>Nota: Solo juanjo y pepe han visto películas.</p>
                  </form>
                </div>
                <div class="eight wide column" id="resultado_consulta_2">

                </div>
              </div>
            </div>
            <!-- CONSULTA 3 -->
            <div class="ui tab" data-tab="consulta_3">
              <div class="ui two column stackable grid">
                <div class="eight wide column">
                  <form class="ui form" onsubmit="return false;" id="form_consulta_3">
                    <h4 class="ui dividing header">
                      <div class="content">
                        Películas de algún género o fecha
                      </div>
                    </h4>
                    <p>Seleccione el género, fecha o ambas para obtener las películas.</p>
                    <div class="field">
                      <input type="hidden" name="consulta" value="consulta_3">
                    </div>
                    <div class="field">
                      <label>Género</label>
                      <div class="ui fluid selection dropdown">
                        <input type="hidden" name="genero">
                        <i class="dropdown icon"></i>
                        <div class="default text">Selecciona Género</div>
                        <div class="menu">
                          <?php items_generos(); ?>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <label>Fecha</label>
                      <input type="date" name="fecha">
                    </div>
                    <div class="ui blue submit button" type="button" id="button_consulta_3">Consultar</div>
                    <div class="ui grey button" type="button" onclick="$('#form_consulta_3').form('reset');">Limpiar</div>
                    <p>Nota: Puede dejar uno de los dos campos vacíos.</p>
                  </form>
                </div>
                <div class="eight wide column" id="resultado_consulta_3">

                </div>
              </div>
            </div>
            <!-- CONSULTA 4 -->
            <div class="ui tab" data-tab="consulta_4">
              <div class="ui two column stackable grid">
                <div class="eight wide column">
                  <form class="ui form" onsubmit="return false;" id="form_consulta_4">
                    <h4 class="ui dividing header">
                      <div class="content">
                        Películas en las que actúa cierto actor/actriz
                      </div>
                    </h4>
                    <p>Seleccione el actor del que desea saber sus películas.</p>
                    <div class="field">
                      <input type="hidden" name="consulta" value="consulta_4">
                    </div>
                    <div class="field">
                      <label>Actor/Actriz</label>
                      <div class="ui fluid selection dropdown">
                        <input type="hidden" name="actor">
                        <i class="dropdown icon"></i>
                        <div class="default text">Selecciona Actor</div>
                        <div class="menu">
                          <?php items_actores(); ?>
                        </div>
                      </div>
                    </div>
                    <div class="ui blue submit button" type="button" id="button_consulta_4">Consultar</div>
                    <p>Nota: En películas han actuado Matt Damon, Matthew McConaughey, Christian Bale entre otros, los primeros actores son de series. Se muestran todos por completitud en caso de que se quisiera cambiar a mostrar actores de series y películas por ejemplo.</p>
                  </form>
                </div>
                <div class="eight wide column" id="resultado_consulta_4">

                </div>
              </div>
            </div>
            <!-- CONSULTA 5 -->
            <div class="ui tab" data-tab="consulta_5">
              <div class="ui two column stackable grid">
                <div class="eight wide column">
                  <form class="ui form" onsubmit="return false;" id="form_consulta_5">
                    <h4 class="ui dividing header">
                      <div class="content">
                        Temporadas y capítulos de una serie
                      </div>
                    </h4>
                    <p>Seleccione la serie de la que ver sus temporadas y capítulos.</p>
                    <div class="field">
                      <input type="hidden" name="consulta" value="consulta_5">
                    </div>
                    <div class="field">
                      <label>Serie</label>
                      <div class="ui fluid selection dropdown">
                        <input type="hidden" name="serie">
                        <i class="dropdown icon"></i>
                        <div class="default text">Selecciona Serie</div>
                        <div class="menu">
                          <?php items_series(); ?>
                        </div>
                      </div>
                    </div>
                    <div class="ui blue submit button" type="button" id="button_consulta_5">Consultar</div>
                  </form>
                </div>
                <div class="eight wide column" id="resultado_consulta_5">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END OF TAB 2 CONTENT -->

      <div class="ui horizontal divider"></div>
      <div class="ui horizontal divider"></div>
      <div class="ui basic center aligned segment">
        <p>Grupo 14 - Raimundo Pérez | Raimundo Herrera - © 2016</p>
      </div>
    </div>
  </body>
  <!-- LAST INCLUDES-->
  <script src="static/main.js" type="text/javascript"></script>
  <!-- END LAST INCLUDES -->
</html>