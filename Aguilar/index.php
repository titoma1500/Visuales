<?php
session_start();
require_once "models/usuario.model.php";
require_once "models/comentario.model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['login'])) {
        $usuario = UsuarioModel::mdlBuscarUsuario("usuario", $_POST['nombre_usuario']);
        if ($usuario && $usuario['clave'] === $_POST['clave']) {
            $_SESSION['usuario'] = $usuario['nombre_usuario'];
            $_SESSION['rol'] = $usuario['rol'];
            if ($usuario['rol'] === 'admin') {
                header('Location: views/admin/dashboard.php');
            } else {
                header('Location: views/user/formulario.php');
            }
            exit();
        } else {
            $error = "Usuario o clave incorrecta.";
        }
    }

    if (isset($_POST['registro'])) {
        $datos = ["nombre_usuario" => $_POST['nombre_usuario'], "clave" => $_POST['clave']];
        $respuesta = UsuarioModel::mdlRegistrarUsuario("usuario", $datos);
        if ($respuesta === "ok") {
            $exito = "¡Usuario registrado! Ahora puedes iniciar sesión.";
        } else {
            $error = "Ese nombre de usuario ya existe.";
        }
    }
    
    if (isset($_POST['enviar_comentario'])) {
        $datos = ["comentario" => $_POST['comentario'], "usuario" => $_SESSION['usuario']];
        ComentarioModel::mdlGuardarComentario("comentario", $datos);
        header('Location: views/user/formulario.php');
        exit();
    }
}

$vista = $_GET['vista'] ?? 'login';
?>
<!DOCTYPE html>
<html>
<head><title>Sistema de Comentarios</title></head>
<body>
    <h1>Sistema de Comentarios</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($exito)) echo "<p style='color:green;'>$exito</p>"; ?>

    <?php if ($vista === 'login'): ?>
        <h2>Iniciar Sesión</h2>
        <form method="post">
            <input type="text" name="nombre_usuario" placeholder="Usuario" required><br>
            <input type="password" name="clave" placeholder="Clave" required><br>
            <input type="submit" name="login" value="Entrar">
        </form>
        <p>¿No tienes cuenta? <a href="index.php?vista=registro">Regístrate</a></p>
    <?php else: ?>
        <h2>Registro de Usuario</h2>
        <form method="post">
            <input type="text" name="nombre_usuario" placeholder="Elige tu nombre de usuario" required><br>
            <input type="password" name="clave" placeholder="Elige tu clave" required><br>
            <input type="submit" name="registro" value="Registrarse">
        </form>
        <p>¿Ya tienes cuenta? <a href="index.php?vista=login">Inicia Sesión</a></p>
    <?php endif; ?>
</body>
</html>