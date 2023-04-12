<?php
require_once "conexion.php";
class ModeloProductos{
	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
	static public function mdlMostrarProductos($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarProductoss($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN productos us ON u.CodProducto = us.id
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item=:$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchall();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarProductosdinamico($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN productos us ON u.CodProducto = us.id
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item=:$item ORDER BY u.ventasa DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchall();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarStock($tabla,$item,$item1, $valor,$valor1){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN productos us ON u.CodProducto = us.id
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item=:$item and u.$item1=:$item1");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
			$stmt -> close();
			$stmt = null;
	}
	static public function mdlMostrarStock1($tabla,$item,$item1, $valor,$valor1){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN productos us ON u.CodProducto = us.id
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item=:$item and u.$item1=:$item1");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> close();
			$stmt = null;
	}
	static public function mdlMostrarStock12($tabla,$item,$item1, $valor,$valor1){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN productos us ON u.CodProducto = us.id
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and us.$item=:$item and u.$item1=:$item1");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
			$stmt -> close();
			$stmt = null;
	}
	static public function mdlMostrarStockAutocompletar($tabla,$item,$item1, $valor,$valor1){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN productos us ON u.CodProducto = us.id
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and us.$item LIKE '%$valor%' and u.$item1=:$item1 LIMIT 5");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			$datos = array();
			$datos2 =array();
			foreach ($row=$stmt->fetchall() as $key => $value) {
				$datos = array( 'value' => $row[$key]['descripcion']."------Precio-- ".number_format($row[$key]['precio_venta'],2),
								'nombre' => $row[$key]['descripcion']);
				array_push($datos2, $datos);
			}
			return $datos2;
			$stmt -> close();
			$stmt = null;
	}
	static public function mdlMostrarProductoLiquidacion($tabla,$item, $valor){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item LIKE '%$valor%' LIMIT 5");
			$stmt -> execute();
			$datos = array();
			$datos2 =array();
			foreach ($row=$stmt->fetchall() as $key => $value) {
				$datos = array( 'value' => $row[$key]['descripcion']."------Precio-- ".number_format($row[$key]['precio_compra'],2),
								'nombre' => $row[$key]['descripcion']);
				array_push($datos2, $datos);
			}
			return $datos2;
			$stmt -> close();
			$stmt = null;
	}
	static public function mdlMostrarStock2($tabla,$item,$item1, $valor,$valor1){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN productos us ON u.CodProducto = us.id
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and us.$item=:$item and u.$item1=:$item1");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
			$stmt -> close();
			$stmt = null;
	}
	static public function mdlMostrarDescuento($tabla){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
	}
	/*=============================================
	REGISTRO DE PRODUCTO
	=============================================*/
	static public function mdlIngresarProducto($tabla, $datos){
		$dbh=Conexion::conectar();
		$stmt =  $dbh->prepare("INSERT INTO $tabla(id_categoria, codigo, descripcion, imagen, precio_compra, precio_siniva, precio_venta,ventas,iva_producto) VALUES (:id_categoria, :codigo, :descripcion, :imagen, :precio_compra, :precio_siniva, :precio_venta,0,:iva_producto)");
		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_siniva", $datos["preciosiniva"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_producto", $datos["iva_producto"], PDO::PARAM_STR);
		if($stmt->execute()){
			$id_factura = $dbh->lastInsertId();
			$datos=array("respuesta"=>"ok",
						 "id_factura"=>$id_factura);
			return $datos;
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	static public function mdlIngresarStockProducto($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(CodAlmacen, CodProducto, CantidadIngreso, CantidadEgreso, ventasa) VALUES (:CodAlmacen, :CodProducto, :CantidadIngreso,0,0)");
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":CodProducto", $datos["CodProducto"], PDO::PARAM_INT);
		$stmt->bindParam(":CantidadIngreso", $datos["CantidadIngreso"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function mdlEditarProducto($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria, codigo=:codigo, descripcion = :descripcion, imagen = :imagen, precio_compra = :precio_compra, precio_siniva=:precio_siniva, precio_venta = :precio_venta ,iva_producto=:iva_producto WHERE id = :id");
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_siniva", $datos["precio_siniva"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_producto", $datos["iva_producto"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	BORRAR PRODUCTO
	=============================================*/
	static public function mdlEliminarProducto($tabla, $datos){
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
	ACTUALIZAR PRODUCTO
	=============================================*/
	static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlActualizarStock($almacen,$tabla, $item1, $valor1, $valor){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE CodProducto = :id and CodAlmacen=:CodAlmacen");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":CodAlmacen", $almacen, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlSumaTotalVentasa($tabla,$item1,$valor1){	
		$stmt = Conexion::conectar()->prepare("SELECT SUM(ventasa) as ventasa FROM $tabla WHERE $item1=:$item1 ");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt = null;
	}
}