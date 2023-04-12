<?php
require_once "conexion.php";
class ModeloTurnos{
	/*=============================================
	CREAR CATEGORIA
	=============================================*/
	static public function mdlIngresarTurno($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(CodAlmacen,descripcion, hora_inicio,	hora_fin) VALUES (:CodAlmacen,:descripcion,:hora_inicio,:hora_fin)");
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":hora_inicio", $datos["HoraInicio"], PDO::PARAM_STR);
		$stmt->bindParam(":hora_fin", $datos["HoraFin"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function mdlMostrarTurnos($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarTurnos2($tabla, $item,$item2, $valor,$valor2){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item2=:$item2 and $item=:$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item2=:$item2");
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	EDITAR CATEGORIA
	=============================================*/
	static public function mdlEditarTurno($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET descripcion=:descripcion,hora_inicio=:hora_inicio,	hora_fin=:hora_fin WHERE CodTurno = :id");
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":hora_inicio", $datos["HoraInicio"], PDO::PARAM_STR);
		$stmt->bindParam(":hora_fin", $datos["HoraFin"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["CodTurno"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	BORRAR CATEGORIA
	=============================================*/
	static public function mdlBorrarTurno($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE CodTurno = :id");
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
