<?php
require_once "conexion.php";
class ModeloAlmacenes{
	/*=============================================
	CREAR CATEGORIA
	=============================================*/
	static public function mdlIngresarAlmacen($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(NombreAlmacen,DireccionAlmacen,	telefono,email,ruc) VALUES (:NombreAlmacen,:DireccionAlmacen,:telefono,:email,:ruc)");
		$stmt->bindParam(":NombreAlmacen", $datos["NombreAlmacen"], PDO::PARAM_STR);
		$stmt->bindParam(":DireccionAlmacen", $datos["DireccionAlmacen"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":ruc", $datos["ruc"], PDO::PARAM_STR);
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
	static public function mdlMostrarAlmacenes($tabla, $item, $valor){
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
	//mostrar todos menos el indicado
	static public function mdlMostrarAlmacenes1($tabla, $item,$item1,$valor,$valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1<>:$item1");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	EDITAR CATEGORIA
	=============================================*/
	static public function mdlEditarAlmacen($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET NombreAlmacen=:NombreAlmacen,DireccionAlmacen=:DireccionAlmacen,	telefono=:telefono,email=:email,ruc=:ruc WHERE CodAlmacen = :id");
		$stmt->bindParam(":NombreAlmacen", $datos["NombreAlmacen"], PDO::PARAM_STR);
		$stmt->bindParam(":DireccionAlmacen", $datos["DireccionAlmacen"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":ruc", $datos["ruc"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
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
	static public function mdlBorrarAlmacen($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE CodAlmacen = :id");
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
