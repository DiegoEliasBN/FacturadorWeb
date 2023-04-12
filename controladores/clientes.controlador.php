<?php
class ControladorClientes{
	/*=============================================
	CREAR CLIENTES
	=============================================*/
	static public function ctrCrearCliente(){
		if(isset($_POST["nuevoCliente"])){
			$validacion= new ValidarIdentificacion();
		   	$tabla = "clientes";
		   	if ($_POST["nuevo_tipo_documento"] == "04" || $_POST["nuevo_tipo_documento"] == "05" ) {
			   	if (strlen($_POST["nuevoDocumentoId"])==10) {
			   		$validaciondocumento=$validacion -> validarCedula($_POST["nuevoDocumentoId"]);
			   	}elseif (strlen($_POST["nuevoDocumentoId"])==13) {
			   		$validaciondocumento=$validacion -> validarRucPersonaNatural($_POST["nuevoDocumentoId"]);
			   		if ($validaciondocumento==false) {
			   			$validaciondocumento=$validacion -> validarRucSociedadPrivada($_POST["nuevoDocumentoId"]);
			   		}
			   		if ($validaciondocumento==false) {
			   			$validaciondocumento=$validacion -> validarRucSociedadPublica($_POST["nuevoDocumentoId"]);
			   		}
			   	}
		   	} else {
		   		$validaciondocumento= true;
		   	}
		   	if ($validaciondocumento==true) {
			   	$datos = array("nombre"=>$_POST["nuevoCliente"],
					           "documento"=>$_POST["nuevoDocumentoId"],
					           "email"=>$_POST["nuevoEmail"],
					           "telefono"=>$_POST["nuevoTelefono"],
					           "direccion"=>$_POST["nuevaDireccion"],
					           "fecha_nacimiento"=>$_POST["nuevaFechaNacimiento"],
					       	   "tipo_documento"=>$_POST["nuevo_tipo_documento"]);
			   	$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El cliente ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
										window.location = "clientes";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "La cedula o RUC no son validos!!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
										window.location = "clientes";
									}
								})
					</script>';
			}
		}
	}
	static public function ctrCrearClienteAjax($datosAjax){
		$validacion= new ValidarIdentificacion();
		$validaciondocumento=false;
	   	$tabla = "clientes";
	   	if ($datosAjax["tipo_documento"] == "04" || $datosAjax["tipo_documento"] == "05" ) {
			if (strlen($datosAjax["nuevoDocumentoId"])==10) {
	   			$validaciondocumento=$validacion -> validarCedula($datosAjax["nuevoDocumentoId"]);
	   		}elseif (strlen($datosAjax["nuevoDocumentoId"])==13) {
	   			$validaciondocumento=$validacion -> validarRucPersonaNatural($datosAjax["nuevoDocumentoId"]);
		   		if ($validaciondocumento==false) {
		   			$validaciondocumento=$validacion -> validarRucSociedadPrivada($datosAjax["nuevoDocumentoId"]);
		   		}
		   		if ($validaciondocumento==false) {
		   			$validaciondocumento=$validacion -> validarRucSociedadPublica($datosAjax["nuevoDocumentoId"]);
		   		}
	   		}
		} else {
		   	$validaciondocumento= true;
		}
	   	if ($validaciondocumento==true) {
		   	$datos = array("nombre"=>$datosAjax["nuevoCliente"],
				           "documento"=>$datosAjax["nuevoDocumentoId"],
				           "email"=>$datosAjax["emailCliente"],
				           "tipo_documento"=>$datosAjax["tipo_documento"],
				           "direccion"=>$datosAjax["nuevaDireccion"]);
		   	$respuesta = ModeloClientes::mdlIngresarClienteAjax($tabla, $datos);
		   	return $respuesta;
		}else{
			$datos=array("respuesta"=>"errorValidacion");
			return $datos;
		}
	}
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function ctrMostrarClientes($item, $valor){
		$tabla = "clientes";
		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarStockAutocompletarCliente($item, $valor){
	$tabla = "clientes";
	$respuesta = ModeloClientes::mdlMostrarStockAutocompletarCliente($tabla,$item, $valor);
	return $respuesta;
	}
	static public function ctrMostrarClientes2($item, $valor){
		$tabla = "clientes";
		$respuesta = ModeloClientes::mdlMostrarClientes2($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarClientes3($item, $valor){
		$tabla = "clientes";
		$respuesta = ModeloClientes::mdlMostrarClientes3($tabla, $item, $valor);
		return $respuesta;
	}
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function ctrEditarCliente(){
		if(isset($_POST["editarCliente"])){
		   	$tabla = "clientes";
		   	$datos = array("id"=>$_POST["idCliente"],
		   				   "nombre"=>$_POST["editarCliente"],
				           "documento"=>$_POST["editarDocumentoId"],
				           "email"=>$_POST["editarEmail"],
				           "telefono"=>$_POST["editarTelefono"],
				           "direccion"=>$_POST["editarDireccion"],
				           "fecha_nacimiento"=>$_POST["editarFechaNacimiento"]);
		   	$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);
		   	if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El cliente ha sido cambiado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "clientes";
								}
							})
				</script>';
			}
		}
	}
	static public function ctrEditarClienteAjax($datosAjax){
	   	$tabla = "clientes";
	   	$datos = array("id"=>$datosAjax["idCliente"],
	   				   "nombre"=>$datosAjax["editarCliente"],
			           "documento"=>$datosAjax["editarDocumentoId"],
			           "email"=>$datosAjax["editarEmail"],
			           "telefono"=>$datosAjax["editarTelefono"],
			           "direccion"=>$datosAjax["editarDireccion"],
			            "tipo_documento"=>$datosAjax["tipo_documento"],
			           "fecha_nacimiento"=>$datosAjax["editarFechaNacimiento"]);
	   	$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);
	   	return $respuesta;
	}
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	static public function ctrEliminarCliente(){
		if(isset($_GET["idCliente"])){
			$tabla ="clientes";
			$datos = $_GET["idCliente"];
			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El cliente ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "clientes";
								}
							})
				</script>';
			}		
		}
	}
}
