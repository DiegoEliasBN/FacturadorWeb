<?php 
require_once "conexion.php";
class ModeloCobro{
	static public function mdlIngresarCobro($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(CodAlmacen,CodApertura, id_cliente, id_vendedor,CantidadPago,facturas) VALUES (:CodAlmacen,:CodApertura,:id_cliente,:id_vendedor,:CantidadPago,:facturas)");
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_STR);
		$stmt->bindParam(":CodApertura", $datos["CodApertura"], PDO::PARAM_STR);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_STR);
		$stmt->bindParam(":CantidadPago", $datos["CantidadPago"], PDO::PARAM_STR);
		$stmt->bindParam(":facturas", $datos["facturas"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	static public function mdlMostrarCobros($tabla, $item,$item1, $valor,$valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_vendedor = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 and u.$item=:$item  ORDER BY CodCobro DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_vendedor = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 ORDER BY CodCobro DESC");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
}