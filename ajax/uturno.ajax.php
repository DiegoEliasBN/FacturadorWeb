<?php 
require_once "../controladores/uturno.controlador.php";
require_once "../modelos/uturno.modelo.php";
class ajaxUTurno{
public $idUTurno;
		public function ajaxEditarUTurno(){
			$item="id";
			$valor=$this->idUTurno;
			$respuesta=ControladorUsuariosTurno::ctrMostrarUsuariosTurno1($item,$valor);
			echo json_encode($respuesta);
		}
}
if (isset($_POST["idUTurno"])) {
	$editar =new ajaxUTurno();
	$editar->idUTurno=$_POST["idUTurno"];
	$editar->ajaxEditarUTurno();
}