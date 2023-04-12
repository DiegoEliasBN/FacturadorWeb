<?php
class ControladorACaja{
	/*=============================================
	CREAR CLIENTES
	=============================================*/
	static public function ctrCrearACaja(){
		if(isset($_POST["CodUTurno"])){
			   	$tabla = "aperturacaja";
			   	$datos = array("CodAlmacen"=>$_POST["CodAlmacen"],
			   				   "valorapertura"=>$_POST["valorapertura"],
					           "CodUTurno"=>$_POST["CodUTurno"]);
			   	$respuesta = ModeloACaja::mdlIngresarACaja($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La apertura de caja ha sido guardado correctamente",
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
	}
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function ctrMostrarACaja($item,$item2, $valor,$valor2){
		$tabla = "aperturacaja";
		$respuesta = ModeloACaja::mdlMostrarACaja($tabla,$item,$item2, $valor,$valor2);
		return $respuesta;
	}
	static public function ctrMostrarACaja1($item, $valor){
		$tabla = "aperturacaja";
		$respuesta = ModeloACaja::mdlMostrarACajas($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarACajaAbierta($item,$item2, $valor,$valor2){
		$tabla = "aperturacaja";
		$tabla1="usuarioturno";
		$salida="";
		$item4="id";
		$item1=null;
		$valor1=null;
		$respuesta1 = ModeloACaja::mdlMostrarACajaAbierta($tabla,$item1,$item2, $valor1,$valor2);
		foreach ($respuesta1 as $key => $value) {
			$valor4=$value["CodUTurno"];
			$usuarioturno=ModeloUTurno::mdlMostrarUTurno($tabla1, $item4,$item2, $valor4,$valor2);
			foreach ($usuarioturno as $key => $value1) {
				if($valor==$value1["CodUsuario"]){
					$salida=$value["CodApertura"];
				}
			}
		}
		if ($salida=="") {
			echo'<script>
					swal({
						  type: "error",
						  title: "No se ha aperturado caja para su usuario",
						  allowOutsideClick:false,
						  showConfirmButton: true,
						  }).then(function(result){
									if (result.value) {
										window.location = "inicio";
									}
								})
					</script>';
		}else{
			return $salida;
		}
		//$respuesta = ModeloACaja::mdlMostrarACajaAbierta($tabla,$item,$item2, $valor,$valor2);
		/*if ($respuesta="") {
			echo'<script>
					swal({
						  type: "error",
						  title: "No se ah aperturado caja para su usuario",
						  showConfirmButton: true,
						  }).then(function(result){
									if (result.value) {
									window.location = "ventas";
									}
								})
					</script>';
		}else{
			return $respuesta;
			var_dump($respuesta);
		}*/
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
