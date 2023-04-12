<?php
require_once "conexion.php";
class ModeloTraspasos{
	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function mdlMostrarTraspasos($tabla, $item,$item1, $valor,$valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_usuario = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 and u.$item=:$item  ORDER BY CodTraspaso ASC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_usuario = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 ORDER BY CodTraspaso ASC");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarTraspasos1($tabla, $item,$item1, $valor,$valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_usuario = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 and u.$item=:$item  ORDER BY id ASC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_usuario = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 ORDER BY id DESC");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	REGISTRO DE VENTA
	=============================================*/
	static public function mdlIngresarTraspaso($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo,CodAlmacen, CodAlmacenEntrada,  productos,id_usuario) VALUES (:codigo, :CodAlmacen,:CodAlmacenEntrada, :productos, :id_usuario)");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":CodAlmacenEntrada", $datos["CodAlmacenEntrada"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	EDITAR VENTA
	=============================================*/
	static public function mdlEditarCompra($tabla, $datos){
		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET CodAlmacen=:CodAlmacen, id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago WHERE id =:codigo ");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	ELIMINAR VENTA
	=============================================*/
	static public function mdlEliminarTraspaso($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE CodTraspaso = :id");
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