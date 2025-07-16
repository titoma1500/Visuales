<?php
require_once "conexion.php";

class ComentarioModel {
    static public function mdlGuardarComentario($tabla, $datos) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (comentario, id_usu_comen) VALUES (:comentario, :id_usu_comen)");
        $stmt->bindParam(":comentario", $datos["comentario"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usu_comen", $datos["usuario"], PDO::PARAM_STR);
        return $stmt->execute() ? "ok" : "error";
    }

    static public function mdlMostrarComentarios($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function mdlFiltrarComentarios($tabla, $usuario) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usu_comen = :usuario");
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function mdlEliminarComentario($tabla, $id_comentario) {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_comentario = :id_comentario");
        $stmt->bindParam(":id_comentario", $id_comentario, PDO::PARAM_INT);
        return $stmt->execute() ? "ok" : "error";
    }
}