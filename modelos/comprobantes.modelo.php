<?php
require_once "conexion.php";
class ModeloComprobantes{
    /*=============================================
    OBTENER LOS COMPROBANTES PENDIENTES DE AUTORIZACION
    =============================================*/
    public function getComprobantesPendientes($tabla, $estado){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v where v.procesado_sri=:estado order by id limit 200");
        $stmt -> bindParam(":estado", $estado, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchAll();
    }
    public function getNextID($contador){
        $stmt = Conexion::conectar()->prepare("SELECT getnextid(:contador)");
        $stmt -> bindParam(":contador", $contador, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchColumn(0);
    }
    public function updateComprobante($tabla, $field,$value, $key, $keyvalue){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $field = :valor WHERE $key = :keyvalue");
        $stmt -> bindParam(":valor", $value, PDO::PARAM_STR);
        $stmt -> bindParam(":keyvalue", $keyvalue, PDO::PARAM_INT);
        return $stmt -> execute();
    }
    public function getDetalleComprobante($tabla, $comprobante_id){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v where v.parent_id=:comprobante_id order by 1");
        $stmt -> bindParam(":comprobante_id", $comprobante_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchAll();
    }
}