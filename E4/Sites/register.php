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


function registrar_usuario($usuario,$password,$nombre, $sexo, $edad, $email, $quipasa){
  $retorno = 0;
  if ($quipasa == true) {
    global $db2;
    $query = "INSERT INTO usuario VALUES(:username, :password, :sexo, :email)";
    $result = $db2 -> prepare($query);
    $result -> bindParam(':username', $usuario);
    $result -> bindParam(':password', $password);
    $result -> bindParam(':sexo', $sexo);
    $result -> bindParam(':email', $email);
    $result -> execute();
    $count = $result -> rowCount();
  }
  global $db;
  $query = "INSERT INTO usuarios VALUES(:username, :password, :nombre, :sexo, :edad, :email, :restantes_mes)";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> bindParam(':password', $password);
  $result -> bindParam(':nombre', $nombre);
  $result -> bindParam(':sexo', $sexo);
  $result -> bindParam(':edad', $edad);
  $result -> bindParam(':email', $email);
  $restantes = 0;
  $result -> bindParam(':restantes_mes', $restantes);
  $result -> execute();
  $count = $result -> rowCount();
  $result = $result -> fetch();
  set_plan_basico($usuario);
}


function register(){
  // verifica error de empty primero
  $required = array('username', 'password', 'nombre', 'sexo', 'edad', 'email', 'quipasa');
  $error = false;
  foreach($required as $field) {
    if (empty($_POST[$field])) {
      $error = true;
    }
  }
  if ($error){
    $arr = array('error' => 'Por favor ingrese todos los valores.', 'worked' => false);
    return $arr;
  }
  // ahora verifica que el username no exista
  global $db;
  $query = "SELECT username from usuarios where username=:username";
  $result = $db -> prepare($query);
  $result -> bindParam(':username', $_POST['username']);
  $result -> execute();
  $count1 = $result -> rowCount();
  global $db2;
  $query = "SELECT username from usuario where username=:username";
  $result = $db2 -> prepare($query);
  $result -> bindParam(':username', $_POST['username']);
  $result -> execute();
  $count2 = $result -> rowCount();
  if ($count1 > 0 or $count2 > 0) {
    $arr = array('error' => 'Usuario ya utilizado.', 'worked' => false);
    return $arr;
  }
  // ahora ya obtengo valores y registro user.
  $quipasa = false;
  if ($_POST['quipasa'] == 'on'){
    $quipasa = true;
  }
  $usuario = $_POST['username'];
  $password = $_POST['password'];
  $nombre = $_POST['nombre'];
  $sexo = $_POST['sexo'];
  $edad = $_POST['edad'];
  $email = $_POST['email'];
  registrar_usuario($usuario,$password,$nombre, $sexo, $edad, $email, $quipasa);
  $arr = array('worked' => true);
  return $arr;
}

function set_plan_basico($usuario){
  global $db;
  $query = "INSERT INTO contrata VALUES(:id_plan, :username, :fecha)";
  $result = $db -> prepare($query);
  $id = 1;
  $result -> bindParam(':id_plan', $id);
  $result -> bindParam(':username', $usuario);
  $hoy = date("Y-m-d");
  $result -> bindParam(':fecha', $hoy);
  $result -> execute();
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
  else if ($verificacion == 1) {
    $_SESSION['username'] = $result[0];
    $_SESSION['type'] = 1;
    echo json_encode(true);
  }
  else
  {
      echo json_encode(false); //Si la función verificar_login() no pasa, que se muestre un mensaje de error.
  }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $data = register();
  if ($data['worked'] == true) {
    login();
  }
  else {
    echo json_encode($data);
  }

}
?>