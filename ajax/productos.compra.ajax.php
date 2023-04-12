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
      $item ="CodProducto";
      $item2="id";
      $item1="CodAlmacen";
      $valor = $this->idProducto;
      $valor1 = $this->CodAlmacen;
      $respuesta = ControladorProductos::ctrMostrarStock1($item,$item1, $valor,$valor1);
      $respuesta1=ControladorProductos::ctrMostrarProductos($item2, $valor);
      if (empty($respuesta)) {
        $respuesta[0]["CantidadIngreso"]=0;
        $respuesta[0]["CodAlmacen"]=$valor1;
      }
      $datos=array('respuesta' => $respuesta,
        'respuesta1' => $respuesta1);
      echo json_encode($datos);
      //echo json_encode($respuesta);
    }
  }
  public function ajaxEditarProductos(){
    if($this->traerProductos == "ok"){
      $item = null;
      $valor = null;
      $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);
      echo json_encode($respuesta);
    }else if($this->nombreProducto != ""){
      $item = "descripcion";
      $valor = $this->nombreProducto;
      $item1="CodAlmacen";
      $valor1 = $this->CodAlmacen;
      $respuesta = ControladorProductos::ctrMostrarStock2($item,$item1, $valor,$valor1);
      $respuesta1=ControladorProductos::ctrMostrarProductos($item, $valor);
      if (empty($respuesta)) {
        $respuesta[0]["CantidadIngreso"]=0;
        $respuesta[0]["CodAlmacen"]=$valor1;
      }
      $datos=array('respuesta' => $respuesta,
        'respuesta1' => $respuesta1);
      echo json_encode($datos);
      //echo json_encode($respuesta);
    }else{
      $item ="CodProducto";
      $item2="id";
      $item1="CodAlmacen";
      $valor = $this->idProducto;
      $valor1 = $this->CodAlmacen;
      $respuesta = ControladorProductos::ctrMostrarStock1($item,$item1, $valor,$valor1);
      $respuesta1=ControladorProductos::ctrMostrarProductos($item2, $valor);
      if (empty($respuesta)) {
        $respuesta[0]["CantidadIngreso"]=0;
        $respuesta[0]["CodAlmacen"]=$valor1;
      }
      $datos=array('respuesta' => $respuesta,
        'respuesta1' => $respuesta1);
      echo json_encode($datos);
      //echo json_encode($respuesta);
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
if(isset($_POST["traerProductoss"])){
  $traerProductos = new AjaxProductos();
  $traerProductos -> traerProductos = $_POST["traerProductoss"];
  $traerProductos -> ajaxEditarProductos();
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
if(isset($_POST["nombreProductos"])){
  $traerProductos = new AjaxProductos();
  $traerProductos -> nombreProducto = $_POST["nombreProductos"];
  $traerProductos -> CodAlmacen = $_POST["idAlmacen"];
  $traerProductos -> ajaxEditarProductos();
}