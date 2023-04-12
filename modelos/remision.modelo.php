<?php
require_once "conexion.php";
class ModeloRemisiones{
	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function mdlMostrarRemisiones($tabla,$item,$item1,$valor,$valor1){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN clientes c ON u.id_cliente = c.id
				INNER JOIN almacen a ON u.id_local = a.CodAlmacen
				INNER JOIN trasporte t ON u.id_trasporte = t.id and u.$item1=:$item1 and u.$item=:$item  ORDER BY id DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla u
				INNER JOIN clientes c ON u.id_cliente = c.id
				INNER JOIN almacen a ON u.id_local = a.CodAlmacen
				INNER JOIN trasporte t ON u.id_trasporte = t.id and u.$item1=:$item1 ORDER BY u.id DESC");
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
	}
	static public function mdlSecuenciaRemisiones($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER by id DESC limit 1");
		$stmt -> execute();
		return $stmt -> fetch();
	}
	/*=============================================
	INGRESAR EL CABECERA DE LA GUIA DE REMISION
	=============================================*/
	static public function mdlIngresarRemision($tabla, $datos){
		$dbh=Conexion::conectar();
		$stmt = $dbh->prepare("INSERT INTO $tabla(id_local,id_trasporte, id_cliente, fecha_inicio, fecha_fin, secuencia,direccion_inicio,direccion_destino, motivo_traslado) VALUES (:id_local,:id_trasporte, :id_cliente, :fecha_inicio, :fecha_fin, :secuencia,:direccion_inicio,:direccion_destino, :motivo_traslado)");
		$stmt->bindParam(":id_local", $datos["id_local"], PDO::PARAM_INT);
		$stmt->bindParam(":id_trasporte", $datos["id_trasporte"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
		$stmt->bindParam(":secuencia", $datos["secuencia"], PDO::PARAM_INT);
		$stmt->bindParam(":direccion_inicio", $datos["direccion_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion_destino", $datos["direccion_destino"], PDO::PARAM_STR);
		$stmt->bindParam(":motivo_traslado", $datos["motivo_traslado"], PDO::PARAM_STR);
		if($stmt->execute()){
			$id_guia_remision = $dbh->lastInsertId();
			$datos=array("respuesta"=>"ok",
						 "id_guia_remision"=>$id_guia_remision);
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
	static public function mdlIngresarDetalleRemision($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_guia_remision,	id_producto,cantidad) VALUES (:id_guia_remision,:id_producto,:cantidad)");
		$stmt->bindParam(":id_guia_remision", $datos["id_guia_remision"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
}