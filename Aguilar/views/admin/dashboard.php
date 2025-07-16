<?php
session_start();
require_once "../../models/comentario.model.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

if (isset($_POST['eliminar_comentario'])) {
    ComentarioModel::mdlEliminarComentario("comentario", $_POST['id_comentario']);
    header('Location: dashboard.php');
    exit();
}

if (isset($_GET['buscar_usuario']) && !empty($_GET['buscar_usuario'])) {
    $listaComentarios = ComentarioModel::mdlFiltrarComentarios("comentario", $_GET['buscar_usuario']);
} else {
    $listaComentarios = ComentarioModel::mdlMostrarComentarios("comentario");
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard Admin</title></head>
<body>
    <h1>Panel de Administrador</h1>
    <p>Bienvenido, <?php echo $_SESSION['usuario']; ?>.</p>

    <form method="get">
        <input type="text" name="buscar_usuario" placeholder="Buscar por nombre de usuario">
        <input type="submit" value="Buscar">
        <a href="dashboard.php">Mostrar Todos</a>
    </form>
    <hr>

    <table border="1" style="width:100%; border-collapse: collapse;">
        <tr>
            <th>ID Comentario</th>
            <th>Comentario</th>
            <th>Enviado por (Usuario)</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($listaComentarios as $item): ?>
        <tr>
            <td><?php echo $item['id_comentario']; ?></td>
            <td><?php echo $item['comentario']; ?></td>
            <td><?php echo $item['id_usu_comen']; ?></td>
            <td>
                <form method="post" onsubmit="return confirm('¿Seguro que quieres eliminar?');">
                    <input type="hidden" name="id_comentario" value="<?php echo $item['id_comentario']; ?>">
                    <input type="submit" name="eliminar_comentario" value="Eliminar">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="../../logout.php">Cerrar Sesión</a>
</body>
</html>