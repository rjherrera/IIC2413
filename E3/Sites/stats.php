<?php

try{
  $db = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}


function n_usuarios(){
  global $db;
  $query = "SELECT COUNT(*) FROM Usuarios;";
  $result = $db -> prepare($query);
  $result -> execute();
  $usuarios = $result -> fetch();
  echo "$usuarios[0]";
}

function n_peliculas(){
  global $db;
  $query = "SELECT COUNT(*) FROM Peliculas;";
  $result = $db -> prepare($query);
  $result -> execute();
  $peliculas = $result -> fetch();
  echo "$peliculas[0]";
}

function n_series(){
  global $db;
  $query = "SELECT COUNT(*) FROM Series;";
  $result = $db -> prepare($query);
  $result -> execute();
  $series = $result -> fetch();
  echo "$series[0]";
}

function n_capitulos(){
  global $db;
  $query = "SELECT COUNT(*) FROM Capitulos;";
  $result = $db -> prepare($query);
  $result -> execute();
  $capitulos = $result -> fetch();
  echo "$capitulos[0]";
}

function n_directores(){
  global $db;
  $query = "SELECT COUNT(*) FROM Directores;";
  $result = $db -> prepare($query);
  $result -> execute();
  $directores = $result -> fetch();
  echo "$directores[0]";
}

function n_comentarios(){
  global $db;
  $query = "SELECT COUNT(*) FROM Comenta;";
  $result = $db -> prepare($query);
  $result -> execute();
  $comentarios = $result -> fetch();
  echo "$comentarios[0]";
}

?>