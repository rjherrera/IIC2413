<?php
try{
  $db = new PDO("pgsql:dbname=grupo14;host=localhost;user=grupo14;password=grupo14");
}
catch(PDOException $e){
  echo $e -> getMessage();
}
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
echo "<table class='ui orange table'><thead><tr><th>Nombre</th><th>Cantidad</th></tr></thead><tbody>";
foreach ($directores as $director) {
  echo "<tr><td>$director[0]</td><td>$director[1]</td></tr>";
}
echo "</tbody></table>";
?>