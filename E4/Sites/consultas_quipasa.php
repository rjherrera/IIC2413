<?php

try{
  $db = new PDO("pgsql:dbname=grupo27;host=localhost;user=grupo27;password=grupo27");
}
catch(PDOException $e){
  echo $e -> getMessage();
}

try{
  $db2 = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}


function recomendaciones_peliculas($username){
  global $db;
  global $db2;

  $query = "
    select u.username, count(*) as c from usuario as u, enviousuario as eu, mensaje as m
    where
      eu.mid=m.mid
      and ((eu.emisor=:username and eu.usuario_receptor=u.username)
        or (eu.emisor=u.username and eu.usuario_receptor=:username))
      and fecha >= now() - interval '1 year'
      and fecha <= now()
    group by u.username order by c desc limit 5;";

  $result = $db -> prepare($query);
  $result -> bindParam(':username', $username);
  $result -> execute();

  $query2 = "
    select username from usuarios;";
  $result2 = $db2 -> prepare($query2);
  $result2 -> execute();
  $maqui_users = $result2 -> fetchAll(PDO::FETCH_COLUMN, 0);

  $best_users = array();
  $ranking = $result -> fetchAll(PDO::FETCH_COLUMN, 0);
  foreach ($ranking as $entry) {
    if (count($best_users) == 5) {
      break;
    }
    if (in_array($entry, $maqui_users)) {
      array_push($best_users, $entry);
    }
  }

  if (count($best_users) != 0) {
    $query3 = "
      select e.nombre, e.duracion, e.fecha, p.oscares, e.id
      from
        (select p.id_entretenimiento, count(*) as c
        from vistos as v, peliculas as p
        where v.id_entretenimiento=p.id_entretenimiento
        and (username=?";
    if (count($best_users) > 1) {
      foreach (range(1, count($best_users) - 1) as $i) {
        $query3 = $query3 . ' or username=?';
      }
    }
    $query3 = $query3 . ")
      group by p.id_entretenimiento) as s,
      entretenimientos as e,
      peliculas as p
      where e.id=s.id_entretenimiento
        and e.id=p.id_entretenimiento;
      ";
    $result3 = $db2 -> prepare($query3);
    $result3 -> execute($best_users);
    $peliculas = $result3 -> fetchAll();

    foreach ($peliculas as $pelicula) {
      echo "<a class='card' href='ver_pelicula.php?id=$pelicula[4]'>
        <div class='image'>
          <img src='static/img/$pelicula[0].jpg'>
        </div>
        <div class='content'>
          <div class='header'>$pelicula[0]</div>
          <div class='meta'>
            Friends
          </div>
          <div class='description'>
            Duracion: $pelicula[1]
          </div>
        </div>
        <div class='extra content'>
          <span class='right floated'>
            Lanzamiento: $pelicula[2]
          </span>
          <span>
            <i class='user icon'></i>
            $pelicula[3] Oscares
          </span>
        </div>
      </a>";
    }
  }
  else {
    echo '<div class="ui error message">Tienes que haber intercambiado mensajes con al menos un usuario en el último año</div>';
  }
}

function recomendaciones_series($username){
  global $db;
  global $db2;

  $query = "
    select u.username, count(*) as c from usuario as u, enviousuario as eu, mensaje as m
    where
      eu.mid=m.mid
      and ((eu.emisor=:username and eu.usuario_receptor=u.username)
        or (eu.emisor=u.username and eu.usuario_receptor=:username))
      and fecha >= now() - interval '1 year'
      and fecha <= now()
    group by u.username order by c desc limit 5;";

  $result = $db -> prepare($query);
  $result -> bindParam(':username', $username);
  $result -> execute();

  $query2 = "
    select username from usuarios;";
  $result2 = $db2 -> prepare($query2);
  $result2 -> execute();
  $maqui_users = $result2 -> fetchAll(PDO::FETCH_COLUMN, 0);

  $best_users = array();
  $ranking = $result -> fetchAll(PDO::FETCH_COLUMN, 0);
  foreach ($ranking as $entry) {
    if (count($best_users) == 5) {
      break;
    }
    if (in_array($entry, $maqui_users)) {
      array_push($best_users, $entry);
    }
  }

  if (count($best_users) != 0) {
    $query3 = "
      select e.nombre, e.duracion, e.fecha, p.oscares, e.id
      from
        (select p.id_entretenimiento, count(*) as c
        from vistos as v, peliculas as p
        where v.id_entretenimiento=p.id_entretenimiento
        and (username=?";
    if (count($best_users) > 1) {
      foreach (range(1, count($best_users) - 1) as $i) {
        $query3 = $query3 . ' or username=?';
      }
    }
    $query3 = $query3 . ")
      group by p.id_entretenimiento) as s,
      entretenimientos as e,
      series as p
      where e.id=s.id_entretenimiento
        and e.id=p.id_entretenimiento;
      ";
    $result3 = $db2 -> prepare($query3);
    $result3 -> execute($best_users);
    $peliculas = $result3 -> fetchAll();

    foreach ($peliculas as $pelicula) {
      echo "<a class='card' href='ver_pelicula.php?id=$pelicula[4]'>
        <div class='image'>
          <img src='static/img/$pelicula[0].jpg'>
        </div>
        <div class='content'>
          <div class='header'>$pelicula[0]</div>
          <div class='meta'>
            Friends
          </div>
          <div class='description'>
            Duracion: $pelicula[1]
          </div>
        </div>
        <div class='extra content'>
          <span class='right floated'>
            Lanzamiento: $pelicula[2]
          </span>
          <span>
            <i class='user icon'></i>
            $pelicula[3] Oscares
          </span>
        </div>
      </a>";
    }
  }
  else {
    echo '<div class="ui error message">Tienes que haber intercambiado mensajes con al menos un usuario en el último año</div>';
  }
}



 ?>
