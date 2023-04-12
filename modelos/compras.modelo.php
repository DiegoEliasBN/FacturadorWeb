<?php
require_once "conexion.php";
class ModeloCompras{
	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function mdlMostrarCompras($tabla, $item,$item1, $valor,$valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_vendedor = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 and u.$item=:$item  ORDER BY id ASC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_vendedor = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 ORDER BY id ASC");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarCompras1($tabla, $item,$item1, $valor,$valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_vendedor = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 and u.$item=:$item  ORDER BY id ASC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_vendedor = us.CodUsuario
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
	static public function mdlIngresarCompra($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo,CodAlmacen, id_proveedor, id_vendedor, productos, impuesto, neto, total, metodo_pago) VALUES (:codigo, :CodAlmacen,:id_proveedor, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago)");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":id_proveedor", $datos["id_cliente"], PDO::PARAM_INT);
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
	static public function mdlEliminarCompra($tabla, $datos){
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