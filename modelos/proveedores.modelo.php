<?php
require_once "conexion.php";
class ModeloProveedores{
	/*=============================================
	CREAR CLIENTE
	=============================================*/
	static public function mdlIngresarProveedor($tabla, $datos){
		var_dump($datos);
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(CodAlmacen,razon_social, telefono, email, identificacion_proveedor, direccion_proveedor) VALUES (:CodAlmacen, :razon_social, :telefono, :email, :identificacion_proveedor, :direccion_proveedor)");
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":razon_social", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":identificacion_proveedor", $datos["ruc"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_proveedor", $datos["direccion"], PDO::PARAM_STR);
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
	static public function mdlMostrarProveedores($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarProveedoresAlmacen($tabla, $item, $item1, $valor, $valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1 = :$item1");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1");
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
	static public function mdlEditarProveedor($tabla, $datos){
		var_dump($datos);
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET razon_social = :nombre, telefono = :telefono, email = :email, identificacion_proveedor = :ruc, direccion_proveedor = :direccion WHERE id = :id");
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":ruc", $datos["ruc"], PDO::PARAM_INT);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
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
	static public function mdlEliminarProveedor($tabla, $datos){
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