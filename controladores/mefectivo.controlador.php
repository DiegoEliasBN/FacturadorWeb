<?php
class ControladorMefectivo{
	/*=============================================
	CREAR CATEGORIAS
	=============================================*/
	static public function ctrCrearMefectivo(){
		if(isset($_POST["nuevaDescripcionM"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcionM"])){
				$tabla = "mefectivo";
				$datos = array("descripcionMovimiento"=>$_POST["nuevaDescripcionM"],
							   "CodApertura"=>$_POST["CodCajaM"],
							   "CodAlmacen"=>$_POST["CodAlmacen"],
					           "ValorMovimiento"=>$_POST["valorMovimiento"]
					           );
				var_dump($datos);
				$respuesta = ModeloMefectivo::mdlIngresarMefectivo($tabla, $datos);
				var_dump($respuesta);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El movimiento de efectivo ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "mefectivo";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La descripcion del movimiento no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "mefectivo";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function ctrMostrarMefectivo($item,$item2, $valor,$valor2){
		$tabla = "mefectivo";
		$respuesta = ModeloMefectivo::mdlMostrarMefectivo($tabla, $item,$item2, $valor,$valor2);
		return $respuesta;
	}
	/*=============================================
	EDITAR CATEGORIA
	=============================================*/
	static public function ctrEditarMefectivo(){
		if(isset($_POST["editarDescripcionM"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcionM"])){
				$tabla = "mefectivo";
				$datos = array("descripcionMovimiento"=>$_POST["editarDescripcionM"],
							   "CodApertura"=>$_POST["eCodCajaM"],
							   "CodAlmacen"=>$_POST["eCodAlmacen"],
							   "CodMovimiento"=>$_POST["CodMovimiento"],
					           "ValorMovimiento"=>$_POST["evalorMovimiento"]
					           );
				var_dump($datos);
				$respuesta = ModeloMefectivo::mdlEditarMefectivo($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El movimiento de efectivo ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "mefectivo";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "El movimiento de efectivo no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "mefectivo";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR CATEGORIA
	=============================================*/
	static public function ctrBorrarMefectivo(){
		if(isset($_GET["idMovimiento"])){
			$tabla ="mefectivo";
			$datos = $_GET["idMovimiento"];
			$respuesta = ModeloMefectivo::mdlBorrarMefectivo($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "El movimiento de efectivo ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "mefectivo";
									}
								})
					</script>';
			}
		}
	}
}
