<?php

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


function mensajes_pelicula($usuario, $id_pelicula){
  // voy a obtener el director, nombre y un actor de la pelicula
  global $db;
  // director
  $query = "SELECT directores.nombre FROM entretenimientos AS e, dirige AS d, directores
  WHERE e.id = :id_pelicula AND e.id = d.id_entretenimiento AND d.id_director = directores.id";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_pelicula', $id_pelicula);
  $result -> execute();
  $director = "%" . $result -> fetch()[0] . "%";
  // nombre
  $query = "SELECT nombre from entretenimientos as e, peliculas as p where e.id = p.id_entretenimiento and e.id=:id_pelicula";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_pelicula', $id_pelicula);
  $result -> execute();
  $nombre = "%" . $result -> fetch()[0] . "%";
  // primer actor
  $query = "SELECT a.nombre from actores as a, actuan as ac, entretenimientos as e, peliculas as p where e.id = ac.id_entretenimiento and a.id = ac.id_actor and p.id_entretenimiento = e.id and e.id = :id_pelicula limit 1";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_pelicula', $id_pelicula);
  $result -> execute();
  $actor = "%" . $result -> fetch()[0] . "%";
  // if ($actor == '%%'){
  //   $actor = '|nohaynadaquematcheeconesto|.-.|oporlomenoslodudo|';
  // }
  global $db2;
  // mensajes de algun usuario hacia nuestro usuario
  $query = "SELECT mensaje, fecha, username from enviousuario as e, mensaje as m, usuario as u where m.mid = e.mid and u.username = e.emisor and usuario_receptor = :username and (LOWER(mensaje) like LOWER(:director) or LOWER(mensaje) like LOWER(:actor) or LOWER(mensaje) like LOWER(:nombre))";
  $result = $db2 -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> bindParam(':director', $director);
  $result -> bindParam(':actor', $actor);
  $result -> bindParam(':nombre', $nombre);
  $result -> execute();
  $mensajes = $result -> fetchAll();
  // mensajes de cualquier grupo hacia nuestro usuario
  $query = "SELECT mensaje, fecha, CONCAT(e.emisor, '@grupo', p.grupo) from enviogrupo as e, mensaje as m, usuario as u, pertenencia as p where m.mid = e.mid and cast(p.grupo as int) = e.grupo_receptor and u.username = p.usuario and u.username = :username and (LOWER(mensaje) like LOWER(:director) or LOWER(mensaje) like LOWER(:actor) or LOWER(mensaje) like LOWER(:nombre))";
  $result = $db2 -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> bindParam(':director', $director);
  $result -> bindParam(':actor', $actor);
  $result -> bindParam(':nombre', $nombre);
  $result -> execute();
  $mensajes = array_merge($result -> fetchAll(), $mensajes);
  if (!empty($mensajes)){
    foreach ($mensajes as $mensaje) {
      echo "
        <div class='comment'>
          <a class='avatar'>
            <img src='https://cdn2.iconfinder.com/data/icons/email-6/24/envelope-circle-512.png'>
          </a>
          <div class='content'>
            <a class='author'>$mensaje[2]</a>
            <div class='metadata'>
              <span class='date'>$mensaje[1]</span>
            </div>
            <div class='text'>
              $mensaje[0]
            </div>
          </div>
        </div>
      ";
    }
  }
  else {
    echo "<p><i>No hay mensajes aún</i></p>";
  }
}


function mensajes_serie($usuario, $id_serie){
  // voy a obtener el director, nombre y un actor de la pelicula
  global $db;
  // director
  $query = "SELECT directores.nombre FROM entretenimientos AS e, dirige AS d, directores
  WHERE e.id = :id_serie AND e.id = d.id_entretenimiento AND d.id_director = directores.id";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_serie', $id_serie);
  $result -> execute();
  $director = "%" . $result -> fetch()[0] . "%";
  // nombre
  $query = "SELECT nombre from entretenimientos as e, capitulos as c where e.id = c.id_entretenimiento and e.id=:id_serie";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_serie', $id_serie);
  $result -> execute();
  $nombre = "%" . $result -> fetch()[0] . "%";
  // primer actor
  $query = "SELECT a.nombre from actores as a, actuan as ac, entretenimientos as e, capitulos as c where e.id = ac.id_entretenimiento and a.id = ac.id_actor and c.id_entretenimiento = e.id and e.id = :id_serie limit 1";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_serie', $id_serie);
  $result -> execute();
  $actor = "%" . $result -> fetch()[0] . "%";
  global $db2;
  // mensajes de algun usuario hacia nuestro usuario
  $query = "SELECT mensaje, fecha, username from enviousuario as e, mensaje as m, usuario as u where m.mid = e.mid and u.username = e.emisor and usuario_receptor = :username and (LOWER(mensaje) like LOWER(:director) or LOWER(mensaje) like LOWER(:actor) or LOWER(mensaje) like LOWER(:nombre))";
  $result = $db2 -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> bindParam(':director', $director);
  $result -> bindParam(':actor', $actor);
  $result -> bindParam(':nombre', $nombre);
  $result -> execute();
  $mensajes = $result -> fetchAll();
  // mensajes de cualquier grupo hacia nuestro usuario
  $query = "SELECT mensaje, fecha, CONCAT(e.emisor, '@grupo', p.grupo) from enviogrupo as e, mensaje as m, usuario as u, pertenencia as p where m.mid = e.mid and cast(p.grupo as int) = e.grupo_receptor and u.username = p.usuario and u.username = :username and (LOWER(mensaje) like LOWER(:director) or LOWER(mensaje) like LOWER(:actor) or LOWER(mensaje) like LOWER(:nombre))";
  $result = $db2 -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> bindParam(':director', $director);
  $result -> bindParam(':actor', $actor);
  $result -> bindParam(':nombre', $nombre);
  $result -> execute();
  $mensajes = array_merge($result -> fetchAll(), $mensajes);
  if (!empty($mensajes)){
    foreach ($mensajes as $mensaje) {
      echo "
        <div class='comment'>
          <a class='avatar'>
            <img src='https://cdn2.iconfinder.com/data/icons/email-6/24/envelope-circle-512.png'>
          </a>
          <div class='content'>
            <a class='author'>$mensaje[2]</a>
            <div class='metadata'>
              <span class='date'>$mensaje[1]</span>
            </div>
            <div class='text'>
              $mensaje[0]
            </div>
          </div>
        </div>
      ";
    }
  }
  else {
    echo "<p><i>No hay mensajes aún</i></p>";
  }
}

function items_grupos($usuario){
  global $db2;
  $query = "SELECT gid, nombre FROM pertenencia AS p, grupo AS g WHERE CAST(p.grupo as int) = g.gid AND usuario = :username order by nombre";
  $result = $db2 -> prepare($query);
  $result -> bindParam(':username', $usuario);
  $result -> execute();
  $grupos = $result -> fetchAll();
  $string = "";
  foreach ($grupos as $grupo) {
    $string .= "<div class='item' data-value=$grupo[0]>$grupo[1]</div>";
  }
  return $string;
}

function items_personas(){
  global $db2;
  $query = "SELECT username from usuario order by username;";
  $result = $db2 -> prepare($query);
  $result -> execute();
  $usuarios = $result -> fetchAll();
  $string = "";
  foreach ($usuarios as $usuario) {
    $string .= "<div class='item' data-value=$usuario[0]>$usuario[0]</div>";
  }
  return $string;
}

?>