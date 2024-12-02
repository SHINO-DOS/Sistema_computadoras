<?php

/**
 * CRUD modal en PHP y MySQL
 * 
 * Este archivo guarda los datos el registro y la imagen
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 * 
 */

session_start();

require 'config/database.php';

$nombre = $conn->real_escape_string($_POST['nombre']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);
$tipo = $conn->real_escape_string($_POST['tipo']);
$precio = $conn->real_escape_string($_POST['precio']);

$sql = "INSERT INTO accesorio (nombre, descripcion, id_tipo, precio, fecha_alta)
VALUES ('$nombre', '$descripcion', $tipo, $precio, NOW())";

if ($conn->query($sql)) {
    $id = $conn->insert_id;

    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Registro guardado";

    if ($_FILES['poster']['error'] == UPLOAD_ERR_OK) {
        $permitidos = array("image/jpg", "image/jpeg");
        if (in_array($_FILES['poster']['type'], $permitidos)) {

            $dir = "posters";

            $info_img = pathinfo($_FILES['poster']['name']);
            $info_img['extension'];

            $poster = $dir . '/' . $id . '.jpg';

            if (!file_exists($dir)) {
                mkdir($dir, 0777);
            }

            if (!move_uploaded_file($_FILES['poster']['tmp_name'], $poster)) {
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] .= "<br>Error al guardar imagen";
            }
        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] .= "<br>Formato de imágen no permitido";
        }
    }
} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al guarda imágen";
}

header('Location: index.php');
