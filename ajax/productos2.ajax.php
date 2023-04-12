<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
class AjaxProductos{
  /*=============================================
  GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
  =============================================*/
  public $idCategoria;
  public function ajaxCrearCodigoProducto(){
    $item = "id_categoria";
    $valor = $this->idCategoria;
    $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);
    echo json_encode($respuesta);
  }
  /*=============================================
  EDITAR PRODUCTO
  =============================================*/ 
  public $idProducto;
  public $CodAlmacen;
  public $traerProductos;
  public $nombreProducto;
  public function ajaxEditarProducto(){
    if($this->traerProductos == "ok"){
      $item = "CodAlmacen";
      $valor = $this->CodAlmacen;
      $respuesta = ControladorProductos::ctrMostrarProductoss($item, $valor);
      echo json_encode($respuesta);
    }else if($this->nombreProducto != ""){
      $item = "descripcion";
      $valor = $this->nombreProducto;
      $item1="CodAlmacen";
      $valor1 = $this->CodAlmacen;
      $respuesta = ControladorProductos::ctrMostrarStock2($item,$item1, $valor,$valor1);
      echo json_encode($respuesta);
    }else{
      $item ="codigo";
      $item1="CodAlmacen";
      $valor = $this->idProducto;
      $valor1 = $this->CodAlmacen;
      $respuesta = ControladorProductos::ctrMostrarStock12($item,$item1, $valor,$valor1);
      echo json_encode($respuesta);
    }
  }
}
/*=============================================
GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
=============================================*/ 
if(isset($_POST["idCategoria"])){
  $codigoProducto = new AjaxProductos();
  $codigoProducto -> idCategoria = $_POST["idCategoria"];
  $codigoProducto -> ajaxCrearCodigoProducto();
}
/*=============================================
EDITAR PRODUCTO
=============================================*/ 
if(isset($_POST["idProducto"])){
  $editarProducto = new AjaxProductos();
  $editarProducto -> idProducto = $_POST["idProducto"];
  $editarProducto -> CodAlmacen = $_POST["idAlmacen"];
  $editarProducto -> ajaxEditarProducto();
}
/*=============================================
TRAER PRODUCTO
=============================================*/ 
if(isset($_POST["traerProductos"])){
  $traerProductos = new AjaxProductos();
  $traerProductos -> traerProductos = $_POST["traerProductos"];
  $traerProductos -> CodAlmacen = $_POST["idAlmacen"];
  $traerProductos -> ajaxEditarProducto();
}
/*=============================================
TRAER PRODUCTO
=============================================*/ 
if(isset($_POST["nombreProducto"])){
  $traerProductos = new AjaxProductos();
  $traerProductos -> nombreProducto = $_POST["nombreProducto"];
  $traerProductos -> CodAlmacen = $_POST["idAlmacen"];
  $traerProductos -> ajaxEditarProducto();
}
