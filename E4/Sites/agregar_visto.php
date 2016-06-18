<?php

include 'base.php';
redirect_if_anonymous();

try{
  $db = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}


function ver($usuario, $id_entretenimiento){
  if (puede_ver($usuario, $id_entretenimiento)){
    agrega_visto($usuario, $id_entretenimiento);
    echo json_encode(true);
  }
  else {
    echo json_encode(false);
  }
}

function puede_ver($usuario, $id_entretenimiento){
  global $db;
  // previos
  $first_day_this_month = date('Y-m-01');
  $last_day_this_month  = date('Y-m-t');
  // query para sacar el id del plan
  $query = "SELECT id_plan from contrata where username=:username";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> execute();
  $id_plan = $result -> fetch()[0];
  // query para sacar la cantidad
  $query = "SELECT cantidad from planes where id=:id_plan";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_plan', $id_plan);
  $result -> execute();
  $cantidad = $result -> fetch()[0];
  // query para sacar el numero de peliculas
  $query = "SELECT count(*) from vistos natural join peliculas where username=:username and fecha >= :inicio and fecha <= :termino";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> bindParam(':inicio', $first_day_this_month);
  $result -> bindParam(':termino', $last_day_this_month);
  $result -> execute();
  $n_peliculas = $result -> fetch()[0];
  // query para sacar el numero de series
  $query = "SELECT count(*) from vistos natural join capitulos series where username=:username and fecha >= :inicio and fecha <= :termino";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> bindParam(':inicio', $first_day_this_month);
  $result -> bindParam(':termino', $last_day_this_month);
  $result -> execute();
  $n_capitulos = $result -> fetch()[0];
  // ahora pregunto si es serie o pelicula (basicamente veo si la consulta de peliculas con id=id_entretenimiento es vacia o no)
  $query = "SELECT * from entretenimientos join peliculas on id_entretenimiento = id and id=:id_entretenimiento";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_entretenimiento', $id_entretenimiento);
  $result -> execute();
  $hay_peliculas = $result -> fetchAll();

  // ahora que ya tengo todo veo si puede ver
  if (!empty($hay_peliculas)) {
    // si no está vacio quiere decir q es pelicula así que:
    if ($cantidad >= (($n_capitulos / 4) + $n_peliculas) + 1){
      return true;
    }
    else {
      return false;
    }
  }
  else {
    // si está vacio significa q es serie (no hay otra opcion)
    if ($cantidad >= (($n_capitulos / 4) + $n_peliculas) + 1/4){
      return true;
    }
    else {
      return false;
    }
  }
}


function agrega_visto($usuario, $id_entretenimiento){
  global $db;
  $query = "INSERT INTO vistos VALUES (:id_entretenimiento, :username, :fecha)";
  $hoy = date("Y-m-d");
  $result = $db -> prepare($query);
  $result -> bindParam(':id_entretenimiento', $id_entretenimiento);
  $result -> bindParam(':username', $usuario);
  $result -> bindParam(':fecha', $hoy);
  $result -> execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  ver($_POST['username'], $_POST['entretenimiento']);
}