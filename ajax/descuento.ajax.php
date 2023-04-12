<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
class AjaxProductosDescuento{
  /*=============================================
  GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
  =============================================*/
  public function ajaxCrearCodigoProducto(){
    $respuesta = ControladorProductos::ctrMostrarDescuento();
    echo json_encode($respuesta);
  }
  /*=============================================
  EDITAR PRODUCTO
  =============================================*/ 
}
/*=============================================
TRAER PRODUCTO
=============================================*/ 
$traerProductos = new AjaxProductosDescuento();
$traerProductos -> ajaxCrearCodigoProducto();
