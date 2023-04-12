<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
class AjaxClientes{
	/*=============================================
	EDITAR CLIENTE
	=============================================*/	
	static public function ctrCrearClienteFactura(){
			if(isset($_POST["nuevoCliente"])){
				   	$tabla = "clientes";
				   	$datos = array("nombre"=>$_POST["nuevoCliente"],
						           "documento"=>$_POST["nuevoDocumentoId"],
						           "email"=>$_POST["nuevoEmail"],
						           "telefono"=>$_POST["nuevoTelefono"],
						           "direccion"=>$_POST["nuevaDireccion"],
						           "fecha_nacimiento"=>$_POST["nuevaFechaNacimiento"]);
				   	$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);
				   	if($respuesta == "ok"){
						echo'1';
					}else{
						echo'2';
					}
			}
	}
}
/*=============================================
EDITAR CLIENTE
=============================================*/	
if(isset($_POST["nuevoCliente"])){
	$cliente = new AjaxClientes();
	$cliente -> ctrCrearClienteFactura();
}
