<?php

/**
 * CRUD modal en PHP y MySQL
 * 
 * Este archivo muestra el listado de registros y las opciones para agregar,
 * editar y eliminar registros desde ventanas modal de Bootstrap
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 * 
 */

session_start();

require 'config/database.php';

$sqlAccesorios = "SELECT a.id, a.nombre, a.descripcion, a.precio,t.nombre  AS tipo FROM accesorio AS a
INNER JOIN tipo AS t ON a.id_tipo=t.id";
$accesorios = $conn->query($sqlAccesorios);

$dir = "posters/";

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Modal</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <div class="container py-3">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">Inicio</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"> Notebooks<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Computadoras:
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#"></a>
                            <a class="dropdown-item" href="#">Accesorios</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Contacto: </a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>

        <hr>

        <?php if (isset($_SESSION['msg']) && isset($_SESSION['color'])) { ?>
            <div class="alert alert-<?= $_SESSION['color']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['msg']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <?php
            unset($_SESSION['color']);
            unset($_SESSION['msg']);
        } ?>

        <div class="row justify-content-end">
            <div class="col-auto">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal"><i
                        class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
            </div>
        </div>

        <table class="table table-sm table-striped table-hover mt-4">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th width="40%">Descripción</th>
                    <th>Tipo</th>
                    <th>precio</th>
                    <th>Poster</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $accesorios->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['nombre']; ?></td>
                        <td><?= $row['descripcion']; ?></td>
                        <td><?= $row['tipo']; ?></td>
                        <td><?= $row['precio']; ?></td>
                        <td><img src="<?= $dir . $row['id'] . '.jpg?n=' . time(); ?>" width="100"></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal"
                                data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>

                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal"
                                data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-trash"></i></i> Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <p class="text-center">Desarrollado por Estudiantes de informatica <a
                    href="https://github.com/mroblesdev">MRoblesDev</a></p>
        </div>
    </footer>

    <?php
    $sqlTipo = "SELECT id, nombre FROM tipo";
    $tipos = $conn->query($sqlTipo);
    ?>

    <?php include 'nuevoModal.php'; ?>

    <?php $tipos->data_seek(0); ?>

    <?php include 'editaModal.php'; ?>
    <?php include 'eliminaModal.php'; ?>

    <script>
        let nuevoModal = document.getElementById('nuevoModal')
        let editaModal = document.getElementById('editaModal')
        let eliminaModal = document.getElementById('eliminaModal')

        nuevoModal.addEventListener('shown.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #nombre').focus()
        })

        nuevoModal.addEventListener('hide.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #nombre').value = ""
            nuevoModal.querySelector('.modal-body #descripcion').value = ""
            nuevoModal.querySelector('.modal-body #tipo').value = ""
            nuevoModal.querySelector('.modal-body #precio').value = ""
            nuevoModal.querySelector('.modal-body #poster').value = ""
        })

        editaModal.addEventListener('hide.bs.modal', event => {
            editaModal.querySelector('.modal-body #nombre').value = ""
            editaModal.querySelector('.modal-body #descripcion').value = ""
            editaModal.querySelector('.modal-body #tipo').value = ""
            editaModal.querySelector('.modal-body #precio').value = ""
            editaModal.querySelector('.modal-body #img_poster').value = ""
            editaModal.querySelector('.modal-body #poster').value = ""
        })

        editaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')

            let inputId = editaModal.querySelector('.modal-body #id')
            let inputNombre = editaModal.querySelector('.modal-body #nombre')
            let inputDescripcion = editaModal.querySelector('.modal-body #descripcion')
            let inputTipo = editaModal.querySelector('.modal-body #tipo')
            let inputPrecio = editaModal.querySelector('.modal-body #precio')
            let poster = editaModal.querySelector('.modal-body #img_poster')

            let url = "getAccesorio.php"
            let formData = new FormData()
            formData.append('id', id)

            fetch(url, {
                method: "POST",
                body: formData
            }).then(response => response.json())
                .then(data => {

                    inputId.value = data.id
                    inputNombre.value = data.nombre
                    inputDescripcion.value = data.descripcion
                    inputGenero.value = data.id_tipo
                    inputGenero.value = data.precio
                    poster.src = '<?= $dir ?>' + data.id + '.jpg'

                }).catch(err => console.log(err))

        })

        eliminaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            eliminaModal.querySelector('.modal-footer #id').value = id
        })
    </script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>