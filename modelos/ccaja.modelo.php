<?php
require_once "conexion.php";
class ModeloCCaja{
	static public function mdlCrearCierreCaja($tabla, $datos){
		$variableid=Conexion::conectar();
		$stmt = $variableid->prepare("INSERT INTO $tabla(CodAlmacen,CodApertura, valorcierre,totalFacturaFiada,totalMovimientos,totalFacturaPagadas,totalFacturaTc,totalFacturaTd,totalConsolidado) VALUES (:CodAlmacen,:CodApertura, :valorcierre,:totalFacturaFiada, :totalMovimientos,:totalFacturaPagadas,:totalFacturaTc,:totalFacturaTd,:totalConsolidado)");
		$stmt->bindParam(":CodAlmacen", $datos["CodAlmacen"], PDO::PARAM_INT);
		$stmt->bindParam(":CodApertura", $datos["CodApertura"], PDO::PARAM_INT);
		$stmt->bindParam(":valorcierre", $datos["valorcierre"], PDO::PARAM_STR);
		$stmt->bindParam(":totalFacturaFiada", $datos["totalFacturaFiada"], PDO::PARAM_STR);
		$stmt->bindParam(":totalMovimientos", $datos["totalMovimientos"], PDO::PARAM_STR);
		$stmt->bindParam(":totalFacturaPagadas", $datos["totalFacturaPagadas"], PDO::PARAM_STR);
		$stmt->bindParam(":totalFacturaTc", $datos["totalFacturaTc"], PDO::PARAM_STR);
		$stmt->bindParam(":totalFacturaTd", $datos["totalFacturaTd"], PDO::PARAM_STR);
		$stmt->bindParam(":totalConsolidado", $datos["totalConsolidado"], PDO::PARAM_STR);
		$stmt->execute();
		$id=$variableid->lastInsertId();
		return $id;
		$stmt->close();
		$stmt = null;
	}
	static public function mdlCrearCierreCajaDetalle($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(CodCierre, tipodocumento,descripcion_cliente, valorcadauno,CodDocumento) VALUES (:CodCierre,:tipodocumento, :descripcion_cliente,:valorcadauno, :CodDocumento)");
		$stmt->bindParam(":CodCierre", $datos["CodCierre"], PDO::PARAM_INT);
		$stmt->bindParam(":tipodocumento", $datos["tipodocumento"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion_cliente", $datos["descripcion_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":valorcadauno", $datos["valorcadauno"], PDO::PARAM_STR);
		$stmt->bindParam(":CodDocumento", $datos["CodDocumento"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	static public function mdlMostrarCCajaAbierta($tabla, $item,$item2, $valor,$valor2){
			$stmt = Conexion::conectar()->prepare("SELECT *
				FROM $tabla u
				INNER JOIN almacen al ON u.CodAlmacen = al.CodAlmacen
				INNER JOIN usuarioturno a ON u.CodUTurno = a.id
				INNER JOIN turno t ON a.CodTurno = t.CodTurno
				INNER JOIN usuario us ON a.CodUsuario = us.CodUsuario and u.$item2=:$item2 and u.estado_apertura=1");
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarCCaja($tabla, $item,$item2, $valor,$valor2){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * 
				FROM $tabla u
				INNER JOIN almacen al ON u.CodAlmacen = al.CodAlmacen
				 and u.$item=:$item and u.$item2=:$item2");
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT *
				FROM $tabla u
				INNER JOIN almacen al ON u.CodAlmacen = al.CodAlmacen
				and u.$item2=:$item2 ORDER by u.CodCierre DESC");
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarCCajaDetalle($tabla, $item,$item2, $valor,$valor2){
		$stmt = Conexion::conectar()->prepare("SELECT *
				FROM $tabla where $item2=:$item2 ");
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
}