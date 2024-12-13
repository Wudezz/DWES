<?php
    include('procesar.php');

    $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';
    $orden = isset($_GET['orden']) ? $_GET['orden'] : 'nombre_evento';
    $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : 'ASC';
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

    $limite = 10;
    $eventos = listarEventos($conn, $filtro, $orden, $direccion, $pagina, $limite);
    $total_eventos = contarEventos($conn, $filtro);
    $total_paginas = ceil($total_eventos / $limite);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <a href="formularioevento.php" class="btn btn-success">Registrar Evento</a>
                <form class="d-flex" role="search" method="GET" action="index.php">
                    <input class="form-control me-2" type="search" name="filtro" placeholder="Buscar aquí..." value="<?php echo htmlspecialchars($filtro); ?>">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <a href="formularioorganizador.php" class="btn btn-success">Registrar Organizador</a>
            </div>
        </nav>
    </div>
    <div class="container text-center"><br>
        <h2>Eventos Deportivos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><a href="?filtro=<?php echo urlencode($filtro); ?>&orden=nombre_evento&direccion=<?php echo $direccion === 'ASC' ? 'DESC' : 'ASC'; ?>&pagina=<?php echo $pagina; ?>">Nombre del evento</a></th>
                    <th><a href="?filtro=<?php echo urlencode($filtro); ?>&orden=tipo_deporte&direccion=<?php echo $direccion === 'ASC' ? 'DESC' : 'ASC'; ?>&pagina=<?php echo $pagina; ?>">Tipo de deporte</a></th>
                    <th><a href="?filtro=<?php echo urlencode($filtro); ?>&orden=fecha&direccion=<?php echo $direccion === 'ASC' ? 'DESC' : 'ASC'; ?>&pagina=<?php echo $pagina; ?>">Fecha</a></th>
                    <th><a href="?filtro=<?php echo urlencode($filtro); ?>&orden=hora&direccion=<?php echo $direccion === 'ASC' ? 'DESC' : 'ASC'; ?>&pagina=<?php echo $pagina; ?>">Hora</a></th>
                    <th><a href="?filtro=<?php echo urlencode($filtro); ?>&orden=ubicacion&direccion=<?php echo $direccion === 'ASC' ? 'DESC' : 'ASC'; ?>&pagina=<?php echo $pagina; ?>">Ubicación</a></th>
                    <th><a href="?filtro=<?php echo urlencode($filtro); ?>&orden=organizador&direccion=<?php echo $direccion === 'ASC' ? 'DESC' : 'ASC'; ?>&pagina=<?php echo $pagina; ?>">Organizador</a></th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($evento = $eventos->fetch_assoc()) {
                        echo "<tr>
                            <td>{$evento['nombre_evento']}</td>
                            <td>{$evento['tipo_deporte']}</td>
                            <td>{$evento['fecha']}</td>
                            <td>{$evento['hora']}</td>
                            <td>{$evento['ubicacion']}</td>
                            <td>{$evento['organizador']}</td>
                            <td>
                                <a href='formularioEvento.php?id={$evento['id']}' class='btn btn-outline-info'>Editar</a>
                            </td>
                            <td>
                                <form action='procesar.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='accion' value='eliminarEvento'>
                                    <input type='hidden' name='id' value='{$evento['id']}'>
                                    <button type='submit' class='btn btn-outline-danger' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este evento?\");'>Eliminar</button>
                                </form>
                            </td>
                        </tr>";
                    }
                ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?php echo $i === $pagina ? 'active' : ''; ?>">
                        <a class="page-link" href="?filtro=<?php echo urlencode($filtro); ?>&orden=<?php echo $orden; ?>&direccion=<?php echo $direccion; ?>&pagina=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div><br><br>
    <div class="container text-center"><br><br>
        <h2>Organizadores</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $organizadores = listarOrganizadores($conn);
                    while ($organizador = $organizadores->fetch_assoc()) {
                        echo "<tr>
                            <td>{$organizador['nombre']}</td>
                            <td>{$organizador['email']}</td>
                            <td>{$organizador['telefono']}</td>
                            <td>
                                <form action='procesar.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='accion' value='eliminarOrganizador'>
                                    <input type='hidden' name='id' value='{$organizador['id']}'>
                                    <button type='submit' class='btn btn-outline-danger' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este organizador?\");'>Eliminar</button>
                                </form>
                            </td>
                        </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
