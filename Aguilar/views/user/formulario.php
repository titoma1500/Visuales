<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Formulario de Usuario</title></head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?></h1>
    <p>Envía tu respuesta:</p>
    <form action="../../index.php" method="post">
        <textarea name="comentario" required></textarea><br>
        <input type="submit" name="enviar_comentario" value="Enviar">
    </form>
    <a href="../../logout.php">Cerrar Sesión</a>
</body>
</html>