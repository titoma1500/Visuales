<?php
require_once "conexion.php";

class UsuarioModel {
    static public function mdlRegistrarUsuario($tabla, $datos) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_usuario, clave, rol) VALUES (:nombre_usuario, :clave, 'user')");
        $stmt->bindParam(":nombre_usuario", $datos["nombre_usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":clave", $datos["clave"], PDO::PARAM_STR);
        return $stmt->execute() ? "ok" : "error";
    }

    static public function mdlBuscarUsuario($tabla, $nombre_usuario) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE nombre_usuario = :nombre_usuario");
        $stmt->bindParam(":nombre_usuario", $nombre_usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
}