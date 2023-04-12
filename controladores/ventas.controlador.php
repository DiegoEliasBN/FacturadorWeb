<?php
/*use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;*/
class ControladorVentas
{
    /*=============================================
    MOSTRAR VENTAS
    =============================================*/
    public static function ctrMostrarVentas($item, $item1, $valor, $valor1)
    {
        $tabla = "ventas";
        $respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $item1, $valor, $valor1);
        return $respuesta;
    }
     public static function ctrMostrarDetalleVenta($item, $valor)
    {
        $tabla = "detalle_venta";
        $respuesta = ModeloVentas::mdlMostrarDetalleVenta($tabla, $item, $valor);
        return $respuesta;
    }
    public static function ctrMostrarVentasFiadas($item, $item1, $valor1)
    {
        $tabla = "ventas";
        $respuesta = ModeloVentas::mdlMostrarVentasFiadas($tabla, $item, $item1, $valor1);
        return $respuesta;
    }
    public static function ctrMostrarFacturaElectronica($item, $valor)
    {
        $tabla = "ventas";
        $respuesta = ModeloVentas::mdlMostrarFacturaElectronica($tabla, $item, $valor);
        return $respuesta;
    }
    public static function ctrMostrarFacturasEmail()
    {
        $tabla = "ventas";
        $respuesta = ModeloVentas::mdlMostrarFacturasEmail($tabla);
        return $respuesta;
    }
    /*=============================================
    CREAR VENTA
    =============================================*/
    public static function ctrCrearVenta($datosAjax)
    {
        /*=============================================
        ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
        =============================================*/
        $listaProductos = json_decode($datosAjax["listaProductos"], true);
        //var_dump($datosAjax["listaProductos"]);
        $totalProductosComprados = array();
        foreach ($listaProductos as $key => $value) {
            array_push($totalProductosComprados, $value["cantidad"]);
            $tablaProductos = "stockalmacen";
            $almacen        = $value["CodAlmacen"];
            $item  = "CodProducto";
            $coda  = "CodAlmacen";
            $valor = $value["id"];
            $traerProducto = ModeloProductos::mdlMostrarStock($tablaProductos, $item, $coda, $valor, $almacen);
            $item1a  = "ventasa";
            $valor1a = $value["cantidad"] + $traerProducto["ventasa"];
            $nuevasVentas = ModeloProductos::mdlActualizarStock($almacen, $tablaProductos, $item1a, $valor1a, $valor);
            $item1b  = "CantidadEgreso";
            $valor1b = $value["cantidad"] + $traerProducto["CantidadEgreso"];
            $nuevoStock = ModeloProductos::mdlActualizarStock($almacen, $tablaProductos, $item1b, $valor1b, $valor);
        }
        $tablaClientes = "clientes";
        $item  = "id";
        $valor = $datosAjax["seleccionarCliente"];
        $traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);
        $item1a  = "compras";
        $valor1a = array_sum($totalProductosComprados) + $traerCliente["compras"];
        $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);
        $item1b = "ultima_compra";
        date_default_timezone_set('America/Guayaquil');
        $fecha   = date('Y-m-d');
        $hora    = date('H:i:s');
        $valor1b = $fecha . ' ' . $hora;
        $fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);
        /*=============================================
        GUARDAR LA COMPRA
        =============================================*/
        $tabla = "ventas";
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
        $datos = array("id_vendedor" => $datosAjax["idVendedor"],
            "id_cliente"                 => $datosAjax["seleccionarCliente"],
            "codigo"                     => $datosAjax["nuevaVenta"],
            "productos"                  => $datosAjax["listaProductos"],
            "impuesto"                   => $datosAjax["nuevoIva"],
            "iva_12"                     => $datosAjax["nuevoIva12"],
            "iva_0"                      => $datosAjax["nuevoIva0"],
            "neto"                       => $datosAjax["totalVenta"],
            "total"                      => $datosAjax["nuevoTotalsito"],
            "totalcompra"                => $datosAjax["nuevoCompra"],
            "saldo"                      => $saldo,
            "metodo_pago"                => $datosAjax["nuevoMetodoPago"],
            "CodAlmacen"                 => $datosAjax["nuevoAlmacen"],
            "CodUTurno"                  => $datosAjax["CodUTurno"],
            "tipo"                       => $datosAjax["Factura"],
            "codigo_df"                  => $codigo_df,
            "fecha"                      => $valor1b);
        //var_dump($datos);
        $respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);
        if ($respuesta["respuesta"] == "ok") {
            $listaDetalle = json_decode($datosAjax["listaProductos"], true);
            //var_dump($_POST["listaProductos"]);
            foreach ($listaDetalle as $key => $value) {
                $tablaDetalle = "detalle_venta";
                $datosDetalle = array("id_factura" => $respuesta["id_factura"],
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
    public static function ctrEliminarVenta()
    {
        if (isset($_GET["idVenta"])) {
            $tabla = "ventas";
            $item   = "id";
            $item1  = "CodAlmacen";
            $valorId  = $_GET["idVenta"];
            $valor1 = $_GET["idAlmacen"];
            //var_dump($item);
            //var_dump($item1);
            //var_dump($valor);
            //var_dump($valor1);
            $traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $item1, $valorId, $valor1);
            //var_dump($traerVenta);
            /*=============================================
            ACTUALIZAR FECHA ÚLTIMA COMPRA
            =============================================*/
            $tablaClientes = "clientes";
            $itemVentas   = null;
            $valorVentas  = null;
            $itemVentas1  = "CodAlmacen";
            $valorVentas1 = $_GET["idAlmacen"];
            $traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $itemVentas1, $valorVentas, $valorVentas1);
            $guardarFechas = array();
            foreach ($traerVentas as $key => $value) {
                if ($value["id_cliente"] == $traerVenta["id_cliente"]) {
                    array_push($guardarFechas, $value["fecha"]);
                }
            }
            if (count($guardarFechas) > 1) {
                if ($traerVenta["fecha"] > $guardarFechas[count($guardarFechas) - 2]) {
                    $item           = "ultima_compra";
                    $valor          = $guardarFechas[count($guardarFechas) - 2];
                    $valorIdCliente = $traerVenta["id_cliente"];
                    $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);
                } else {
                    $item           = "ultima_compra";
                    $valor          = $guardarFechas[count($guardarFechas) - 1];
                    $valorIdCliente = $traerVenta["id_cliente"];
                    $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);
                }
            } else {
                $item           = "ultima_compra";
                $valor          = "0000-00-00 00:00:00";
                $valorIdCliente = $traerVenta["id_cliente"];
                $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);
            }
            /*=============================================
            FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
            =============================================*/
            $item = "id_factura";
            $detalleVenta = ControladorVentas::ctrMostrarDetalleVenta($item, $valorId);
            //$productos = json_decode($traerVenta["productos"], true);
            $totalProductosComprados = array();
            foreach ($detalleVenta as $key => $value) {
                array_push($totalProductosComprados, $value["cantidad"]);
                $tablaProductos = "stockalmacen";
                $item   = "CodProducto";
                $valor  = $value["id"];
                $item1  = "CodAlmacen";
                $valor1 = $_GET["idAlmacen"];
                $traerProducto = ModeloProductos::mdlMostrarStock($tablaProductos, $item, $item1, $valor, $valor1);
                $item1a  = "ventasa";
                $valor1a = $traerProducto["ventasa"] - $value["cantidad"];
                $nuevasVentas = ModeloProductos::mdlActualizarStock($valor1, $tablaProductos, $item1a, $valor1a, $valor);
                $item1b  = "CantidadEgreso";
                $valor1b = $traerProducto["CantidadEgreso"] - $value["cantidad"];
                $nuevoStock = ModeloProductos::mdlActualizarStock($valor1, $tablaProductos, $item1b, $valor1b, $valor);
            }
            $tablaClientes = "clientes";
            $itemCliente  = "id";
            $valorCliente = $traerVenta["id_cliente"];
            $traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);
            $item1a  = "compras";
            $valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);
            $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);
            /*=============================================
            ELIMINAR VENTA
            =============================================*/
            $tablaDetalle = "detalle_venta";
            $eliminiarDetalle=ModeloVentas::mdlEliminarDetalleVenta($tablaDetalle,$valorId);
            $respuesta = ModeloVentas::mdlEliminarVenta($tabla, $_GET["idVenta"]);
            if ($respuesta == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "La venta ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {
								    window.location = "ventas";
								}
							})
				</script>';
            }
        }
    }
    public static function ctrSumaTotalVentas($item1, $valor1)
    {
        $tabla = "ventas";
        $respuesta = ModeloVentas::mdlSumaTotalVentas($tabla, $item1, $valor1);
        return $respuesta;
    }
    public static function ctrEditarStock()
    {
        if (isset($_POST["editarIngreso"])) {
            $tablaProductos = "stockalmacen";
            $item1b         = "CantidadIngreso";
            $valor1b        = $_POST["editarIngreso"];
            $valor1         = $_POST["CodAlmacen"];
            $valor          = $_POST["idproducto"];
            $nuevoStock     = ModeloProductos::mdlActualizarStock($valor1, $tablaProductos, $item1b, $valor1b, $valor);
            if ($nuevoStock == "ok") {
                echo '<script>
					swal({
						  type: "success",
						  title: "El Stock ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
									if (result.value) {
									window.location = "stock";
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
    public static function ctrRangoFechasVentas($fechaInicial, $fechaFinal, $item, $valor)
    {
        $tabla = "ventas";
        $respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal, $item, $valor);
        return $respuesta;
    }
}
