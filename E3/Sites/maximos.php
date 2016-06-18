<?php

try{
  $db = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}

function director_maximo(){
  global $db;
  $query = "SELECT
              nombre, c
          FROM
              Directores AS d,
              (SELECT id_director, COUNT(*) as c
               FROM dirige
               GROUP BY id_director
               HAVING COUNT(*) >= ALL (SELECT COUNT(*)
                                       FROM dirige
                                       GROUP BY id_director)) AS dc
          WHERE d.id = dc.id_director;";
  $result = $db -> prepare($query);
  $result -> execute();
  $directores = $result -> fetchAll();
  echo "<table class='ui orange celled table'><thead><tr><th>Nombre</th><th>Cantidad</th></tr></thead><tbody>";
  foreach ($directores as $director) {
    echo "<tr><td>$director[0]</td><td>$director[1]</td></tr>";
  }
  echo "</tbody></table>";
}

function pelicula_maxima(){
  global $db;
  $prev1 = "DROP VIEW VistosPeliculas;";
  $prev2 = "CREATE VIEW VistosPeliculas AS
                SELECT v.id_entretenimiento, COUNT(*) as c
                FROM Vistos as v, Peliculas as p
                WHERE v.id_entretenimiento = p.id_entretenimiento AND
                      fecha >= '2016-01-01' AND fecha < '2017-01-01'
                GROUP BY v.id_entretenimiento;";
  $db -> prepare($prev1) -> execute();
  $db -> prepare($prev2) -> execute();
  $query = "SELECT nombre, c
            FROM VistosPeliculas, Entretenimientos
            WHERE c = (SELECT MAX(c) FROM VistosPeliculas) AND id_entretenimiento = id;";
  $result = $db -> prepare($query);
  $result -> execute();
  $peliculas = $result -> fetchAll();
  echo "<table class='ui orange celled table'><thead><tr><th>Nombre</th><th>Cantidad</th></tr></thead><tbody>";
  foreach ($peliculas as $pelicula) {
    echo "<tr><td>$pelicula[0]</td><td>$pelicula[1]</td></tr>";
  }
  echo "</tbody></table>";
}
?>