<?php
  include 'base.php';
  redirect_if_authenticated();
  beggining_block();
?>

    <div class="main-content">
      <div class="ui stackable three column grid">
        <div class="four wide column"></div>
        <div class="eight wide column">
          <div class="ui segment">
            <form class="ui form" id="form_login" onsubmit="return false;">
              <h2 class="ui dividing header">
                <div class="content">
                  Ingresar a MaquiPasa
                </div>
              </h2>
              <div class="ui error message" style="display:none;" id="error_login">
                <ul class="list">
                  <li></li>
                </ul>
              </div>
              <div class="field">
                <input type="hidden" name="consulta" value="ingresar">
              </div>
              <div class="field">
                <label>Usuario</label>
                <input type="text" name="username" autocapitalize="off">
              </div>
              <div class="field">
                <label>Password</label>
                <input type="password" name="password">
              </div>
              <div class="field">
                <div class="ui toggle checkbox">
                  <input type="checkbox" name="quipasa">
                  <label>Ingresar también con QuiPasa</label>
                </div>
              </div>
              <div class="ui blue submit button" type="button" id="button_login">Ingresar</div>
              <a href="sign_up.php">Registrarse</a>
            </form>
          </div>
          <button class="ui grey center large fluid button" onclick="$('#modal_info').modal('show');">Comentarios corrección</button>
        </div>
        <div class="four wide column"></div>
      </div>
    </div>


<div class="ui modal" id="modal_info">
  <div class="header">
    Comentarios
  </div>
  <div class="content">
    <ul>
      <li>Un usuario de pruebas es <i>pepe</i> de contraseña <i>asdfasdf</i>. Otro es <i>pedro</i>, con la misma contraseña.</li>
      <li>Para la búsqueda de mensajes que contuvieran los elementos de la película se determinó interpretando del enunciado que no se referían a "mensaje que contuviera cualquier pedazo de director/película/actor" ya que saldrían infinitos mensajes que matchearan con los strings de largo 1, sino que "director/pelicula/actor que estuviera en cualquier pedazo del mensaje".</li>
      <li>Los usuarios pueden libremente cambiar su plan en la pagina de usuario (hacer click en su nombre de usuario en la barra), para probar la funcionalidad de la cantidad restante de vistos.</li>
      <li>No se alteraron los esquemas de ningún grupo, solo se hicieron inserciones de datos para poblar más las bases de datos.</li>
      <li>En las búsquedas, se recomienda:
        <ul>
          <li>Género: comedia, drama, suspenso</li>
          <li>Nombre: inception, interstellar, deadpool, study in pink, war...</li>
          <li>Fechas: 2010-08-06, 2014-11-07, 2008-08-13, 2010-08-08...</li>
        </ul>
      </li>
      <li>En la implementación, ya no se usa el campo "restantes_mes" de los usuarios, sino que se calcula la cantidad de restantes, en base a las películas/series vistas. Era redundante y fue incluido como un método para mejorar la eficiencia en caso de grandes cantidades de datos, pero nos dimos cuenta de que no era necesario (las consultas no eran tan complejas y se ejecutan rápido) y de llegar a un punto en el que lo sea, no es de difícil implementaciṕn.</li>
    </ul>
  </div>
  <div class="actions">
    <div class="ui positive right labeled icon button">
      Ok
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>

<?php bottom_block(); ?>