<?php
class ControladorRemisiones{
	/*=============================================
	MOSTRAR REMISIONES
	=============================================*/
	static public function ctrMostrarRemisiones($item,$item1, $valor,$valor1){
		$tabla = "guia_remision";
		$respuesta = ModeloRemisiones::mdlMostrarRemisiones($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
	/*=============================================
	INGRESAR EL CABECERA DE LA GUIA DE REMISION
	=============================================*/
	static public function ctrCrearRemision(){
			if(isset($_POST["direccion_destino"])){
				if ($_POST["listaDetalle"]=="") {
					echo '<script>
						swal({
							type:"error",
							title: "EL DETALLE DE LA GUIA NO PUEDE IR VACIO!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "crear-guia-remision";
							}
							});
					</script>';
				}else{
					$tabla="guia_remision";
					$secuenciaRespuesta = ModeloRemisiones::mdlSecuenciaRemisiones($tabla);
					if (!empty($secuenciaRespuesta)) {
						$secuencia=$secuenciaRespuesta["secuencia"]+1;
					}else{
						$secuencia=1;
					}
					$datos = array(
								   "id_local"=>$_POST["id_local"],
								   "id_trasporte"=>$_POST["id_trasporte"],
								   "id_cliente"=>$_POST["seleccionarCliente"],
								   "fecha_inicio"=>$_POST["fecha_inicio"],
								   "fecha_fin"=>$_POST["fecha_fin"],
								   "secuencia"=>$secuencia,
								   "direccion_inicio"=>$_POST["direccion_inicio"],
								   "direccion_destino"=>$_POST["direccion_destino"],
								   "motivo_traslado"=>$_POST["motivo_traslado"]);
					//var_dump($datos);
					$respuesta = ModeloRemisiones::mdlIngresarRemision($tabla, $datos);
					if($respuesta["respuesta"] == "ok"){
						$listaDetalle = json_decode($_POST["listaDetalle"], true);
						//var_dump($_POST["listaProductos"]);
						foreach ($listaDetalle as $key => $value) {
						   $tablaDetalle = "detalle_guia_remision";
						   $datosDetalle = array("id_guia_remision"=>$respuesta["id_guia_remision"],
								   "id_producto"=>$value["id_producto"],
								   "cantidad"=>$value["cantidad"]);
						   $nuevoDetalle = ModeloRemisiones::mdlIngresarDetalleRemision($tablaDetalle,$datosDetalle);
						}
						echo'<script>
						localStorage.removeItem("rango");
						swal({
							  type: "success",
							  title: "La remision ha sido guardada con exito",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							  }).then((result) => {
										if (result.value) {
											window.location = "guia-remision";
										}
									})
						</script>';
					}else {
						echo'<script>
						swal({
							  type: "success",
							  title: "La guia de remision no se ha guardado",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then((result) => {
										if (result.value) {
										}
									})
						</script>';
					}
				}
			}
	}
}