<?php
require_once "conexion.php";
class ModeloLiquidaciones{
	/*=============================================
	MOSTRAR Liquidaciones
	=============================================*/
	static public function mdlMostrarLiquidaciones($tabla, $item,$item1, $valor,$valor1){
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
	static public function mdlMostrarDetalleLiquidacion($tabla, $item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item ORDER BY id ASC");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	static public function mdlMostrarLiquidacionElectronica($tabla, $item,$valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
			INNER JOIN usuario us ON u.id_vendedor = us.CodUsuario
			INNER JOIN almacen a ON u.CodAlmacen = a.CodAlmacen and u.$item=:$item and procesado_sri=1 ORDER BY u.id DESC");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	REGISTRO DE LA LIQUIDACION
	=============================================*/
	static public function mdlIngresarLiquidacion($tabla, $datos){
		$dbh=Conexion::conectar();
		$stmt = $dbh->prepare("INSERT INTO $tabla(CodAlmacen, id_cliente, id_vendedor, impuesto,iva_12,iva_0, neto, total, fecha,CodApertura) VALUES (:CodAlmacen,:id_cliente, :id_vendedor, :impuesto,:iva_12,:iva_0, :neto, :total,  :fecha,:CodApertura)");
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_12", $datos["iva_12"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_0", $datos["iva_0"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":CodApertura", $datos["CodUTurno"], PDO::PARAM_INT);
		if($stmt->execute()){
			$id_liquidacion = $dbh->lastInsertId();
			$datos=array("respuesta"=>"ok",
						 "id_liquidacion"=>$id_liquidacion);
			return $datos;
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	INGRESAR EL DETALLE DE LA GUIA DE LA LIQUIDACION
	=============================================*/
	static public function mdlIngresarDetalleLiquidacion($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_liquidacion,id_producto,descripcion_producto,cantidad,precio_compra,total,total_iva,total_con_iva,estado_iva) VALUES (:id_liquidacion,:id_producto,:descripcion_producto, :cantidad, :precio_compra,:total,:total_iva,:total_con_iva,:estado_iva)");
		$stmt->bindParam(":id_liquidacion", $datos["id_liquidacion"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion_producto", $datos["descripcion_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":total_iva", $datos["total_iva"], PDO::PARAM_STR);
		$stmt->bindParam(":total_con_iva", $datos["total_con_iva"], PDO::PARAM_STR);
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
	static public function mdlEditarLiquidacion($tabla, $datos){
		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cliente = :id_cliente , impuesto = :impuesto,iva_12 = :iva_12, iva_0= :iva_0 ,neto = :neto, total= :tota WHERE id =:codigo ");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_12", $datos["iva_12"], PDO::PARAM_STR);
		$stmt->bindParam(":iva_0", $datos["iva_0"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	static public function mdlActualizarLiquidacion($tabla, $item,$item1, $valor, $valor1){
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
	ELIMINAR LIQUIDACION
	=============================================*/
	static public function mdlEliminarLiquidacion($tabla, $datos){
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
	ELIMINAR DETALLE Liquidacion
	=============================================*/
	static public function mdlEliminarDetalleLiquidacion($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_liquidacion = :id");
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
	RANGO FECHAS
	=============================================*/	
	static public function mdlRangoFechasLiquidaciones($tabla, $fechaInicial, $fechaFinal,$item,$valor){
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