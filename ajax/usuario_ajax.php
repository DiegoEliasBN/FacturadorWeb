<?php 
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
	class ajaxUsuario{
		public $idUsuario;
		public function ajaxEditarUsuario(){
			$item="CodUsuario";
			$valor=$this->idUsuario;
			$respuesta=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
			echo json_encode($respuesta);
		}
		/*=============================================
		ACTIVAR USUARIO
		=============================================*/	
		public $activarUsuario;
		public $activarId;
		public function ajaxActivarUsuario(){
			$tabla = "usuario";
			$item1 = "estado";
			$valor1 = $this->activarUsuario;
			$item2 = "CodUsuario";
			$valor2 = $this->activarId;
			$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
		}
		/*=============================================
		VALIDAR NO REPETIR USUARIO
		=============================================*/	
		public $validarUsuario;
		public function ajaxValidarUsuario(){
			$item = "usuario";
			$valor = $this->validarUsuario;
			$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
			echo json_encode($respuesta);
		}
	}
if (isset($_POST["idUsuario"])) {
	$editar =new ajaxUsuario();
	$editar->idUsuario=$_POST["idUsuario"];
	$editar->ajaxEditarUsuario();
}
/*=============================================
ACTIVAR USUARIO
=============================================*/	
if(isset($_POST["activarUsuario"])){
	$activarUsuario = new AjaxUsuario();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();
}
/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/
if(isset( $_POST["validarUsuario"])){
	$valUsuario = new AjaxUsuario();
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();
}