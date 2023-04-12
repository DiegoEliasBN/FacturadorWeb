<?php
require_once "conexion.php";
class ModeloRetenciones{
	/*=============================================
	MOSTRAR RETENCIONES
	=============================================*/
    static public function mdlMostrarRetenciones($tabla,$item,$item1,$valor,$valor1){
			if($item != null){
				/*$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
					INNER JOIN proveedor p ON u.AcreedorID = p.id
					INNER JOIN tipo_compobante t ON u.TipoComprobanteID = t.ID
					INNER JOIN almacen a ON u.id_almacen = a.CodAlmacen and u.$item1=:$item1 and a.$item=:$item  ORDER BY u.id DESC");*/
					$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
					where u.$item1=:$item1 and u.$item=:$item ORDER BY id DESC");
				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
				$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
				$stmt -> execute();
				return $stmt -> fetch();
			}else{
/*
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
					INNER JOIN proveedor p ON u.AcreedorID = p.id
					INNER JOIN tipo_compobante t ON u.TipoComprobanteID = t.ID
					INNER JOIN almacen a ON u.id_almacen = a.CodAlmacen;
					 and u.$item1=:$item1 ORDER BY id DESC");
					 */
			    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
					where u.$item1=:$item1 ORDER BY id DESC");
				$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
				$stmt -> execute();
				return $stmt -> fetchAll();
			}
	}
	static public function mdlMostrarDetalleRetenciones($tabla,$item,$valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
			INNER JOIN sri_impuestos s ON u.id_impuesto = s.ID
			 and u.$item=:$item ORDER BY u.ID ASC");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	static public function mdlMostrarTipoComprobante($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	static public function mdlMostrarTipoComprobanteF($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
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
	static public function mdlMostrarTipoImpuesto($tabla,$item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado = 1 and $item=:$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	static public function mdlSecuenciaRetenciones($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER by id DESC limit 1");
		$stmt -> execute();
		return $stmt -> fetch();
	}
	/*=============================================
	INGRESAR EL CABECERA DE LA GUIA DE REMISION
	=============================================*/
	static public function mdlIngresarRetenciones($tabla, $datos){
		$dbh=Conexion::conectar();
		$stmt = $dbh->prepare("INSERT INTO $tabla(	id_almacen,Secuencia, AcreedorID, TipoComprobanteID, numeroComprobante, fechaEmisionComprobante) VALUES (:id_almacen,:Secuencia, :AcreedorID, :TipoComprobanteID, :numeroComprobante, :fechaEmisionComprobante)");
		$stmt->bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_INT);
		$stmt->bindParam(":Secuencia", $datos["secuencia"], PDO::PARAM_INT);
		$stmt->bindParam(":AcreedorID", $datos["acreedor"], PDO::PARAM_INT);
		$stmt->bindParam(":TipoComprobanteID", $datos["tipocomprobante"], PDO::PARAM_INT);
		$stmt->bindParam(":numeroComprobante", $datos["numerocomprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaEmisionComprobante", $datos["fechacomprobante"], PDO::PARAM_STR);
		if($stmt->execute()){
			$id_retencion = $dbh->lastInsertId();
			$datos=array("respuesta"=>"ok",
						 "id_retencion"=>$id_retencion);
			return $datos;
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	INGRESAR EL DETALLE DE LA GUIA DE REMISION
	=============================================*/
	static public function mdlIngresarDetalleRetencion($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_retencion,	id_impuesto,TasaRetencion,BaseImponible,Total) VALUES (:id_retencion,:id_impuesto,:TasaRetencion,:BaseImponible,:Total)");
		$stmt->bindParam(":id_retencion", $datos["id_retencion"], PDO::PARAM_INT);
		$stmt->bindParam(":id_impuesto", $datos["id_impuesto"], PDO::PARAM_INT);
		$stmt->bindParam(":TasaRetencion", $datos["tazaretencion"], PDO::PARAM_STR);
		$stmt->bindParam(":BaseImponible", $datos["baseimponible"], PDO::PARAM_STR);
		$stmt->bindParam(":Total", $datos["total"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	RANGO FECHAS
	=============================================*/	
	static public function mdlRangoFechasRetenciones($tabla, $fechaInicial, $fechaFinal,$item,$valor){
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
	static public function mdlMostrarRetencionesEmail($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT u.*, p.razon_social, p.email FROM $tabla u
			INNER JOIN proveedor p ON u.AcreedorID = p.id WHERE u.procesado_sri=1 and u.estado_email=0 and p.email != '' ORDER BY u.ID DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlActualizarRetencion($tabla, $item,$item1, $valor, $valor1){
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
}