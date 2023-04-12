<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
require_once "../controladores/ValidarIdentificacion.php";
class AjaxClientes{
	/*=============================================
	EDITAR CLIENTE
	=============================================*/	
	public $idCliente;
	public $nombreCliente;
	public $datos  = array(); 
	public function ajaxAgregarCliente(){
		$datosAjax = $this->datos;
		$respuesta = ControladorClientes::ctrCrearClienteAjax($datosAjax);
		echo json_encode($respuesta);
	}
	public function ajaxEditarClienteFactura(){
		$datosAjax = $this->datos;
		$respuesta = ControladorClientes::ctrEditarClienteAjax($datosAjax);
		echo json_encode($respuesta);
	}
	public function ajaxEditarCliente(){
		$item = "id";
		$valor = $this->idCliente;
		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);
		echo json_encode($respuesta);
	}
	public function ajaxEditarClienteCedula(){
		$item = "documento";
		$valor = $this->idCliente;
		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);
		echo json_encode($respuesta);
	}
	public function ajaxAutocompletarCliente(){
		$item ="nombre";
		$valor = $this->nombreCliente;
		$respuesta = ControladorClientes::ctrMostrarStockAutocompletarCliente($item , $valor);
		echo json_encode($respuesta);
	}
}
/*=============================================
EDITAR CLIENTE
=============================================*/	
if(isset($_POST["idCliente"])){
	$cliente = new AjaxClientes();
	$cliente -> idCliente = $_POST["idCliente"];
	$cliente -> ajaxEditarCliente();
}
if(isset($_GET["q"])){
	$cliente = new AjaxClientes();
	$cliente -> idCliente = $_GET["q"];
	$cliente -> ajaxEditarCliente();
}
if(isset($_POST["cedula"])){
	$cliente = new AjaxClientes();
	$cliente -> idCliente = $_POST["cedula"];
	$cliente -> ajaxEditarClienteCedula();
}
if(isset($_GET["nombreClientes"])){
	$cliente = new AjaxClientes();
	$cliente -> nombreCliente = $_GET["nombreClientes"];
	$cliente -> ajaxAutocompletarCliente();
}
if(isset($_POST["nuevoDocumentoId"])){
	$cliente = new AjaxClientes();
	$cliente -> datos = array("nuevoCliente"=>$_POST["nuevoCliente"],
						      "nuevoDocumentoId"=>$_POST["nuevoDocumentoId"],
						      "emailCliente"=>$_POST["emailCliente"],
						      "tipo_documento"=>$_POST["tipo_documento"],
						      "nuevaDireccion"=>$_POST["nuevaDireccion"]
						      );
	$cliente -> ajaxAgregarCliente();
}
if(isset($_POST["editarDocumentoId"])){
	$cliente = new AjaxClientes();
	$cliente -> datos = array("idCliente"=>$_POST["idClienteFactura"],
   				   "editarCliente"=>$_POST["editarCliente"],
		           "editarDocumentoId"=>$_POST["editarDocumentoId"],
		           "editarEmail"=>$_POST["editarEmail"],
		           "editarTelefono"=>$_POST["editarTelefono"],
		           "editarDireccion"=>$_POST["editarDireccion"],
		           "tipo_documento"=>$_POST["tipo_documento"],
		           "editarFechaNacimiento"=>$_POST["editarFechaNacimiento"]);
	$cliente -> ajaxEditarClienteFactura();
}