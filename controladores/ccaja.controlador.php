<?php
class ControladorCCaja{
	/*=============================================
	CREAR CLIENTES
	=============================================*/
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function ctrCrearCierreCaja(){
		if(isset($_POST["CodAperturag"])){
			   	$tabla = "cierredecaja";
			   	$tabla1 = "detallecierre";
			   	$tabla2 = "aperturacaja";
			   	$datos = array("CodApertura"=>$_POST["CodAperturag"],
			   				   "CodAlmacen"=>$_POST["CodAlmaceng"],
			   				   "totalFacturaFiada"=>$_POST["facturafiadag"],
			   				   "totalMovimientos"=>$_POST["movimiento"],
			   				   "totalFacturaPagadas"=>$_POST["facturapagadag"],
			   				   "totalFacturaTc"=>$_POST["facturapagadatc"],
			   				   "totalFacturaTd"=>$_POST["facturapagadatd"],
			   				   "totalConsolidado"=>$_POST["totalConsolidado"],
					           "valorcierre"=>$_POST["ValorCierreg"]);
			   	$respuesta = ModeloCCaja::mdlCrearCierreCaja($tabla,$datos);
			   	//var_dump($_POST["facturafiadag"]);
			   	$lista = json_decode($_POST["movimienton"], true);
			   /*$datos1 = array(array('tipodocumento' =>$_POST["facturapagadagn"] ,
											 'Total'=>$_POST["facturapagadag"] ),
								array('tipodocumento' =>$_POST["facturafiadagn"],
											 'Total'=>$_POST["facturafiadag"] ),
								array('tipodocumento' => $_POST["aperturacajagn"],
											 'Total'=> $_POST["aperturacajag"]),
								array('tipodocumento' => $_POST["movimienton"],
											 'Total'=> $_POST["movimiento"]));*/
			   	/*foreach ($datos1 as $value){
					  $datos2=  array("tipodocumento"=>$value["tipodocumento"],
			   				   		 "valorcadauno"=>$value["Total"],
					           		 "CodCierre"=>$respuesta);
					  $respuesta2 = ModeloCCaja::mdlCrearCierreCajaDetalle($tabla1,$datos2);
				}*/
				foreach ($lista as $key => $value) {
					$datos2 = array("CodCierre"=>$respuesta,
			   				   "tipodocumento"=>$value["tipodocumento"],
			   				   "descripcion_cliente"=>$value["descripcion_cliente"],
			   				   "valorcadauno"=>$value["valorcadauno"],
					           "CodDocumento"=>$value["CodDocumento"]);
					$respuesta2 = ModeloCCaja::mdlCrearCierreCajaDetalle($tabla1,$datos2);
				}
				$item="CodApertura";
				$valor=$_POST["CodAperturag"];
				$respuesta2 = ModeloACaja::mdlActualizarApertura($tabla2,$item,$valor);
			   	if($respuesta2 == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El cierre de caja a sido guardado con exito",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
										window.location = "cierrecaja";
									}
								})
					</script>';
				}
		}
	}
	static public function ctrMostrarCCajaAbierta($item,$item2, $valor,$valor2){
		$tabla = "aperturacaja";
		$respuesta1 = ModeloCCaja::mdlMostrarCCajaAbierta($tabla,$item,$item2, $valor,$valor2);
		return $respuesta1;
	}
	static public function ctrMostrarCCaja($item,$item2, $valor,$valor2){
		$tabla = "cierredecaja";
		$respuesta1 = ModeloCCaja::mdlMostrarCCaja($tabla,$item,$item2, $valor,$valor2);
		return $respuesta1;
	}
	static public function ctrMostrarCCajaDetalle($item,$item2, $valor,$valor2){
		$tabla = "detallecierre";
		$respuesta1 = ModeloCCaja::mdlMostrarCCajaDetalle($tabla,$item,$item2, $valor,$valor2);
		return $respuesta1;
	}
	static public function ctrGenerarCCaja($item,$valor){
		$tabla = "ventas";
		$tabla1 = "aperturacaja";
		$tabla2 = "mefectivo";
		$TotalFactura=0;
		$TotalFacturac=0;
		$TotalFacturatd=0;
		$TotalFacturatc=0;
		$Totalapertura=0;
		$Totalmovimiento=0;
		$item1="metodo_pago";
		$valor1="Efectivo";
		$valor2="Credito";
		$valorc="TC";
		$valord="TD";
		$item3=null;
		$valor3=null;
		/*efectivo*/$respuesta1 = ModeloVentas::mdlMostrarVentasCierre($tabla,$item,$item1, $valor,$valor1);
		/*credito*/$respuesta2 = ModeloVentas::mdlMostrarVentasCierre($tabla,$item,$item1, $valor,$valor2);
		/*tarjeta de credito*/$respuestac = ModeloVentas::mdlMostrarVentasCierre($tabla,$item,$item1, $valor,$valorc);
		/*tarjeta de debito*/$respuestad = ModeloVentas::mdlMostrarVentasCierre($tabla,$item,$item1, $valor,$valord);
		/*apertura de caja*/$respuesta3 = ModeloACaja::mdlMostrarACaja($tabla1, $item3,$item, $valor3,$valor);
		/*movimiento de efectivo*/$respuesta4 = ModeloMefectivo::mdlMostrarMefectivo($tabla2,$item3,$item,$valor3,$valor);
		foreach ($respuesta1 as $key => $value) {
			$TotalFactura=$TotalFactura+$value["total"];
		}
		foreach ($respuesta2 as $key => $value1) {
			$TotalFacturac=$TotalFacturac+$value1["total"];
		}
		foreach ($respuestac as $key => $valuec) {
			$TotalFacturatc=$TotalFacturatc+$valuec["total"];
		}
		foreach ($respuestad as $key => $valued) {
			$TotalFacturatd=$TotalFacturatd+$valued["total"];
		}
		foreach ($respuesta3 as $key => $value2) {
			$Totalapertura=$value2["valorapertura"];
		}
		foreach ($respuesta4 as $key => $value3) {
			$Totalmovimiento=$Totalmovimiento+$value3["valorMovimiento"];
		}
		$datos = array("facturae"=>array('tipodocumento' => "Facturas Pagadas",
										 'Total'=>$TotalFactura ),
						"facturac"=>array('tipodocumento' => "Facturas Fiada",
										  'Total' => $TotalFacturac,
										 'Todo'=>$respuesta2 ),
						"facturatc"=>array('tipodocumento' => "Facturas tarjeta de credito",
										 'Total'=>$TotalFacturatc ),
						"facturatd"=>array('tipodocumento' => "Facturas tarjeta de debito",
										  'Total' => $TotalFacturatd,
										 'Todo'=>$respuestad ),
						"movimiento"=>array('tipodocumento' => "Movimiento Efectivo",
											'Total' => $Totalmovimiento,
										 'Todo'=>$respuesta4 ),
						"facturasPagadas"=>array('todo' => $respuesta1 ),
						"apertura"=>array('tipodocumento' => "Apertura de caja",
										 'Total'=> $Totalapertura));
		return $datos;
	}
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	/*static public function ctrEditarACaja(){
		if(isset($_POST["CodUTurnoe"])){
				$tabla = "aperturacaja";
			   $datos = array("CodAlmacen"=>$_POST["CodAlmacene"],
			   				  "valorapertura"=>$_POST["valoraperturae"],
					          "CodUTurno"=>$_POST["CodUTurnoe"],
					      	  "id"=>$_POST["idacaja"]);
			   var_dump($datos);
			   	$respuesta = ModeloACaja::mdlEditarAcaja($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La apertura de caja ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
										window.location = "aperturacaja";
									}
								})
					</script>';
				}
		}
	}*/
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	/*static public function ctrEliminarAcaja(){
		if(isset($_GET["idacaja"])){
			$tabla ="aperturacaja";
			$datos = $_GET["idacaja"];
			$respuesta = ModeloACaja::mdlEliminarACaja($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "La apertura de caja ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "aperturacaja";
								}
							})
				</script>';
			}		
		}
	}*/
}
