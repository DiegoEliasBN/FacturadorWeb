<?php
require_once "conexion.php";
class ModeloTransportes{
	/*=============================================
	CREAR CLIENTE
	=============================================*/
	static public function mdlIngresarTransporte($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(CodAlmacen,nombre_chofer, identificacion_chofer, placa_vehiculo) VALUES (:CodAlmacen, :nombre_chofer, :licencia, :placa)");
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_chofer", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":licencia", $datos["licencia"], PDO::PARAM_STR);
		$stmt->bindParam(":placa", $datos["placa"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function mdlMostrarTransportes($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where id <> 0");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarTransportesAlmacen($tabla, $item, $item1, $valor, $valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1 = :$item1");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where  $item1 = :$item1");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function mdlEditarTransporte($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_chofer = :nombre, identificacion_chofer = :licencia, placa_vehiculo = :placa WHERE id = :id");
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":licencia", $datos["licencia"], PDO::PARAM_STR);
		$stmt->bindParam(":placa", $datos["placa"], PDO::PARAM_STR);
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
	static public function mdlEliminarTransporte($tabla, $datos){
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
	/*=============================================
	ACTUALIZAR CLIENTE
	=============================================*/
}