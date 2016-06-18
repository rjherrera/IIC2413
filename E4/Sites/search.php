<?php

try{
  $db = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}

$search_type = $_GET['search_type'];
$input_values = $_GET['input_values'];
$content_type = $_GET['content_type'][0];

if ($search_type == 'nombre') {
  $query = "select e.nombre, e.duracion, e.fecha, p.oscares, e.id
    from entretenimientos as e, peliculas as p
    where e.id=p.id_entretenimiento
      and lower(e.nombre) like ?;";
  $result = $db -> prepare($query);
  $result -> execute(array('%'. $input_values[0] .'%'));
}
else if ($search_type == 'genero') {
  $query = "select e.nombre, e.duracion, e.fecha, p.oscares, e.id
    from entretenimientos as e, peliculas as p, esde, generos as g
    where e.id=p.id_entretenimiento
      and e.id=esde.id_entretenimiento
      and esde.id_genero=g.id
      and lower(g.nombre) like ?;";
  $result = $db -> prepare($query);
  $result -> execute(array('%'. $input_values[0] .'%'));
}
else if ($search_type == 'fecha') {
  $query = "select e.nombre, e.duracion, e.fecha, p.oscares, e.id
    from entretenimientos as e, peliculas as p
    where e.id=p.id_entretenimiento
      and e.fecha = date(?)
    order by e.fecha desc;";
  $result = $db -> prepare($query);
  $result -> execute(array($input_values[0]));
}
else if ($search_type == 'nombre-fecha') {
  $query = "select e.nombre, e.duracion, e.fecha, p.oscares, e.id
    from entretenimientos as e, peliculas as p
    where e.id=p.id_entretenimiento
      and lower(e.nombre) like ?
      and e.fecha = date(?)
    order by e.fecha desc;";
  $result = $db -> prepare($query);
  $result -> execute(array('%'. $input_values[0] .'%', $input_values[1]));
}
else if ($search_type == 'genero-fecha') {
  $query = "select e.nombre, e.duracion, e.fecha, p.oscares, e.id
    from entretenimientos as e, peliculas as p, esde, generos as g
    where e.id=p.id_entretenimiento
      and e.id=esde.id_entretenimiento
      and esde.id_genero=g.id
      and lower(g.nombre) like ?
      and e.fecha = date(?)
    order by e.fecha desc;";
  $result = $db -> prepare($query);
  $result -> execute(array('%'. $input_values[0] .'%', $input_values[1]));
}


$peliculas = $result -> fetchAll();
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

 ?>
