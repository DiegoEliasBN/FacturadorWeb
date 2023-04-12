<?php 
	require_once "controladores/plantilla.controlador.php";
	require_once "controladores/usuarios.controlador.php";
	require_once "controladores/categorias.controlador.php";
	require_once "controladores/productos.controlador.php";
	require_once "controladores/clientes.controlador.php";
	require_once "controladores/proveedores.controlador.php";
	require_once "controladores/ventas.controlador.php";
	require_once "controladores/almacen.controlador.php";
	require_once "controladores/ualmacen.controlador.php";
	require_once "controladores/compras.controlador.php";
	require_once "controladores/turno.controlador.php";
	require_once "controladores/uturno.controlador.php";
	require_once "controladores/acaja.controlador.php";
	require_once "controladores/ccaja.controlador.php";
	require_once "controladores/mefectivo.controlador.php";
	require_once "controladores/traspasos.controlador.php";
	require_once "controladores/cobroclientes.controlador.php";
	require_once "controladores/remision.controlador.php";
	require_once "controladores/retencion.controlador.php";
	require_once "controladores/transporte.controlador.php";
	require_once "controladores/ValidarIdentificacion.php";
	require_once "controladores/liquidacion.controlador.php";
	require_once "modelos/usuarios.modelo.php";
	require_once "modelos/cobrocliente.modelo.php";
	require_once "modelos/traspasos.modelo.php";
	require_once "modelos/categorias.modelo.php";
	require_once "modelos/productos.modelo.php";
	require_once "modelos/clientes.modelo.php";
	require_once "modelos/proveedores.modelo.php";
	require_once "modelos/ventas.modelo.php";
	require_once "modelos/almacen.modelo.php";
	require_once "modelos/ualmacen.modelo.php";
	require_once "modelos/compras.modelo.php";
	require_once "modelos/turno.modelo.php";
	require_once "modelos/uturno.modelo.php";
	require_once "modelos/acaja.modelo.php";
	require_once "modelos/ccaja.modelo.php";
	require_once "modelos/mefectivo.modelo.php";
	require_once "modelos/remision.modelo.php";
	require_once "modelos/retencion.modelo.php";
	require_once "modelos/transporte.modelo.php";
	require_once "modelos/liquidacion.modelo.php";
	require_once "extenciones/vendor/autoload.php";
    defined('ACCESS')  or define('ACCESS', true);
    defined('PATH_ROOT') or define('PATH_ROOT', dirname(__FILE__));
    if (isset($_GET["ruta"]) && $_GET["ruta"]=="sri"){
        require_once "sri/index.php";
        /* activar el proceso de autorizar las facturas electronicas pendientes */
        $sri= new ComprobantesElectronicos();
        if(isset($_GET["ride"])){
            $sri->showPDF($_GET["ride"]);
        }elseif(isset($_GET["xml"])){
            $sri->downloadXML($_GET["xml"]);
        }else{
            $sri->procesarComprobantesPendientes();
        }
        die();
    }
	$plantilla= new ControladorPlantilla();
	$plantilla->ctrPlantilla();