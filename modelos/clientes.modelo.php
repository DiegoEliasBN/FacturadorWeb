<?php
require_once "conexion.php";
class ModeloClientes{
	/*=============================================
	CREAR CLIENTE
	=============================================*/
	static public function mdlIngresarCliente($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, documento, email, telefono, direccion, fecha_nacimiento, compras,tipo_documento) VALUES (:nombre, :documento, :email, :telefono, :direccion, :fecha_nacimiento,0,:tipo_documento)");
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	static public function mdlIngresarClienteAjax($tabla, $datos){
		$dbh=Conexion::conectar();
		$stmt = $dbh->prepare("INSERT INTO $tabla(nombre, documento, direccion, email, compras, tipo_documento) VALUES (:nombre, :documento, :direccion,:email,0,:tipo_documento )");
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
		if($stmt->execute()){
			$id_cliente = $dbh->lastInsertId();
			$datos=array("respuesta"=>"ok",
						 "id_cliente"=>$id_cliente);
			return $datos;
		}else{
			$datos=array("respuesta"=>"error");
			return $datos;
		}
		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function mdlMostrarClientes($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where id <> 1");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarStockAutocompletarCliente($tabla,$item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item LIKE '%$valor%' LIMIT 5");
		$stmt -> execute();
		$datos = array();
		$datos2 =array();
		foreach ($row=$stmt->fetchall() as $key => $value) {
			$datos = array('id' =>$row[$key]['id'] , 
							'value' => $row[$key]['nombre'],
							'documento' => $row[$key]['documento'],
							'email' => $row[$key]['email'],
							'telefono' => $row[$key]['telefono'],
							'tipo_documento' => $row[$key]['tipo_documento'],
							'direccion' => $row[$key]['direccion']);
			array_push($datos2, $datos);
		}
		return $datos2;
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarClientes2($tabla, $item, $valor){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlMostrarClientes3($tabla, $item, $valor){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id desc");
			$stmt -> execute();
			return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function mdlEditarCliente($tabla, $datos){
        if($datos["id"] > 1){
    		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, documento = :documento, email = :email, telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento, tipo_documento = :tipo_documento WHERE id = :id");
    		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
    		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
    		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
    		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
    		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
    		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
    		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
    		$stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
    		if($stmt->execute()){
    			return "ok";
    		}else{
    			return "error";
    		}
    		$stmt->close();
    		$stmt = null;
        }
        else{
            return "error";
        }
	}
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	static public function mdlEliminarCliente($tabla, $datos){
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
	ACTUALIZAR CLIENTE
	=============================================*/
	static public function mdlActualizarCliente($tabla, $item1, $valor1, $valor){
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
}