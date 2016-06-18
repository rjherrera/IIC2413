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
            <form class="ui form" id="form_register" onsubmit="return false;">
              <h2 class="ui dividing header">
                <div class="content">
                  Registrarse en MaquiView
                </div>
              </h2>
              <div class="ui error message" style="display:none;" id="error_register">
                <ul class="list">
                  <li></li>
                </ul>
              </div>
              <div class="field">
                <input type="hidden" name="consulta" value="registrar">
              </div>
              <div class="field">
                <label>Usuario</label>
                <input type="text" name="username">
              </div>
              <div class="field">
                <label>Password</label>
                <input type="password" name="password">
              </div>
              <div class="field">
                <label>Nombre Completo</label>
                <input type="text" name="nombre">
              </div>
              <div class="field">
                <label>Sexo</label>
                <input type="text" name="sexo">
              </div>
              <div class="field">
                <label>Edad</label>
                <input type="number" name="edad">
              </div>
              <div class="field">
                <label>E-Mail</label>
                <input type="email" name="email">
              </div>
              <div class="field">
                <div class="ui toggle checkbox">
                  <input type="checkbox" name="quipasa">
                  <label>Registrar también en QuiPasa</label>
                </div>
              </div>
              <div class="ui blue submit button" type="button" id="button_register">Registrarse</div>
            </form>
          </div>
        </div>
        <div class="four wide column"></div>
      </div>
    </div>


<?php bottom_block(); ?>