<?php 
require_once "../controladores/acaja.controlador.php";
require_once "../modelos/acaja.modelo.php";
require_once "../controladores/ccaja.controlador.php";
require_once "../modelos/ccaja.modelo.php";
require_once "../controladores/uturno.controlador.php";
require_once "../modelos/uturno.modelo.php";
class ajaxAcaja{
public $idacaja;
public $idTurno;
public $idUTurno;
		public function ajaxEditarACaja(){
			$item=null;
			$valor=null;
			$item1="id";
			$valor1=$this->idacaja;
			$respuesta=ControladorACaja::ctrMostrarACaja($item,$item1,$valor,$valor1);
			echo json_encode($respuesta);
		}
		public function ajaxMostrarACaja(){
			$item=null;
			$valor=null;
			$item1="CodTurno";
			$valor1=$this->idTurno;
			$respuesta=ControladorUsuariosTurno::ctrMostrarUsuariosTurno($item,$item1,$valor,$valor1);
			echo json_encode($respuesta);
		}
		public function ajaxMostrarUturno(){
			$item=null;
			$valor=null;
			$item2="CodUTurno";
			$valor2=$this->idUTurno;
            $respuesta=ControladorCCaja::ctrMostrarCCajaAbierta($item,$item2,$valor,$valor2);
			echo json_encode($respuesta);
		}
}
if (isset($_POST["idacaja"])) {
	$editar =new ajaxAcaja();
	$editar->idacaja=$_POST["idacaja"];
	$editar->ajaxEditarACaja();
}
if (isset($_POST["idTurno"])) {
	$editar =new ajaxAcaja();
	$editar->idTurno=$_POST["idTurno"];
	$editar->ajaxMostrarACaja();
}
if (isset($_POST["validarUsuario"])) {
	$editar =new ajaxAcaja();
	$editar->idUTurno=$_POST["validarUsuario"];
	$editar->ajaxMostrarUturno();
}
