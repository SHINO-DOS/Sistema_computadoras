<?php

/**
 * CRUD modal en PHP y MySQL
 * 
 * Este archivo consulta los datos del registro y los retorna en formato JSON 
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 * 
 */

require 'config/database.php';

$id = $conn->real_escape_string($_POST['id']);

$sql = "SELECT id, nombre, descripcion, id_tipo, precio FROM accesorio WHERE id=$id LIMIT 1";
$resultado = $conn->query($sql);
$rows = $resultado->num_rows;

$accesorio = [];

if ($rows > 0) {
    $accesorio = $resultado->fetch_array();
}

echo json_encode($accesorio, JSON_UNESCAPED_UNICODE);
