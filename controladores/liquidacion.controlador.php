<?php
/*use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;*/
class ControladorLiquidaciones
{
    /*=============================================
    MOSTRAR VENTAS
    =============================================*/
    public static function ctrMostrarLiquidaciones($item, $item1, $valor, $valor1)
    {
        $tabla = "liquidacion";
        $respuesta = ModeloLiquidaciones::mdlMostrarLiquidaciones($tabla, $item, $item1, $valor, $valor1);
        return $respuesta;
    }
     public static function ctrMostrarDetalleLiquidacion($item, $valor)
    {
        $tabla = "detalle_liquidacion";
        $respuesta = ModeloLiquidaciones::mdlMostrarDetalleLiquidacion($tabla, $item, $valor);
        return $respuesta;
    }
    public static function ctrMostrarLiquidacionElectronica($item, $valor)
    {
        $tabla = "liquidacion";
        $respuesta = ModeloLiquidaciones::mdlMostrarLiquidacionElectronica($tabla, $item, $valor);
        return $respuesta;
    }
    /*=============================================
    CREAR LIQUIDACION
    =============================================*/
    public static function ctrCrearLiquidacion($datosAjax)
    {
        /*=============================================
        GUARDAR LA LIQUIDACION
        =============================================*/
        date_default_timezone_set('America/Guayaquil');
        $fecha   = date('Y-m-d');
        $hora    = date('H:i:s');
        $valor1b = $fecha . ' ' . $hora;
        $tabla = "liquidacion";
        $datos = array("id_vendedor" => $datosAjax["idVendedor"],
            "id_cliente"                 => $datosAjax["seleccionarCliente"],
            "impuesto"                   => $datosAjax["nuevoIva"],
            "iva_12"                     => $datosAjax["nuevoIva12"],
            "iva_0"                      => $datosAjax["nuevoIva0"],
            "neto"                       => $datosAjax["totalVenta"],
            "total"                      => $datosAjax["nuevoTotalsito"],
            "CodAlmacen"                 => $datosAjax["nuevoAlmacen"],
            "CodUTurno"                  => $datosAjax["CodUTurno"],
            "fecha"                      => $valor1b);
        $respuesta = ModeloLiquidaciones::mdlIngresarLiquidacion($tabla, $datos);
        if ($respuesta["respuesta"] == "ok") {
            $listaDetalle = json_decode($datosAjax["listaProductos"], true);
            foreach ($listaDetalle as $key => $value) {
                $tablaDetalle = "detalle_liquidacion";
                $datosDetalle = array("id_liquidacion" => $respuesta["id_liquidacion"],
                    "id_producto"                      => $value["id"],
                    "descripcion_producto"             => $value["descripcion"],
                    "cantidad"                         => $value["cantidad"],
                    "precio_compra"                    => $value["precioc"],
                    "total"                            => $value["total"],
                    "total_iva"                        => $value["ivavalor"],
                    "total_con_iva"                    => $value["ivafinal"],
                    "estado_iva"                       => $value["ivasi"]);
                $nuevoDetalle = ModeloLiquidaciones::mdlIngresarDetalleLiquidacion($tablaDetalle, $datosDetalle);
            }
        }
        return $respuesta;
        /*if($respuesta == "ok"){
    echo'<script>
    localStorage.removeItem("rango");
    swal({
    type: "success",
    title: "La venta ha sido guardada correctamente",
    showConfirmButton: true,
    confirmButtonText: "Cerrar",
    timer: 1000,
    closeOnConfirm: false
    }).then((result) => {
    if (result.value) {
    window.location = "crear-venta";
    }else{
    window.location = "crear-venta";
    }
    })
    </script>';
    }else {
    echo'<script>
    swal({
    type: "error",
    title: "La venta no se ha guardado",
    showConfirmButton: true,
    confirmButtonText: "Cerrar"
    }).then((result) => {
    if (result.value) {
    window.location = "ventas";
    }
    })
    </script>';
    }*/
    }
    /*=============================================
    EDITAR VENTA
    =============================================*/
    static public function ctrEditarVenta($datosAjax){
        /*=============================================
        FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
        =============================================*/
        $tabla = "ventas";
        $item = "id";
        $valor = $datosAjax["editarVenta"];
        $item1="CodAlmacen";
        $valor1=$datosAjax["CodAlmacen"];
        $traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item,$item1, $valor,$valor1);
        /*=============================================
        REVISAR SI VIENE PRODUCTOS EDITADOS
        =============================================*/
        if($datosAjax["listaProductos"] == ""){
            $listaProductos = $traerVenta["productos"];
            //var_dump($listaProductos);
            $cambioProducto = false;
        }else{
            $listaProductos = $datosAjax["listaProductos"];
            //var_dump($listaProductos);
            $cambioProducto = true;
        }
        /*=============================================
        GUARDAR CAMBIOS DE LA COMPRA
        =============================================*/ 
        if ($datosAjax["nuevoMetodoPago"] == "Credito") {
            $saldo = $datosAjax["nuevoTotalsito"];
        } else {
            $saldo = 0;
        }
        if ($datosAjax["codigo_df"]=="undefined") {
            $codigo_df=null;
        }else{
            $codigo_df=$datosAjax["codigo_df"];
        }
        $datos = array("id_vendedor"=>$datosAjax["idVendedor"],
                       "id_cliente"=>$datosAjax["seleccionarCliente"],
                       "codigo"=>$datosAjax["editarVenta"],
                       "productos"=>$listaProductos,
                       "impuesto"=>$datosAjax["nuevoIva"],
                       "iva_12"=>$datosAjax["nuevoIva12"],
                       "iva_0"=>$datosAjax["nuevoIva0"],
                       "neto"=>$datosAjax["totalVenta"],
                       "total"=>$datosAjax["nuevoTotalsito"],
                       "totalcompra"=>$datosAjax["nuevoCompra"],
                       "saldo"=>$saldo,
                       "tipo"=>$datosAjax["Factura"],
                       "metodo_pago"=> $datosAjax["nuevoMetodoPago"],
                       "codigo_df"                  => $codigo_df,
                       "CodApertura"=>$datosAjax["CodUTurno"]);
        //var_dump($datos);
        $respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);
        if($respuesta == "ok"){
            if($cambioProducto){
                $tablaDetalle = "detalle_venta";
                $eliminiarDetalle=ModeloVentas::mdlEliminarDetalleVenta($tablaDetalle,$valor);
                $productos =  json_decode($traerVenta["productos"], true);
                $totalProductosComprados = array();
                foreach ($productos as $key => $value) {
                    array_push($totalProductosComprados, $value["cantidad"]);
                    $tablaProductos = "stockalmacen";
                    $item = "CodProducto";
                    $valor = $value["id"];
                    $traerProducto = ModeloProductos::mdlMostrarStock($tablaProductos, $item,$item1, $valor,$valor1);
                    $item1a = "ventasa";
                    $valor1a = $traerProducto["ventasa"] - $value["cantidad"];
                    //var_dump($value["cantidad"]);
                    //var_dump($traerProducto["ventasa"]);
                    $nuevasVentas = ModeloProductos::mdlActualizarStock($valor1,$tablaProductos, $item1a, $valor1a, $valor);
                    $item1b = "CantidadEgreso";
                    $valor1b =$traerProducto["CantidadEgreso"]- $value["cantidad"];
                    //var_dump($valor1b);
                    $nuevoStock = ModeloProductos::mdlActualizarStock($valor1,$tablaProductos, $item1b, $valor1b, $valor);
                }
                $tablaClientes = "clientes";
                $itemCliente = "id";
                $valorCliente = $datosAjax["seleccionarCliente"];
                $traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);
                $item1a = "compras";
                $valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);
                $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);
                /*=============================================
                ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
                =============================================*/
                $listaProductos_2 = json_decode($listaProductos, true);
                $totalProductosComprados_2 = array();
                foreach ($listaProductos_2 as $key => $value) {
                    array_push($totalProductosComprados_2, $value["cantidad"]);
                    $tablaProductos_2 = "stockalmacen";
                    $item_2 = "CodProducto";
                    $valor_2 = $value["id"];
                    $traerProducto_2 = ModeloProductos::mdlMostrarStock($tablaProductos_2, $item_2,$item1, $valor_2,$valor1);
                    $item1a_2 = "ventasa";
                    $valor1a_2 = $value["cantidad"] + $traerProducto_2["ventasa"];
                    $nuevasVentas_2 = ModeloProductos::mdlActualizarStock($valor1,$tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);
                    $item1b_2 = "CantidadEgreso";
                    $valor1b_2 = $value["cantidad"] + $traerProducto_2["CantidadEgreso"];
                    $nuevoStock_2 = ModeloProductos::mdlActualizarStock($valor1,$tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
                    $datosDetalle = array("id_factura" => $datosAjax["editarVenta"],
                    "id_producto"                      => $value["id"],
                    "descripcion_producto"             => $value["descripcion"],
                    "cantidad"                         => $value["cantidad"],
                    "precio_compra"                    => $value["precioc"],
                    "precio_venta"                     => $value["precio"],
                    "total"                            => $value["total"],
                    "precio_con_iva"                   => $value["precioconiva"],
                    "total_iva"                        => $value["ivavalor"],
                    "total_con_iva"                    => $value["ivafinal"],
                    "total_precio_compra"              => $value["totalcompra"],
                    "estado_iva"                       => $value["ivasi"]);
                    $nuevoDetalle = ModeloVentas::mdlIngresarDetalleFactura($tablaDetalle, $datosDetalle);
                }
                $tablaClientes_2 = "clientes";
                $item_2 = "id";
                $valor_2 = $datosAjax["seleccionarCliente"];
                $traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);
                $item1a_2 = "compras";
                $valor1a_2 = array_sum($totalProductosComprados_2) + $traerCliente_2["compras"];
                $comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);
                $item1b_2 = "ultima_compra";
                date_default_timezone_set('America/Guayaquil');
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $valor1b_2 = $fecha.' '.$hora;
                $fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);
            }
           return $respuesta; 
        }
    }
    /*=============================================
    ELIMINAR VENTA
    =============================================*/
    public static function ctrEliminarLiquidacion()
    {
        if (isset($_GET["idVenta"])) {
            $tabla = "liquidacion";
            $item   = "id";
            $item1  = "CodAlmacen";
            $valorId  = $_GET["idVenta"];
            $valor1 = $_GET["idAlmacen"];
            /*=============================================
            ELIMINAR VENTA
            =============================================*/
            $tablaDetalle = "detalle_liquidacion";
            $eliminiarDetalle=ModeloLiquidaciones::mdlEliminarDetalleLiquidacion($tablaDetalle,$valorId);
            $respuesta = ModeloLiquidaciones::mdlEliminarLiquidacion($tabla, $_GET["idVenta"]);
            var_dump($eliminiarDetalle);
            if ($respuesta == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "La liquidacion ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {
								}
							})
				</script>';
            }
        }
    }
  public static function ctrDescargarReporte()
    {
        $item2  = "CodAlmacen";
        $valor2 = $_GET["CodAlmacen"];
        if (isset($_GET["reporte"])) {
            $tabla = "ventas";
            if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {
                $ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"], $item2, $valor2);
            } else {
                $item  = null;
                $valor = null;
                $ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $item2, $valor, $valor2);
            }
            /*=============================================
            CREAMOS EL ARCHIVO DE EXCEL
            =============================================*/
            $Name = $_GET["reporte"] . '.xls';
            header('Expires: 0');
            header('Cache-control: private');
            header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
            header("Cache-Control: cache, must-revalidate");
            header('Content-Description: File Transfer');
            header('Last-Modified: ' . date('D, d M Y H:i:s'));
            header("Pragma: public");
            header('Content-Disposition:; filename="' . $Name . '"');
            header("Content-Transfer-Encoding: binary");
            echo utf8_decode("<table border='0'>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>
					</tr>");
            foreach ($ventas as $row => $item) {
                $cliente  = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
                $vendedor = ControladorUsuarios::ctrMostrarUsuarios("CodUsuario", $item["id_vendedor"]);
                echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>" . $item["codigo"] . "</td>
			 			<td style='border:1px solid #eee;'>" . $cliente["nombre"] . "</td>
			 			<td style='border:1px solid #eee;'>" . $vendedor["nombre"] . "</td>
			 			<td style='border:1px solid #eee;'>");
                $productos = json_decode($item["productos"], true);
                foreach ($productos as $key => $valueProductos) {
                    echo utf8_decode($valueProductos["cantidad"] . "<br>");
                }
                echo utf8_decode("</td><td style='border:1px solid #eee;'>");
                foreach ($productos as $key => $valueProductos) {
                    echo utf8_decode($valueProductos["descripcion"] . "<br>");
                }
                echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ " . number_format($item["impuesto"], 2) . "</td>
					<td style='border:1px solid #eee;'>$ " . number_format($item["neto"], 2) . "</td>
					<td style='border:1px solid #eee;'>$ " . number_format($item["total"], 2) . "</td>
					<td style='border:1px solid #eee;'>" . $item["metodo_pago"] . "</td>
					<td style='border:1px solid #eee;'>" . substr($item["fecha"], 0, 10) . "</td>
		 			</tr>");
            }
            echo "</table>";
        }
    }
    /*=============================================
    RANGO FECHAS
    =============================================*/
    public static function ctrRangoFechasLiquidaciones($fechaInicial, $fechaFinal, $item, $valor)
    {
        $tabla = "liquidacion";
        $respuesta = ModeloLiquidaciones::mdlRangoFechasLiquidaciones($tabla, $fechaInicial, $fechaFinal, $item, $valor);
        return $respuesta;
    }
}
