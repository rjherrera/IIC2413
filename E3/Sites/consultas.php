<?php

try{
  $db = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}

function items_usuarios(){
  global $db;
  $query = "SELECT username FROM Usuarios;";
  $result = $db -> prepare($query);
  $result -> execute();
  $usuarios = $result -> fetchAll();
  foreach ($usuarios as $usuario) {
    echo "<div class='item' data-value=$usuario[0]>$usuario[0]</div>";
  }
}


function items_generos(){
  global $db;
  $query = "SELECT nombre, id FROM Generos;";
  $result = $db -> prepare($query);
  $result -> execute();
  $generos = $result -> fetchAll();
  foreach ($generos as $genero) {
    echo "<div class='item' data-value=$genero[1]>$genero[0]</div>";
  }
}


function items_actores(){
  global $db;
  $query = "SELECT nombre, id FROM Actores;";
  $result = $db -> prepare($query);
  $result -> execute();
  $actores = $result -> fetchAll();
  foreach ($actores as $actor) {
    echo "<div class='item' data-value=$actor[1]>$actor[0]</div>";
  }
}


function items_series(){
  global $db;
  $query = "SELECT nombre, id FROM Series;";
  $result = $db -> prepare($query);
  $result -> execute();
  $series = $result -> fetchAll();
  foreach ($series as $serie) {
    echo "<div class='item' data-value=$serie[1]>$serie[0]</div>";
  }
}


function plan_restantes($usuario){
  global $db;
  $query = "SELECT u.username, p.nombre, u.restantes_mes, p.cantidad
            FROM Usuarios AS u, Planes AS p, Contrata AS c
            WHERE u.username = c.username AND c.id_plan = p.id AND u.username = :username";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> execute();
  $usuario = $result -> fetch();
  if (!(empty($usuario))){
    $vistos = (int)$usuario[3] - (int)$usuario[2];
    $html = "<div class='ui fluid card'>
    <div class='content'>
        <div class='header'>$usuario[0]</div>
        <div class='meta'>Plan: $usuario[1]</div>
        <div class='description'>
            <div class='ui inverted orange progress' data-value='$vistos' data-total='$usuario[3]' id='bar_$usuario[0]'>
                <div class='bar'>
                    <div class='progress'></div>
                </div>
            </div>
        </div>
        <p>Vistos: $vistos<br>Restantes: $usuario[2]<br>Total disponible: $usuario[3]</p>
    </div>
</div>
<script>$('#bar_$usuario[0]').progress();</script>
<style type='text/css'>.ui.card .meta{color: rgba(255, 255, 255, 0.7)!important;}.ui.card{color: #fff!important;}.ui.card .content {background-color: #1b1c1d!important;}.ui.card .header {color: #fff!important;}</style>";
    echo json_encode($html);
  }
  else {
    echo json_encode("<div class='ui card'><div class='content'><div class='header'>Nice try</div></div></div>");
  }
}


function peliculas_ano($usuario){
  global $db;
  $query = "SELECT e.nombre, v.fecha
            FROM usuarios AS u, vistos AS v, entretenimientos AS e, peliculas as p
            WHERE u.username = v.username
            AND v.id_entretenimiento = e.id
            AND e.id = p.id_entretenimiento
            AND v.fecha >= '2016-01-01'
            AND v.fecha < '2017-01-01'
            AND u.username = :username";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> execute();
  $peliculas = $result -> fetchAll();
  $html = "<h4>Películas vistas por $usuario en el año</h4><table class='ui orange celled table unstackable'><thead><tr><th>Nombre Película</th><th>Fecha</th></tr></thead><tbody>";
  if (!(empty($peliculas))){
    foreach ($peliculas as $pelicula) {
      $html .= "<tr><td>$pelicula[0]</td><td>$pelicula[1]</td></tr>";
    }
  }
  else {
    $html .= "<tr><td colspan=2><i>El usuario '$usuario' no ha visto películas en dicho periodo</i></td></tr>";
  }
  $html .= "</tbody></table>";
  echo json_encode($html);
}


function peliculas_gen_fecha($genero='', $fecha=''){
  global $db;
  if ($genero == '' and $fecha != ''){
    $query = "SELECT e.nombre, g.nombre, e.fecha
              FROM entretenimientos AS e, esde, generos AS g, peliculas AS p
              WHERE e.id = esde.id_entretenimiento
                  AND esde.id_genero = g.id
                  AND e.id = p.id_entretenimiento
                  AND e.fecha = :fecha";
    $result = $db -> prepare($query);
    $result -> bindParam(':fecha', $fecha);
  }
  elseif ($fecha == '' and $genero != ''){
    $query = "SELECT e.nombre, g.nombre, e.fecha
              FROM entretenimientos AS e, esde, generos AS g, peliculas AS p
              WHERE e.id = esde.id_entretenimiento
                  AND esde.id_genero = g.id
                  AND e.id = p.id_entretenimiento
                  AND g.id = :id_genero";
    $result = $db -> prepare($query);
    $result -> bindParam(':id_genero', $genero);
  }
  else {
    $query = "SELECT e.nombre, g.nombre, e.fecha
              FROM entretenimientos AS e, esde, generos AS g, peliculas AS p
              WHERE e.id = esde.id_entretenimiento
                  AND esde.id_genero = g.id
                  AND e.id = p.id_entretenimiento
                  AND g.id = :id_genero
                  AND e.fecha = :fecha";
    $result = $db -> prepare($query);
    $result -> bindParam(':id_genero', $genero);
    $result -> bindParam(':fecha', $fecha);
  }
  $result -> execute();
  $peliculas = $result -> fetchAll();
  $html = "<h4>Películas que calzan con los criterios</h4><table class='ui orange celled table unstackable'><thead><tr><th>Nombre Película</th><th>Género</th><th>Fecha</th></tr></thead><tbody>";
  if (!(empty($peliculas))){
    foreach ($peliculas as $pelicula) {
      $html .= "<tr><td>$pelicula[0]</td><td>$pelicula[1]</td><td>$pelicula[2]</td></tr>";
    }
  }
  else {
    $html .= "<tr><td colspan=3><i>No hay películas para los criterios entregados</i></td></tr>";
  }
  $html .= "</tbody></table>";
  echo json_encode($html);
}


function peliculas_actor($actor){
  global $db;
  $query = "SELECT e.nombre, e.fecha
            FROM actores AS a, actuan, entretenimientos AS e, peliculas AS p
            WHERE a.id = actuan.id_actor
                AND actuan.id_entretenimiento = e.id
                AND e.id = p.id_entretenimiento
                AND a.id = :actor";
  $result = $db -> prepare($query);
  $result -> bindParam(':actor', $actor);
  $result -> execute();
  $peliculas = $result -> fetchAll();
  $html = "<h4>Películas en las que actúa el actor/actriz</h4><table class='ui orange celled table unstackable'><thead><tr><th>Nombre Película</th><th>Fecha</th></tr></thead><tbody>";
  if (!(empty($peliculas))){
    foreach ($peliculas as $pelicula) {
      $html .= "<tr><td>$pelicula[0]</td><td>$pelicula[1]</td></tr>";
    }
  }
  else {
    $html .= "<tr><td colspan=2><i>El actor/actriz no actúa en ninguna <b>película</b> de MaquiView</i></td></tr>";
  }
  $html .= "</tbody></table>";
  echo json_encode($html);
}


function temporadas_capitulos($serie){
  global $db;
  $query = "SELECT e.nombre, c.temporada
            FROM series AS s, pertenece, capitulos AS c, entretenimientos AS e
            WHERE s.id = pertenece.id_serie
                AND pertenece.id_capitulo = c.id_entretenimiento
                AND c.id_entretenimiento = e.id
                AND s.id = :serie";
  $result = $db -> prepare($query);
  $result -> bindParam(':serie', $serie);
  $result -> execute();
  $capitulos = $result -> fetchAll();
  $html = "<h4>Capítulos y temporadas de la serie</h4><table class='ui orange celled table unstackable'><thead><tr><th>Nombre Capítulo</th><th>Temporada</th></tr></thead><tbody>";
  if (!(empty($capitulos))){
    foreach ($capitulos as $capitulo) {
      $html .= "<tr><td>$capitulo[0]</td><td>$capitulo[1]</td></tr>";
    }
  }
  else {
    $html .= "<tr><td colspan=2><i>La serie no se encuentra en MaquiView</i></td></tr>";
  }
  $html .= "</tbody></table>";
  echo json_encode($html);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $consulta = $_POST['consulta'];
  if ($consulta == 'consulta_1'){
    $usuario = $_POST['user'];
    plan_restantes($usuario);
  }
  elseif ($consulta == 'consulta_2'){
    $usuario = $_POST['user'];
    peliculas_ano($usuario);
  }
  elseif ($consulta == 'consulta_3'){
    $genero = $_POST['genero'];
    $fecha = $_POST['fecha'];
    peliculas_gen_fecha($genero, $fecha);
  }
  elseif ($consulta == 'consulta_4'){
    $actor = $_POST['actor'];
    peliculas_actor($actor);
  }
  elseif ($consulta == 'consulta_5'){
    $serie = $_POST['serie'];
    temporadas_capitulos($serie);
  }
}



?>