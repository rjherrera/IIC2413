<?php
session_start();
try{
  $db = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}
try{
  $db2 = new PDO("pgsql:dbname=grupo27;host=localhost;user=grupo27;password=grupo27");
}
catch(PDOException $e){
  echo $e -> getMessage();
}



function verificar_login($usuario,$password,$quipasa,&$result){
  $retorno = 0;
  if ($quipasa == true) {
    global $db2;
    $query = "SELECT * FROM usuario WHERE username = :username and password = :password";
    $result = $db2 -> prepare($query);
    $result -> bindParam(':username', $usuario);
    $result -> bindParam(':password', $password);
    $result -> execute();
    $count = $result -> rowCount();
    if ($count == 1) {
      $retorno = $retorno + 1;
    }
  }
  global $db;
  $query = "SELECT * FROM usuarios WHERE username = :username and password = :password";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> bindParam(':password', $password);
  $result -> execute();
  $count = $result -> rowCount();
  $result = $result -> fetch();
  if ($count == 1) {
    $retorno = $retorno + 1;
  }
  return $retorno;
}

function login(){
  $quipasa = false;
  if ($_POST['quipasa'] == 'on'){
    $quipasa = true;
  }
  $verificacion = verificar_login($_POST['username'], $_POST['password'], $quipasa, $result);
  if($verificacion == 2){
    // Si el retorno de esa funcion es 1 quiere decir que encontró el usuario, ergo se logineó
    $_SESSION['username'] = $result[0];
    $_SESSION['type'] = 2;
    // Si se logra loginear, setea la variable de sesion y redirige a la pagina de usuario (home.php)
    echo json_encode(true);
    // header("location:home.php"); // funcionaria si no fuera por ajax
  }
  else if ($verificacion == 1 && $quipasa == false) {
    $_SESSION['username'] = $result[0];
    $_SESSION['type'] = 1;
    echo json_encode(true);
  }
  else if ($verificacion == 1 && $quipasa == true){
    echo json_encode(null); //Si la función verificar_login() no pasa, que se muestre un mensaje de error.
  }
  else {
    echo json_encode(false);
  }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  login();
}
?>