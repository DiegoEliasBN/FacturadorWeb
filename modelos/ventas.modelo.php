<?php
require_once "conexion.php";
class ModeloVentas{
	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function mdlMostrarVentasCierre($tabla, $item,$item1, $valor,$valor1){
			$stmt = Conexion::conectar()->prepare("SELECT u.*, us.nombre, us.documento FROM $tabla u
				INNER JOIN clientes us ON u.id_cliente = us.id and u.$item1=:$item1 and u.$item=:$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarVentas($tabla, $item,$item1, $valor,$valor1){
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
	static public function mdlMostrarDetalleVenta($tabla, $item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item ORDER BY id ASC");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	static public function mdlMostrarVentasFiadas($tabla, $item,$item1,$valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN usuario us ON u.id_vendedor = us.CodUsuario
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 and u.$item > 0  ORDER BY id ASC");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchall();
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
	static public function mdlMostrarFacturaElectronica($tabla, $item,$valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
			INNER JOIN usuario us ON u.id_vendedor = us.CodUsuario
			INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item=:$item and procesado_sri=1 ORDER BY u.id DESC");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarFacturasEmail($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT u.*, c.nombre, c.email FROM $tabla u
			INNER JOIN clientes c ON u.id_cliente = c.id WHERE u.procesado_sri=1 and u.estado_email=0 and u.id_cliente != 1 and c.email != '' ORDER BY u.id DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarVentas1($tabla, $item,$item1, $valor,$valor1){
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
				INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item1=:$item1 ORDER BY id ASC");
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
	static public function mdlIngresarVenta($tabla, $datos){
		$dbh=Conexion::conectar();
		$stmt = $dbh->prepare("INSERT INTO $tabla(codigo,CodAlmacen, id_cliente, id_vendedor, productos, impuesto,iva_12,iva_0, neto, total,total_compra,saldo, metodo_pago,codigo_df, fecha,tipo,CodApertura) VALUES (:codigo, :CodAlmacen,:id_cliente, :id_vendedor, :productos, :impuesto,:iva_12,:iva_0, :neto, :total,:total_compra,:saldo, :metodo_pago, :codigo_df,  :fecha, :tipo,:CodApertura)");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_12", $datos["iva_12"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_0", $datos["iva_0"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":total_compra", $datos["totalcompra"], PDO::PARAM_STR);
		$stmt->bindParam(":saldo", $datos["saldo"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo_df", $datos["codigo_df"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":CodApertura", $datos["CodUTurno"], PDO::PARAM_INT);
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
	/*=============================================
	INGRESAR EL DETALLE DE LA GUIA DE LA FACTURA
	=============================================*/
	static public function mdlIngresarDetalleFactura($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_factura,	id_producto,descripcion_producto,cantidad,precio_compra,precio_venta,total,precio_con_iva,total_iva,total_con_iva,total_precio_compra,estado_iva) VALUES (:id_factura,:id_producto,:descripcion_producto, :cantidad, :precio_compra, :precio_venta,:total,:precio_con_iva,:total_iva,:total_con_iva,:total_precio_compra,:estado_iva)");
		$stmt->bindParam(":id_factura", $datos["id_factura"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion_producto", $datos["descripcion_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_con_iva", $datos["precio_con_iva"], PDO::PARAM_STR);
		$stmt->bindParam(":total_iva", $datos["total_iva"], PDO::PARAM_STR);
		$stmt->bindParam(":total_con_iva", $datos["total_con_iva"], PDO::PARAM_STR);
		$stmt->bindParam(":total_precio_compra", $datos["total_precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":estado_iva", $datos["estado_iva"], PDO::PARAM_STR);
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
	static public function mdlEditarVenta($tabla, $datos){
		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cliente = :id_cliente, productos = :productos, impuesto = :impuesto,iva_12 = :iva_12, iva_0= :iva_0 ,neto = :neto, total= :total,total_compra= :total_compra,saldo= :saldo, metodo_pago = :metodo_pago, codigo_df=:codigo_df, tipo=:tipo WHERE id =:codigo ");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_12", $datos["iva_12"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_0", $datos["iva_0"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":total_compra", $datos["totalcompra"], PDO::PARAM_STR);
		$stmt->bindParam(":saldo", $datos["saldo"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo_df", $datos["codigo_df"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	static public function mdlActualizarVenta($tabla, $item,$item1, $valor, $valor1){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item = :$item");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	ELIMINAR VENTA
	=============================================*/
	static public function mdlEliminarVenta($tabla, $datos){
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
	ELIMINAR DETALLE VENTA
	=============================================*/
	static public function mdlEliminarDetalleVenta($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_factura = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlSumaTotalVentas($tabla,$item1,$valor1){	
		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla WHERE $item1=:$item1 ");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	RANGO FECHAS
	=============================================*/	
	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal,$item,$valor){
		if($fechaInicial == null){
			$fecha=date('Y-m-d');
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item and fecha  like '%$fecha%' ORDER BY id DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();	
		}else if($fechaInicial == $fechaFinal){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item and fecha like '%$fechaFinal%'");
			//$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");
			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");
			if($fechaFinalMasUno == $fechaActualMasUno){
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item and DATE(fecha) BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item and DATE(fecha) BETWEEN '$fechaInicial' AND '$fechaFinal'");
			}
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
	}
}