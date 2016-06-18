<?php


try{
  $db = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}

function plan_actual($usuario){
  global $db;
  $query = "SELECT planes.nombre FROM planes, contrata, usuarios
  WHERE usuarios.username = contrata.username
  AND contrata.id_plan = planes.id
  AND usuarios.username = :username";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> execute();
  $plan = $result -> fetch();
  echo "$plan[0]";
};


function cambiar_plan($usuario, $id_plan){
  // Eliminamos el contrato anterior
  global $db;
  $query2 = "DELETE FROM contrata WHERE username = :username";
  $result2 = $db -> prepare($query2);
  $result2 -> bindParam(':username', $usuario);
  $result2 -> execute();
  // Creamos el nuevo
  $query = "INSERT INTO contrata VALUES(:id_plan, :username, :fecha)";
  $result = $db -> prepare($query);
  $id = $id_plan;
  $result -> bindParam(':id_plan', $id);
  $result -> bindParam(':username', $usuario);
  $hoy = date("Y-m-d");
  $result -> bindParam(':fecha', $hoy);
  $result -> execute();
  echo json_encode(true);
};


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $usuario = $_POST['username'];
  $plan = $_POST['plan_escogido'];
  cambiar_plan($usuario, $plan);
}


function restantes($usuario){
  global $db;
  // previos
  $first_day_this_month = date('Y-m-01');
  $last_day_this_month  = date('Y-m-t');

  $query = "SELECT planes.cantidad FROM planes, contrata, usuarios
            WHERE usuarios.username = contrata.username
            AND contrata.id_plan = planes.id
            AND usuarios.username = :username";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $usuario);
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
  $vistos = (($n_capitulos / 4) + $n_peliculas);
  echo "Has visto " . $vistos . " de un máximo de <span id='n_plan'>" . $cantidad . "</span>";
}

?>