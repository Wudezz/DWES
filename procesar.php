<?php
session_start();

$host = "localhost";
$dbname = "eventos_deportivos";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

function listarEventos($conn, $filtro = '', $orden = 'nombre_evento', $direccion = 'ASC', $pagina = 1, $limite = 10) {
    $offset = ($pagina - 1) * $limite;
    $sql = "SELECT e.*, o.nombre AS organizador 
            FROM eventos e 
            JOIN organizadores o ON e.id_organizador = o.id";
    
    if ($filtro) {
        $sql .= " WHERE e.nombre_evento LIKE '%" . $conn->real_escape_string($filtro) . "%'";
    }

    $sql .= " ORDER BY $orden $direccion LIMIT $limite OFFSET $offset";

    return $conn->query($sql);
}

function contarEventos($conn, $filtro = '') {
    $sql = "SELECT COUNT(*) AS total FROM eventos e";
    if ($filtro) {
        $sql .= " WHERE e.nombre_evento LIKE '%" . $conn->real_escape_string($filtro) . "%'";
    }
    $resultado = $conn->query($sql);
    return $resultado->fetch_assoc()['total'];
}

function listarOrganizadores($conn) {
    $sql = "SELECT * FROM organizadores";
    return $conn->query($sql);
}

function obtenerEvento($conn, $id) {
    $sql = "SELECT * FROM eventos WHERE id = $id";
    $resultado = $conn->query($sql);
    return $resultado && $resultado->num_rows > 0 ? $resultado->fetch_assoc() : null;
}

function guardarEvento($conn) {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre_evento'] ?? '';
    $tipo = $_POST['tipo_deporte'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $ubicacion = $_POST['ubicacion'] ?? '';
    $organizador_id = $_POST['id_organizador'] ?? null;

    $errores = [];
    if (!$nombre) $errores[] = "El campo 'Nombre del Evento' es obligatorio.";
    if (!$tipo) $errores[] = "El campo 'Tipo de Deporte' es obligatorio.";
    if (!$fecha) $errores[] = "El campo 'Fecha' es obligatorio.";
    if (!$hora) $errores[] = "El campo 'Hora' es obligatorio.";
    if (!$ubicacion) $errores[] = "El campo 'Ubicación' es obligatorio.";
    if (!$organizador_id) $errores[] = "El campo 'Organizador' es obligatorio.";

    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        header("Location: formularioevento.php" . ($id ? "?id=$id" : ""));
        exit();
    }

    if ($id) {
        $sql = "UPDATE eventos SET nombre_evento = '$nombre', tipo_deporte = '$tipo', fecha = '$fecha', hora = '$hora', ubicacion = '$ubicacion', id_organizador = $organizador_id WHERE id = $id";
    } else {
        $sql = "INSERT INTO eventos (nombre_evento, tipo_deporte, fecha, hora, ubicacion, id_organizador) VALUES ('$nombre', '$tipo', '$fecha', '$hora', '$ubicacion', $organizador_id)";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        die("Error al guardar el evento: " . $conn->error);
    }
}

function guardarOrganizador($conn) {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    $errores = [];
    if (!$nombre) $errores[] = "El campo 'Nombre' es obligatorio.";
    if (!$email) $errores[] = "El campo 'Email' es obligatorio.";
    if (!$telefono) $errores[] = "El campo 'Teléfono' es obligatorio.";

    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        header("Location: formularioorganizador.php");
        exit();
    }

    $sql = "INSERT INTO organizadores (nombre, email, telefono) VALUES ('$nombre', '$email', '$telefono')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        die("Error al guardar el organizador: " . $conn->error);
    }
}

function eliminarEvento($conn) {
    $id = $_POST['id'];
    $sql = "DELETE FROM eventos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    }
    die("Error al eliminar el evento: " . $conn->error);
}

function eliminarOrganizador($conn) {
    $id = $_POST['id'];
    $sql = "SELECT COUNT(*) AS total FROM eventos WHERE id_organizador = $id";
    $resultado = $conn->query($sql);
    $row = $resultado->fetch_assoc();
    if ($row['total'] > 0) {
        echo "<script>
            alert('No se puede eliminar el organizador porque tiene eventos asociados.');
            window.location.href = 'index.php';
        </script>";
        exit();
    }

    $sql = "DELETE FROM organizadores WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    }
    die("Error al eliminar el organizador: " . $conn->error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['accion']) {
        case 'guardarEvento':
            guardarEvento($conn);
            break;
        case 'guardarOrganizador':
            guardarOrganizador($conn);
            break;
        case 'eliminarEvento':
            eliminarEvento($conn);
            break;
        case 'eliminarOrganizador':
            eliminarOrganizador($conn);
            break;
        default:
            break;
    }
}
?>
