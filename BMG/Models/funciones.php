
<?php
function GenerarArray($sql) {
  global $conexion;
  $result = $conexion->query($sql);
  $data = [];

  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }

  return $data;
}
?>