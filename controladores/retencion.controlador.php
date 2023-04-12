<?php
class ControladorRetenciones{
	/*=============================================
	MOSTRAR RETENCIONES
	=============================================*/
	static public function ctrMostrarRetenciones($item,$item1, $valor,$valor1){
		$tabla = "retencion";
		$respuesta = ModeloRetenciones::mdlMostrarRetenciones($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
	static public function ctrMostrarTipoComprobanteF($item, $valor){
		$tabla = "tipo_compobante";
		$respuesta = ModeloRetenciones::mdlMostrarTipoComprobanteF($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarVistaRetenciones($item,$item1, $valor,$valor1){
		$tabla = "vista_retenciones";
		$respuesta = ModeloRetenciones::mdlMostrarRetenciones($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
	 public static function ctrMostrarRetencionesEmail()
    {
        $tabla = "retencion";
        $respuesta = ModeloRetenciones::mdlMostrarRetencionesEmail($tabla);
        return $respuesta;
    }
	static public function ctrMostrarDetalleRetenciones($item, $valor){
	$tabla = "detalle_retencion";
	$respuesta = ModeloRetenciones::mdlMostrarDetalleRetenciones($tabla,$item, $valor);
	return $respuesta;
	}
	static public function ctrMostrarTipoComprobante(){
		$tabla = "tipo_compobante";
		$respuesta = ModeloRetenciones::mdlMostrarTipoComprobante($tabla);
		return $respuesta;
	}
	static public function ctrMostrarTipoImpuesto($item, $valor){
		$tabla = "sri_impuestos";
		$respuesta = ModeloRetenciones::mdlMostrarTipoImpuesto($tabla,$item, $valor);
		return $respuesta;
	}
	/*=============================================
	INGRESAR EL CABECERA DE RETENCION
	=============================================*/
	static public function ctrCrearRetenciones(){
			if(isset($_POST["fechacomprobante"])){
				if ($_POST["listaDetalle"]=="") {
					echo '<script>
						swal({
							type:"error",
							title: "EL DETALLE DE LA RETENCION NO PUEDE IR VACIO!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "crear-retencion";
							}
							});
					</script>';
				}else{
					$tabla="retencion";
					$secuenciaRespuesta = ModeloRetenciones::mdlSecuenciaRetenciones($tabla);
					if (!empty($secuenciaRespuesta)) {
						$secuencia=$secuenciaRespuesta["Secuencia"]+1;
					}else{
						$secuencia=1;
					}
					$datos = array(
								   "id_almacen"=>$_POST["id_almacen"],
								   "secuencia"=>$secuencia,
								   "acreedor"=>$_POST["acreedor"],
								   "tipocomprobante"=>$_POST["tipocomprobante"],
								   "numerocomprobante"=>$_POST["numerocomprobante"],
								   "fechacomprobante"=>$_POST["fechacomprobante"],
								   );
					//var_dump($datos);
					$respuesta = ModeloRetenciones::mdlIngresarRetenciones($tabla, $datos);
					if($respuesta["respuesta"] == "ok"){
						$listaDetalle = json_decode($_POST["listaDetalle"], true);
						//var_dump($_POST["listaProductos"]);
						foreach ($listaDetalle as $key => $value) {
						   $tablaDetalle = "detalle_retencion";
						   $datosDetalle = array("id_retencion"=>$respuesta["id_retencion"],
								   "id_impuesto"=>$value["id_impuesto"],
								   "tazaretencion"=>$value["tazaretencion"],
									"baseimponible"=>$value["baseimponible"],
								   "total"=>$value["total"]);
						   $nuevoDetalle = ModeloRetenciones::mdlIngresarDetalleRetencion($tablaDetalle,$datosDetalle);
						}
						echo'<script>
						localStorage.removeItem("rango");
						swal({
							  type: "success",
							  title: "La retencion ha sido guardada con exito",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							  }).then((result) => {
										if (result.value) {
											window.location = "retencion";
										}
									})
						</script>';
					}else {
						echo'<script>
						swal({
							  type: "error",
							  title: "La retencion no se ha guardado",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then((result) => {
										if (result.value) {
										window.location = "retencion";
										}
									})
						</script>';
					}
				}
			}
	}
	/*=============================================
    RANGO FECHAS
    =============================================*/
    public static function ctrRangoFechasRetenciones($fechaInicial, $fechaFinal, $item, $valor)
    {
        $tabla = "retencion";
        $respuesta = ModeloRetenciones::mdlRangoFechasRetenciones($tabla, $fechaInicial, $fechaFinal, $item, $valor);
        return $respuesta;
    }
}