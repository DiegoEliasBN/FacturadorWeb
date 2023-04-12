<?php
require_once "conexion.php";
class ModeloUAlmacen{
	/*=============================================
	CREAR CLIENTE
	=============================================*/
	static public function mdlIngresarUAlmacen($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(CodUsuario, CodAlmacen) VALUES (:CodUsuario, :CodAlmacen)");
		$stmt->bindParam(":CodUsuario", $datos["CodUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	MOSTRAR Almacenes
	=============================================*/
	static public function mdlMostrarUAlmacen($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT u.CodUsuarioAlmacen ,us.nombre,us.usuario,us.CodUsuario,a.CodAlmacen,a.NombreAlmacen
				FROM $tabla u
				INNER JOIN usuario us ON u.CodUsuario = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item=:$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT u.CodUsuarioAlmacen ,us.nombre,us.usuario,a.NombreAlmacen
				FROM $tabla u
				INNER JOIN usuario us ON u.CodUsuario = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarUAlmacenes($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT u.CodUsuarioAlmacen ,us.nombre,us.usuario,us.CodUsuario,a.CodAlmacen,a.*
				FROM $tabla u
				INNER JOIN usuario us ON u.CodUsuario = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item=:$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT u.CodUsuarioAlmacen ,us.nombre,us.usuario,a.NombreAlmacen
				FROM $tabla u
				INNER JOIN usuario us ON u.CodUsuario = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function mdlEditarUAlmacen($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET CodUsuario = :CodUsuario ,CodAlmacen = :CodAlmacen WHERE CodUsuarioAlmacen = :id");
		$stmt->bindParam(":CodUsuario", $datos["CodUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	static public function mdlEliminarUAlmacen($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE CodUsuarioAlmacen = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
}