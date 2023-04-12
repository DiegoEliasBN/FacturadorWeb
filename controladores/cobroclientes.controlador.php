<?php 
class ControladorCobros{
	static public function ctrGuardarCobro(){
		if (isset($_POST["id_cliente"])) {
			if ($_POST["valorCobro"]<=$_POST["deuda"]) {
				$datos = array();
				$tabla = "ventas";
				$item = "saldo";
		        $item1="id_cliente";
		        $valor1=$_POST["id_cliente"];
		        $valorCobro=$_POST["valorCobro"];
		        $item12="id";
		        //var_dump($valorCobro);
				$respuesta = ModeloVentas::mdlMostrarVentasFiadas($tabla,$item,$item1,$valor1);
				foreach ($respuesta as $key => $value) {
					if ($valorCobro>0) {
						if ($valorCobro>$value["saldo"]) {
							//var_dump($value["saldo"]);
							$valorCobro=$valorCobro-$value["saldo"];
							$saldo=0;
							$lcobro=$value["saldo"];
						}else{
							$lcobro=$valorCobro;
							$valorCobro=$value["saldo"]-$valorCobro;
							$saldo=$valorCobro;
						}
						$datos2 = array("id"=>$value["id"],
						   				"pago"=>$lcobro);
						array_push($datos,$datos2 );
						$listaFacturas = json_encode($datos, true);
						 $valor12=$value["id"];
						$respuestaA=ModeloVentas::mdlActualizarVenta($tabla, $item12,$item, $valor12, $saldo);
					}
				}
				$datos = array("CodAlmacen"=>$_POST["CodAlmaceng"],
						   "CodApertura"=>$_POST["CodApertura"],
						   "id_cliente"=>$_POST["id_cliente"],
						   "id_vendedor"=>$_POST["idVendedor"],
						   "CantidadPago"=>$_POST["valorCobro"],
						   "facturas"=>$listaFacturas);
				$tabla12="cobrocliente";
				$respuesta = ModeloCobro::mdlIngresarCobro($tabla12, $datos);
				if($respuesta == "ok"){
					echo'<script>
					localStorage.removeItem("rango");
					swal({
						  type: "success",
						  title: "El cobro ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then((result) => {
									if (result.value) {
										window.location = "cobroclientetabla";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					localStorage.removeItem("rango");
					swal({
						  type: "error",
						  title: "El valor del cobro es mayor a la deuda ",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then((result) => {
									if (result.value) {
										window.location = "cobroclientes";
									}
								})
					</script>';
			}
		}
	}
	static public function ctrMostrarCobros($item,$item1, $valor,$valor1){
		$tabla = "cobrocliente";
		$respuesta = ModeloCobro::mdlMostrarCobros($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
}