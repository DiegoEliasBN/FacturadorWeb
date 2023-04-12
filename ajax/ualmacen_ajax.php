<?php 
require_once "../controladores/ualmacen.controlador.php";
require_once "../modelos/ualmacen.modelo.php";
class ajaxUAlmacen{
public $idUAlmacen;
		public function ajaxEditarUAlmacen(){
			$item="CodUsuarioAlmacen";
			$valor=$this->idUAlmacen;
			$respuesta=ControladorUsuariosAlmacen::ctrMostrarUsuariosAlmacen($item,$valor);
			echo json_encode($respuesta);
		}
}
if (isset($_POST["idUAlmacen"])) {
	$editar =new ajaxUAlmacen();
	$editar->idUAlmacen=$_POST["idUAlmacen"];
	$editar->ajaxEditarUAlmacen();
}