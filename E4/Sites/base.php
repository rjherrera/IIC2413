<?php

function redirect_if_authenticated(){
  session_start();
  if(isset($_SESSION['username'])){
    // Si la variable de sesión existe, está logueado, redirigir a home.php (pagina del usuario)
    header("location:home.php");
  }
}

function redirect_if_anonymous(){
  session_start();
  if(!isset($_SESSION['username'])){
    // Si la variable de sesión no existe, no está logueado, redirigir a index.php (pagina de login)
    header("location:index.php");
  }
}

function beggining_block(){
  if(isset($_SESSION['username'])){
    $right_menu = "
    <div class='right menu'>
      <a class='item' href='profile.php'>". $_SESSION['username'] ."</a>
      <a class='item' href='logout.php'>Salir</a>
    </div>";
  }
  else {
    $right_menu = "";
  }
  echo "
      <!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
          <!-- FIRST INCLUDES -->
          <link href='static/main.css' type='text/css' rel='stylesheet'/>
          <!-- jQuery -->
          <script src='https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
          <!-- Semantic UI -->
          <link rel='stylesheet' type='text/css' href='static/semantic/semantic.min.css'>
          <script src='static/semantic/semantic.min.js'></script>
          <!-- Prism -->
          <script src='static/prism.js'></script>
          <link href='static/prism.css' rel='stylesheet'/>
          <!-- END FIRST INCLUDES -->
          <title>MaquiPasa | Grupo 14+27</title>
        </head>
        <body style='background: url(https://static.pexels.com/photos/1828/city-cars-road-traffic-large.jpg) no-repeat center center fixed;background-size: cover;'>
          <div class='ui fluid fixed inverted main menu'>
            <a class='borderless item' style='font:Verdana;font-weight: lighter;' href='index.php'>
              <i><b>MAQUI</b></i><img class='logo' src='static/img/logo.png' style='margin-left: 3px;margin-right:3px;'></i><i><b>PASA</b></i>
            </a>
              ". $right_menu ."
          </div>";
  }

function bottom_block(){
    echo "
            <div class='ui horizontal divider'></div>
            <div class='ui horizontal divider'></div>
            <div class='footer'>
              <div class='ui basic center aligned segment'>
                <p style='color:white;'>Grupo 14+27 - Raimundo Pérez | Raimundo Herrera + Andrés Espinosa | Cristóbal Abarca - © 2016</p>
              </div>
            </div>
          </body>
          <!-- LAST INCLUDES-->
          <script src='static/main.js' type='text/javascript'></script>
          <!-- END LAST INCLUDES -->
        </html>";
}
?>
