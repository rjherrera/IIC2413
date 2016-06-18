<?php


try{
  $db = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}

function items_peliculas($query_string){
  global $db;
  $query = $query_string;
  $result = $db -> prepare($query);
  $result -> execute();
  $peliculas = $result -> fetchAll();
  foreach ($peliculas as $pelicula) {
    echo "<a class='card' href='ver_pelicula.php?id=$pelicula[4]'>
    <div class='image'>
      <img src='static/img/$pelicula[0].jpg'>
    </div>
    <div class='content'>
      <div class='header'>$pelicula[0]</div>
      <!-- <div class='meta'>
        Friends
      </div>-->
      <div class='description'>
        Duracion: $pelicula[1]
      </div>
    </div>
    <div class='extra content'>
      <span class='right floated'>
        $pelicula[2]
      </span>
      <span>
        <i class='user icon'></i>
        $pelicula[3] Oscares
      </span>
    </div>
  </a>";
  }
}

// href='ver_serie.php?id=$serie[4]'

function items_series_general($query_string){
  global $db;
  $query = $query_string;
  $result = $db -> prepare($query);
  $result -> execute();
  $series = $result -> fetchAll();
  foreach ($series as $serie) {
    $string_capitulos = obtener_capitulos($serie[2]);
    echo "
  <a class='card' id=card_serie_$serie[2] onclick='$(\"#modal_$serie[2]\").modal(\"show\");'>
    <div class='image'>
      <img src='static/img/$serie[0].jpg'>
    </div>
    <div class='content'>
      <div class='header'>$serie[0]</div>
      <div class='meta'>
        $serie[1] Capitulos por Temporada
      </div>
      <!-- <div class='description'>
        Descript
      </div> -->
    </div>
    <!-- <div class='extra content'>
      <span class='right floated'>
        Lanzamiento:
      </span>
      <span>
        <i class='user icon'></i>
        Algo
      </span>
    </div>  -->
  </a>
  <div class='ui modal' id='modal_$serie[2]'>
    <i class='close icon'></i>
    <div class='header'>
      <h1> $serie[0]</h1>
    </div>
    <div class='image content'>
      <div class='ui medium image'>
        <img src='static/img/$serie[0].jpg'>
      </div>
      <div class='description' style='width:100%;'>
        <div class='ui fluid inverted segment'>
          ". $string_capitulos . "
        </div>
      </div>
    </div>
    <div class='actions'>
      <div class='ui negative right labeled icon button'>
        Cancel
        <i class='remove icon'></i>
      </div>
    </div>
  </div>";
  }
}

function items_peliculas_busqueda($nombre){
  global $db;
  $query = "SELECT e.nombre, e.duracion, e.fecha, e.id
  FROM entretenimientos AS e
  WHERE e.nombre like '%:nombre%' ";
  $result = $db -> prepare($query);
  $result -> bindparam(':nombre', $nombre);
  $result -> execute();
  $peliculas = $result -> fetchAll();
  foreach ($peliculas as $pelicula) {
    echo "<a class='card' href='ver_pelicula.php?id=$pelicula[3]'>
    <div class='image'>
      <img src='static/img/$pelicula[0].jpg'>
    </div>
    <div class='content'>
      <div class='header'>$pelicula[0]</div>
      <!-- <div class='meta'>
        Friends
      </div>-->
      <div class='description'>
        Duracion: $pelicula[1]
      </div>
    </div>
    <div class='extra content'>
      <span class='right floated'>
        $pelicula[2]
      </span>
    </div>
  </a>";
  }
}


function obtener_capitulos($id_serie){
  global $db;
  $query = "SELECT count(*), temporada from capitulos as c, pertenece as p where p.id_capitulo = c.id_entretenimiento and id_serie = :id_serie group by temporada";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_serie', $id_serie);
  $result -> execute();
  $temporadas = $result -> fetchAll();
  $todo = "";
  foreach ($temporadas as $temporada) {
    $todo .= "<div class='ui inverted accordion'>
                <div class='title'>
                  <i class='dropdown icon'></i>
                  Temporada" . $temporada[1] . "
                </div>
                <div class='content'>
                  <div class='ui inverted link divided list'>";
    $query1 = "SELECT e.nombre, c.temporada, e.duracion, e.fecha, c.id_entretenimiento FROM entretenimientos AS e, capitulos AS c, pertenece AS p, series AS s WHERE s.id = :id_serie AND e.id = c.id_entretenimiento AND p.id_capitulo = c.id_entretenimiento AND p.id_serie = s.id and c.temporada = :temporada";
    $result1 = $db -> prepare($query1);
    $result1 -> bindParam(':id_serie', $id_serie);
    $result1 -> bindParam(':temporada', $temporada[1]);
    $result1 -> execute();
    $capitulos = $result1 -> fetchAll();
    foreach ($capitulos as $capitulo) {
      $todo .= "<a class='item' href='ver_serie.php?id=$capitulo[4]'>
      <i class='ui ticket middle aligned icon'></i>
      <div class='content'>
        $capitulo[0]
      </div>
    </a>";
    }
    $todo .= "</div></div></div>";
  }
  return $todo;
}


function numero_de_series(){
  global $db;
  $query = "SELECT count(*) FROM series";
  $result = $db -> prepare($query);
  $result -> execute();
  $numero = $result -> fetch();
  echo "$numero[0]";
}

function actores_pelicula($id_pelicula){
  global $db;
  $query = "SELECT actores.nombre FROM entretenimientos AS e, actuan AS a, actores
  WHERE e.id = :id_pelicula AND e.id = a.id_entretenimiento AND a.id_actor = actores.id";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_pelicula', $id_pelicula);
  $result -> execute();
  $actores = $result -> fetchAll();
  $string = "";
  foreach ($actores as $actor) {
    $string .= "<li> $actor[0] </li>";
  }
  return $string;
}


function directores_pelicula($id_pelicula){
  global $db;
  $query = "SELECT directores.nombre FROM entretenimientos AS e, dirige AS d, directores
  WHERE e.id = :id_pelicula AND e.id = d.id_entretenimiento AND d.id_director = directores.id";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_pelicula', $id_pelicula);
  $result -> execute();
  $directores = $result -> fetchAll();
  $string = "";
  foreach ($directores as $director) {
    $string .= $director[0] . ' - ';
  }
  $string = rtrim($string, "- ");
  return $string;
}

function nombre_pelicula($id_pelicula){
  global $db;
  $query = "SELECT e.nombre
  FROM entretenimientos AS e, peliculas AS p
  WHERE e.id = :id_pelicula AND e.id = p.id_entretenimiento";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_pelicula', $id_pelicula);
  $result -> execute();
  $pelicula = $result -> fetch();
  return $pelicula[0];
}

function item_pelicula_descripcion($id_pelicula){
  $name = nombre_pelicula($id_pelicula);
  $directores = directores_pelicula($id_pelicula);
  $actores = actores_pelicula($id_pelicula);
  $detalles = detalles_pelicula($id_pelicula);
  echo "<div class='ui item'>
          <div class='ui tiny image' style='width:120px;'>
            <img src='static/img/" . $name . ".jpg'>
          </div>
          <div class='content'>
            <a class='header' style='color:rgba(255,255,255,.8)'>Dirigida por " . $directores . "</a>
            <div class='description' style='color:rgba(255,255,255,.8)'>
              <p>Reparto:</p>
              <ul>" . $actores . "</ul>
            </div>
            <div class='extra'>" . $detalles ."</div>
          </div>
        </div>";
}


function item_serie_descripcion($id_serie){
  $name_s = nombre_serie($id_serie);
  $directores = directores_pelicula($id_serie);
  $actores = actores_pelicula($id_serie);
  $detalles = detalles_capitulo($id_serie);
  echo "<div class='ui item'>
          <div class='ui tiny image' style='width:120px;'>
            <img src='static/img/" . $name_s . ".jpg'>
          </div>
          <div class='content'>
            <a class='header' style='color:rgba(255,255,255,.8)'>Dirigido por " . $directores . "</a>
            <div class='description' style='color:rgba(255,255,255,.8)'>
              <p>Reparto:</p>
              <ul>" . $actores . "</ul>
            </div>
            <div class='extra'>" . $detalles ."</div>
          </div>
        </div>";
}

function nombre_capitulo($id_capitulo){
  global $db;
  $query = "SELECT e.nombre
  FROM entretenimientos AS e, capitulos AS c
  WHERE e.id = :id_capitulo AND e.id = c.id_entretenimiento";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_capitulo', $id_capitulo);
  $result -> execute();
  $capitulo = $result -> fetch();
  return $capitulo[0];
}

function nombre_serie($id_capitulo){
  global $db;
  $query = "SELECT s.nombre
  FROM capitulos AS c, series AS s, pertenece AS p
  WHERE c.id_entretenimiento = :id_capitulo
  AND c.id_entretenimiento = p.id_capitulo
  AND p.id_serie = s.id";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_capitulo', $id_capitulo);
  $result -> execute();
  $serie = $result -> fetch();
  return $serie[0];
}

function plain_nombre_pelicula($id_pelicula){
  global $db;
  $query = "SELECT e.nombre
  FROM entretenimientos AS e, peliculas AS p
  WHERE e.id = :id_pelicula AND e.id = p.id_entretenimiento";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_pelicula', $id_pelicula);
  $result -> execute();
  $pelicula = $result -> fetch();
  echo "$pelicula[0]";
}

function detalles_pelicula($id_pelicula){
  global $db;
  $query = "SELECT e.duracion, e.fecha, p.oscares, e.id
  FROM entretenimientos AS e, peliculas AS p
  WHERE e.id = :id_pelicula AND e.id = p.id_entretenimiento";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_pelicula', $id_pelicula);
  $result -> execute();
  $pelicula = $result -> fetch();
  return "<div class='ui label'><i class='clock icon'></i>Duracion: $pelicula[0] mins</div>
        <div class='ui label'><i class='calendar icon'></i>Lanzamiento: $pelicula[1]</div>
        <div class='ui label'><i class='trophy icon'></i>$pelicula[2] Oscars</div>";
}

function detalles_capitulo($id_capitulo){
  global $db;
  $query = "SELECT e.duracion, e.fecha, c.temporada
  FROM entretenimientos AS e, capitulos AS c
  WHERE e.id = :id_capitulo AND e.id = c.id_entretenimiento";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_capitulo', $id_capitulo);
  $result -> execute();
  $capitulo = $result -> fetch();
  return "<div class='ui label'><i class='clock icon'></i>Duracion: $capitulo[0] mins</div>
        <div class='ui label'><i class='calendar icon'></i>Lanzamiento: $capitulo[1]</div>
        <div class='ui label'><i class='list icon'></i>$capitulo[2] temporada</div>";
}


function comentarios_pelicula($id_pelicula){
  global $db;
  $query = "SELECT * FROM comenta where id_entretenimiento = :id_pelicula";
  $result = $db -> prepare($query);
  $result -> bindParam(':id_pelicula', $id_pelicula);
  $result -> execute();
  $comentarios = $result -> fetchAll();
  if (!empty($comentarios)){
    foreach ($comentarios as $comentario) {
      echo "
        <div class='comment'>
          <a class='avatar'>
            <img src='https://cdn4.iconfinder.com/data/icons/gray-user-management/512/rounded-512.png'>
          </a>
          <div class='content'>
            <a class='author'>$comentario[1]</a>
            <div class='metadata'>
              <span class='date'>$comentario[5]</span>
              <div class='rating'>
                <i class='star icon'></i>
                $comentario[4]
              </div>
            </div>
            <div class='text'>
              $comentario[3]
            </div>
          </div>
        </div>
      ";
    }
  }
  else {
    echo "<p><i>No hay comentarios aún</i></p>";
  }
}

?>