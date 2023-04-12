<?php
require_once "conexion.php";
class ModeloUTurno{
	/*=============================================
	CREAR CLIENTE
	=============================================*/
	static public function mdlIngresarUTurno($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(CodAlmacen,CodUsuario, CodTurno) VALUES (:CodAlmacen,:CodUsuario, :CodTurno)");
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":CodUsuario", $datos["CodUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":CodTurno", $datos["CodTurno"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	MOSTRAR Turnoes
	=============================================*/
	static public function mdlMostrarUTurno($tabla, $item,$item2, $valor,$valor2){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT *
				FROM $tabla u
				INNER JOIN usuario us ON u.CodUsuario = us.CodUsuario
				INNER JOIN almacen al ON u.CodAlmacen = al.CodAlmacen
				INNER JOIN turno a ON u.CodTurno = a.CodTurno and u.$item=:$item and u.$item2=:$item2");
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT *
				FROM $tabla u
				INNER JOIN usuario us ON u.CodUsuario = us.CodUsuario
				INNER JOIN almacen al ON u.CodAlmacen = al.CodAlmacen
				INNER JOIN turno a ON u.CodTurno = a.CodTurno and u.$item2=:$item2 ");
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarUTurnos($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT *
				FROM $tabla u
				INNER JOIN usuario us ON u.CodUsuario = us.CodUsuario
				INNER JOIN turno a ON u.CodTurno = a.CodTurno and u.$item=:$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT *
				FROM $tabla u
				INNER JOIN usuario us ON u.CodUsuario = us.CodUsuario
				INNER JOIN turno a ON u.CodTurno = a.CodTurno");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function mdlEditarUTurno($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET CodUsuario = :CodUsuario ,CodTurno = :CodTurno WHERE id = :id");
		$stmt->bindParam(":CodUsuario", $datos["CodUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":CodTurno", $datos["CodTurno"], PDO::PARAM_INT);
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
	static public function mdlEliminarUTurno($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
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