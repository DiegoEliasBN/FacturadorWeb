<?php
require_once "conexion.php";
class ModeloMefectivo{
	/*=============================================
	CREAR CATEGORIA
	=============================================*/
	static public function mdlIngresarMefectivo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(CodApertura, descripcionMovimiento, valorMovimiento, CodAlmacen) VALUES (:CodApertura, :descripcionMovimiento, :valorMovimiento, :CodAlmacen)");
		$stmt->bindParam(":CodApertura", $datos["CodApertura"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcionMovimiento", $datos["descripcionMovimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":valorMovimiento", $datos["ValorMovimiento"], PDO::PARAM_STR);
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
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function mdlMostrarMefectivo($tabla, $item,$item2, $valor,$valor2){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * 
				FROM $tabla u
				INNER JOIN almacen al ON u.CodAlmacen = al.CodAlmacen
				 and u.$item=:$item and u.$item2=:$item2 ");
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$fecha=date('Y-m-d');
			$stmt = Conexion::conectar()->prepare("SELECT *
				FROM $tabla u
				INNER JOIN almacen al ON u.CodAlmacen = al.CodAlmacen
				and u.$item2=:$item2 and fechaMovimiento  like '%$fecha%' ORDER by u.CodMovimiento DESC");
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
	static public function mdlEditarMefectivo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET CodApertura = :CodApertura,descripcionMovimiento=:descripcionMovimiento, valorMovimiento = :valorMovimiento,CodAlmacen=:CodAlmacen  WHERE CodMovimiento = :id");
		$stmt->bindParam(":CodApertura", $datos["CodApertura"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcionMovimiento", $datos["descripcionMovimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":valorMovimiento", $datos["ValorMovimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt -> bindParam(":id", $datos["CodMovimiento"], PDO::PARAM_INT);
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
	static public function mdlBorrarMefectivo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE CodMovimiento = :id");
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
