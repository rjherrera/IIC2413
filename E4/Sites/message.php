<?php

try{
  $db2 = new PDO("pgsql:dbname=grupo27;host=localhost;user=grupo27;password=grupo27");
}
catch(PDOException $e){
  echo $e -> getMessage();
}


function enviar_mensaje($mensaje, $to_user, $to_group, $from_user, $pelicula){
  global $db2;
  // el mensaje va si o si, ergo se mete a la db
  // $query = "INSERT into mensaje values (:id_msj, :mensaje, now()) RETURNING mid";
  if ($to_user != '' and $to_group != ''){
    $arr = array('error' => 'Solo puede mandar a un usuario o grupo a la vez. Limpie el formulario!');
    echo json_encode($arr);
    return false;
  }
  $mensaje = $pelicula . ' - ' . $mensaje;
  $query = "INSERT INTO mensaje SELECT max(mid) + 1, :mensaje, now() FROM mensaje RETURNING mid";
  $result = $db2 -> prepare($query);
  $result -> bindParam(':mensaje', $mensaje);
  $result -> execute();
  $id_msj = $result -> fetch()[0];
  // ahora ver para quien va, si pa user o pa group
  if ($to_group == ''){
    // quiere decir q va pa usuario
    $query = "INSERT into enviousuario values (:from_user, :id_msj, :to_user)";
    $result = $db2 -> prepare($query);
    $result -> bindParam(':from_user', $from_user);
    $result -> bindParam(':id_msj', $id_msj);
    $result -> bindParam(':to_user', $to_user);
  }
  else {
    // quiere decir q va pa grupo
    $query = "INSERT into enviogrupo values (:from_user, :id_msj, :to_group)";
    $result = $db2 -> prepare($query);
    $result -> bindParam(':from_user', $from_user);
    $result -> bindParam(':id_msj', $id_msj);
    $result -> bindParam(':to_group', $to_group);
  }
  $result -> execute();
  echo json_encode(true);
}



if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $to_user = $_POST['to_user'];
  $to_group = $_POST['to_group'];
  $mensaje = $_POST['mensaje'];
  $from_user = $_POST['nombre_u'];
  $pelicula = $_POST['nombre_p'];
  enviar_mensaje($mensaje, $to_user, $to_group, $from_user, $pelicula);
}


?>