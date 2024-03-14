if (localStorage.getItem("capturarRango") != null) {
    $("#daterange-btn span").html(localStorage.getItem("capturarRango"));
} else {
    $("#daterange-btn span").html('<i class="fa fa-calendar"></i>Rango de fecha');
}
/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/
// $.ajax({
// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){
// 		console.log("respuesta", respuesta);
// 	}
// })
$("#buscadorVenta").focus();
var lista = [];
$(".formularioVenta").on("change", "input.preciotodo", function() {
    console.log('entraste jeje');
    var precioo = $(this).val();
    //$(".nuevoPrecioProducto").attr('precioconiva',$(this).val());
    var precio = $(this).parent().parent().parent().children().children().children(".nuevaCantidadProducto");
    var precio2 = $(this).parent().parent().parent().children().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
    precio2.attr('precioconiva', precioo);
    //console.log("iva", precio2.attr("ivasi"));
    var ivasi = precio2.attr("ivasi");
    var precioFinal = (parseFloat(precio.val()) * parseFloat(precio2.attr("precioconiva"))).toFixed(2);
	var precioSinIvaUnitario = (parseFloat(precio2.attr("precioconiva"))/ 1.12 ).toFixed(2);
    if (ivasi == "S") {
		var precioSinIva = (parseFloat(precioFinal)/1.12);
		var ivavalor = (parseFloat(precioSinIva) * parseFloat(0.12)).toFixed(2);
    } else {
        precio2.attr('precioReal', precioo);
        var ivavalor = 0;
    }
    var ivafinal = (parseFloat(precioFinal) + parseFloat(ivavalor)).toFixed(2);
    //console.log("final",precioFinal);
    //console.log("iva",ivavalor);
    //console.log("ivafinal",ivafinal);
    //console.log("precio",precioFinal);
    precio2.val(precioSinIva);
    precio2.attr("ivavalor", ivavalor);
    precio2.attr("ivafinal", precioFinal);
	$(this).val(precioSinIvaUnitario);
    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios()
    // AGREGAR IMPUESTO
    //agregarImpuesto()
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    lista = listarProductos();
});
$(document).ready(function() {
    $("#buscadorVenta").keypress(function(e) {
        //13 es el código de la tecla
        if (e.which == 13) {
            if ($("#buscadorVenta").val() != "") {
                var edit = "disabled";
                var cliente = $('#idCliente').val();
                var descuento = 0;
                var idProducto = $("#buscadorVenta").val();
                var idAlmacen = $("#inicio").val();
                var datos = new FormData();
                datos.append("idProducto", idProducto);
                datos.append("idAlmacen", idAlmacen);
                $.ajax({
                    url: "ajax/productos2.ajax.php",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(respuesta) {
                        if (respuesta != "") {
                            var ivavalor = 0;
                            var valorcompra = 0;
                            var ivafinal = 0;
                            var descripcion = respuesta["descripcion"];
                            var stock = parseFloat(respuesta["CantidadEgreso"]) + parseFloat(1);
                            var stockn = respuesta["CantidadEgreso"];
                            var precioconiva = respuesta["precio_venta"];
                            var precio = respuesta["precio_siniva"];
                            var precioc = respuesta["precio_compra"];
                            var CodAlmacen = respuesta["CodAlmacen"];
                            var ivasi = respuesta["iva_producto"];
                            //console.log("CodAlmacen",CodAlmacen);
                            var stockF = Number(respuesta["CantidadIngreso"] - respuesta["CantidadEgreso"]);
                            idProducto = respuesta["id"];
                            if (stockF == 0) {
                                swal({
                                    title: "No hay stock disponible",
                                    type: "error",
                                    confirmButtonText: "¡Cerrar!"
                                });
                                return;
                            }
                            $.ajax({
                                url: "ajax/descuento.ajax.php",
                                method: "POST",
                                data: false,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: "json",
                                success: function(respuestaD) {
                                    respuestaD.forEach(funcionForEach1);
                                    function funcionForEach1(item, index) {
                                        if (item.id_cliente == cliente) {
                                            var descuentos = JSON.parse(item.productos);
                                            descuentos.forEach(funcionForEach);
                                            function funcionForEach(item1, index1) {
                                                if (respuesta["id"] == item1.id) {
                                                    descuento = 1;
                                                }
                                            }
                                        }
                                    }
                                    if (descuento == 1) {
                                        edit = "";
                                    }
                                    $("#datosp").append(
                                            '<tr class="nuevoProducto">' +
                                            '<!-- Descripción del producto -->' +
                                            '<td width="45%">' +
                                            '<div class="" style="padding-right:0px">' +
                                            '<div class="input-group">' +
                                            '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' + idProducto + '"><i class="fa fa-times"></i></button></span>' +
                                            '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="' + idProducto + '" name="agregarProducto" value="' + descripcion + '" disabled="true" required>' +
                                            '</div>' +
                                            '</div>' +
                                            '</td>' +
                                            '<!-- Cantidad del producto -->' +
                                            '<td>' +
                                            '<div class="">' +
                                            '<input type="number" class="form-control nuevaCantidadProducto" step="any" id="' + idProducto + '" name="nuevaCantidadProducto" min="0" value="" stock1="' + stockF + '" stock="' + stockn + '" CodAlmacen="' + CodAlmacen + '" nuevoStock="' + stock + '" required>' +
                                            '</div>' +
                                            '</td>' +
                                            '<!-- precio -->' +
                                            '<td>' +
                                            '<div class="input-group">' +
                                            '<input type="text" class="form-control preciotodo" value="' + precio + '" ' + edit + '>' +
                                            '</div>' +
                                            '</td>' +
                                            '<!-- Precio del producto -->' +
                                            '<td>' +
                                            '<div class=" ingresoPrecio" style="padding-left:0px">' +
                                            '<div class="input-group">' +
                                            '<input type="text" class="form-control nuevoPrecioProducto" id="id' + idProducto + '" valorcompra="' + valorcompra + '" ivavalor="' + ivavalor + '" ivafinal="' + ivafinal + '" ivasi="' + ivasi + '"  precioReal="' + precio + '" precioc="' + precioc + '" precioconiva="' + precioconiva + '" name="nuevoPrecioProducto" value="0.00" disabled="true" required>' +
                                            '</div>' +
                                            '</div>' +
                                            '</td>' +
                                            '</tr>'
                                        )
                                        // SUMAR TOTAL DE PRECIOS
                                    sumarTotalPrecios()
                                    // AGREGAR IMPUESTO
                                    //agregarImpuesto()
                                    // AGRUPAR PRODUCTOS EN FORMATO JSON
                                    $('.nuevaCantidadProducto').focus();
                                    lista = listarProductos();
                                    // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
                                    $(".nuevoPrecioProducto").number(true, 2);
                                    $(".preciotodo").number(true, 2);
                                    $("#buscadorPrecio").val(precioconiva);
                                    $("#buscadorPrecio").number(true, 2);
                                    $("#agregarVenta").prop('disabled', false);
                                }
                            })
                        } else {
                            swal({
                                type: "error",
                                title: "El Producto no fue encontrado",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            })
                        }
                    }
                })
            }
        }
    });
});
/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/
var idQuitarProducto = [];
localStorage.removeItem("quitarProducto");
$(".formularioVenta").on("click", "button.quitarProducto", function() {
    $(this).parent().parent().parent().parent().parent().remove();
    var idProducto = $(this).attr("idProducto");
    /*=============================================
    ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
    =============================================*/
    if (localStorage.getItem("quitarProducto") == null) {
        idQuitarProducto = [];
    } else {
        idQuitarProducto.concat(localStorage.getItem("quitarProducto"))
    }
    idQuitarProducto.push({ "idProducto": idProducto });
    localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));
    //$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');
    //$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');
    if ($(".nuevoProducto").children().length == 0) {
        $("#nuevoImpuestoVenta").val(0);
        $("#nuevoTotalVenta").val(0);
        $("#SubTotal").val(0);
		$("#subtotal12iva").val(0);
        $("#nuevoImpuestoVentas").val(0);
        $("#totalVenta").val(0);
        $("#nuevoTotalsito").val("");
        $("#nuevoTotalVenta").attr("total", 0);
        lista = "";
        $("#agregarVenta").prop('disabled', true);
    } else {
        // SUMAR TOTAL DE PRECIOS
        sumarTotalPrecios()
        // AGREGAR IMPUESTO
        //agregarImpuesto()
        // AGRUPAR PRODUCTOS EN FORMATO JSON
        lista = listarProductos();
    }
})
$(document).ready(function() {
    // $(document).keypress(function(e) {
    //13 es el código de la tecla
    // if(e.which == 88) {
    //console.log("hola mundo cabron");
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.which === 67) {
            $("#nuevoMetodoPagos").parent().parent().removeClass("col-xs-8");
            $("#nuevoMetodoPagos").parent().parent().addClass("col-xs-12");
            $("#nuevoMetodoPagos").val("Efectivo");
            $("#nuevoMetodoPagos").parent().parent().parent().children(".cajasMetodoPago").html(
                '<div class="col-xs-6">' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                '<input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control" id="nuevoValorEfectivo" placeholder="000000" >' +
                '</div>' +
                '</div>' +
                '<div class="col-xs-6" id="capturarCambioEfectivo" style="padding-left:0px">' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                '<input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly >' +
                '</div>' +
                '</div>'
            )
            $("#nuevoValorEfectivo").focus();
        }
    });
    //$(document).keypress(function(e) {
    //13 es el código de la tecla
    //if(e.which == 90) {
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.which === 88) {
            $("#buscadorVenta").val('');
            $("#buscadorVenta").focus();
        }
    });
});
$(".formularioVenta").on("change", "input.nuevaCantidadProducto", function() {
    //console.log("entraste aqui");
    var precio = $(this).parent().parent().parent().children().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
    //console.log("iva",precio.attr("ivasi"));
    var ivasi = precio.attr("ivasi");
    //var preciocompra=precio.attr("precioc");
    preciocompra = (parseFloat($(this).val()) * parseFloat(precio.attr("precioc"))).toFixed(2);
    //var precioFinal = (parseFloat($(this).val()) *parseFloat(precio.attr("precioconiva"))).toFixed(2); 
    if (ivasi == "S") {
        var precioFinal = (parseFloat($(this).val()) * parseFloat(precio.attr("precioconiva"))).toFixed(2);
        precioFinal = precioFinal / 1.12;
        var ivavalor = (parseFloat(precioFinal) * parseFloat(0.12)).toFixed(2);
        precioFinal = precioFinal.toFixed(2);
    } else {
        var precioFinal = (parseFloat($(this).val()) * parseFloat(precio.attr("precioReal"))).toFixed(2);
        var ivavalor = 0;
    }
    var ivafinal = (parseFloat(precioFinal) + parseFloat(ivavalor)).toFixed(2);
    //console.log("sumaaaa",preciocompra);
    //console.log("iva",ivavalor);
    //console.log("ivafinal",ivafinal);
    //console.log("precio",precioFinal);
    precio.val(precioFinal);
    precio.attr("ivavalor", ivavalor);
    precio.attr("ivafinal", ivafinal);
    precio.attr("valorcompra", preciocompra);
    var nuevoStock = Number($(this).attr("stock")) + Number($(this).val());
    $(this).attr("nuevoStock", nuevoStock);
    if (Number($(this).val()) > Number($(this).attr("stock1"))) {
        /*=============================================
        SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
        =============================================*/
        $(this).val('');
        var precioFinal = $(this).val() * precio.attr("ivafinal");
        precio.val(precioFinal);
        precio.attr("ivavalor", '');
        precio.attr("ivafinal", '');
        $(this).focus();
        sumarTotalPrecios();
        swal({
            title: "La cantidad supera el Stock",
            text: "¡Sólo hay " + $(this).attr("stock1") + " unidades!",
            allowOutsideClick: false,
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });
        return;
    }
    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios()
    // AGREGAR IMPUESTO
    //agregarImpuesto()
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    lista = listarProductos();
})
/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/
function sumarTotalPrecios() {
    var precioItem = $(".nuevoPrecioProducto");
    var arraySumaPrecio = [];
    var arraySumaPrecioF = [];
    var arraySumaIva = [];
    var arraySumaCompra = [];
    var arraySuma12 = [];
    var arraySuma0 = [];
    for (var i = 0; i < precioItem.length; i++) {
        if ($(precioItem[i]).attr("ivasi") == "S") {
            arraySuma12.push(Number($(precioItem[i]).val()));
        } else {
            arraySuma0.push(Number($(precioItem[i]).val()));
        }
        arraySumaPrecio.push(Number($(precioItem[i]).val()));
        arraySumaIva.push(Number($(precioItem[i]).attr("ivavalor")));
        arraySumaPrecioF.push(Number($(precioItem[i]).attr("ivafinal")));
        arraySumaCompra.push(Number($(precioItem[i]).attr("valorcompra")));
    }
    function sumaArrayPrecios(total, numero) {
        return total + numero;
    }
    var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
    var sumaTotalPrecioF = arraySumaPrecioF.reduce(sumaArrayPrecios);
    var sumaTotalIva = arraySumaIva.reduce(sumaArrayPrecios);
    var sumaTotalCompra = arraySumaCompra.reduce(sumaArrayPrecios);
    if (arraySuma12.length > 0) {
        var sumaTotalIva12 = arraySuma12.reduce(sumaArrayPrecios);
    } else {
        var sumaTotalIva12 = 0;
    }
    if (arraySuma0.length > 0) {
        var sumaTotalIva0 = arraySuma0.reduce(sumaArrayPrecios);
    } else {
        var sumaTotalIva0 = 0;
    }
    var subiva = sumaTotalIva + sumaTotalIva12;
    $("#nuevoTotalVenta").val(sumaTotalPrecio);
    $("#nuevoImpuestoVentas").val(sumaTotalIva.toFixed(2));
    $("#nuevoIva12").val(sumaTotalIva12.toFixed(2));
    $("#subtotal12").val(sumaTotalIva12.toFixed(2));
    $("#nuevoIva0").val(sumaTotalIva0.toFixed(2));
    $("#subtotal12iva").val(subiva.toFixed(2));
    $("#subtotal0").val(sumaTotalIva0.toFixed(2));
    $("#nuevoIva").val(sumaTotalIva.toFixed(2));
    $("#SubTotal").val(sumaTotalPrecioF.toFixed(2));
    $("#nuevoTotalsito").val(sumaTotalPrecioF.toFixed(2));
    $("#totalVenta").val(sumaTotalPrecio);
    $("#totalCompra").val(sumaTotalCompra.toFixed(2));
    $("#nuevoTotalVenta").attr("total", sumaTotalPrecio);
}
$("#nuevoTotalVenta").number(true, 2);
$("#SubTotal").number(true, 2);
$("#subtotal12iva").number(true, 2);
$("#nuevoImpuestoVentas").number(true, 2);
/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/
$("#nuevoMetodoPagos").change(function() {
        var metodo = $(this).val();
        if (metodo == "Efectivo") {
            $(this).parent().parent().removeClass("col-xs-8");
            $(this).parent().parent().addClass("col-xs-12");
            $(this).parent().parent().parent().children(".cajasMetodoPago").html(
                '<div class="col-xs-6">' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                '<input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control"  id="nuevoValorEfectivo" placeholder="000000" >' +
                '</div>' +
                '</div>' +
                '<div class="col-xs-6" id="capturarCambioEfectivo">' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                '<input type="text" style="font-size: 30px; color:#DF2B2B" class="form-control" id="nuevoCambioEfectivo" style="font-size: 28px; color:#DF2B2B" placeholder="000000" readonly >' +
                '</div>' +
                '</div>'
            )
            // Agregar formato al precio
            $('#nuevoValorEfectivo').number(true, 2);
            $('#nuevoCambioEfectivo').number(true, 2);
        } else if (metodo == "TC") {
            $(this).parent().parent().removeClass('col-xs-8');
            $(this).parent().parent().addClass('col-xs-12');
            $(this).parent().parent().parent().children('.cajasMetodoPago').html(
                '<div class="col-xs-8">' +
                '<div class="input-group">' +
                '<input type="number" min="0" class="form-control" name="nuevoCodigoTransaccion" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>' +
                '<span class="input-group-addon"><i class="fa fa-lock"></i></span>' +
                '</div>' +
                '</div>')
        } else if (metodo == "TD") {
            $(this).parent().parent().removeClass('col-xs-8');
            $(this).parent().parent().addClass('col-xs-12');
            $(this).parent().parent().parent().children('.cajasMetodoPago').html(
                '<div class="col-xs-8">' +
                '<div class="input-group">' +
                '<input type="number" min="0" class="form-control" name="nuevoCodigoTransaccion" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>' +
                '<span class="input-group-addon"><i class="fa fa-lock"></i></span>' +
                '</div>' +
                '</div>')
        } else {
            $(this).parent().parent().removeClass('col-xs-4');
            $(this).parent().parent().addClass('col-xs-8');
            $(this).parent().parent().parent().children('.cajasMetodoPago').html(
                '<div class="col-xs-6" style="padding-left:0px">' + '</div>'
            )
        }
    })
    /*=============================================
    CAMBIO EN EFECTIVO
    =============================================*/
$(".formularioVenta").on("change", "input#nuevoValorEfectivo", function() {
    var efectivo = $(this).val();
    var cambio = Number(efectivo) - Number($('#nuevoTotalsito').val());
    var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');
    nuevoCambioEfectivo.val(cambio.toFixed(2));
})
/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/
function listarProductos() {
    var listaProductos = [];
    var descripcion = $(".nuevaDescripcionProducto");
    var cantidad = $(".nuevaCantidadProducto");
    var precio = $(".nuevoPrecioProducto");
    for (var i = 0; i < descripcion.length; i++) {
        listaProductos.push({
            "id": $(descripcion[i]).attr("idProducto"),
            "descripcion": $(descripcion[i]).val(),
            "cantidad": $(cantidad[i]).val(),
            "stock": $(cantidad[i]).attr("nuevoStock"),
            "precio": $(precio[i]).attr("precioReal"),
            "precioconiva": $(precio[i]).attr("precioconiva"),
            "precioc": $(precio[i]).attr("precioc"),
            "ivavalor": $(precio[i]).attr("ivavalor"),
            "ivafinal": $(precio[i]).attr("ivafinal"),
            "CodAlmacen": $(cantidad[i]).attr("CodAlmacen"),
            "totalcompra": $(precio[i]).attr("valorcompra"),
            "ivasi": $(precio[i]).attr("ivasi"),
            "total": $(precio[i]).val()
        })
    }
    $("#listaProductos").val(JSON.stringify(listaProductos));
    return listaProductos;
}
/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEditarVenta", function() {
    var idVenta = $(this).attr("idVenta");
    window.location = "index.php?ruta=editar-venta&idVenta=" + idVenta;
})
/*=============================================
BORRAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEliminarVenta", function() {
    var idVenta = $(this).attr("idVenta");
    var idAlmacen = $(this).attr("idAlmacen");
    swal({
        title: '¿Está seguro de borrar la venta?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar venta!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=ventas&idVenta=" + idVenta + "&idAlmacen=" + idAlmacen;
        }
    })
})
/*=============================================
IMPRIMIR FACTURA
=============================================*/
$(".tablas").on("click", ".btnAutorizarFactura", function() {
    var id = $(this).attr("idVenta");
    window.open(window.location.origin + "sricron.php" + id, "_self");
})
$(".tablas").on("click", ".btnImprimirFactura", function() {
    var codigoVenta = $(this).attr("codigoVenta");
    var idAlmacen = $(this).attr("idAlmacen");
    window.open("extenciones/tcpdf/pdf/factura.php?codigo=" + codigoVenta + "&idAlmacen=" + idAlmacen, "_blank");
    //window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
$(".tablas").on("click", ".btnImprimirFactura-carta", function() {
    var claveacceso = $(this).attr('codAcceso');
    //window.open("http://sistema.santanacangrejal.com/?ruta=sri&ride=" + claveacceso, "_blank");
	window.open(window.location.origin + "?ruta=sri&ride=" + claveacceso, "_blank");
    //window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
/*=============================================
RANGO DE FECHAS
=============================================*/
$('#daterange-btn').daterangepicker({
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate: moment()
    },
    function(start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var fechaInicial = start.format('YYYY-MM-DD');
        var fechaFinal = end.format('YYYY-MM-DD');
        var capturarRango = $("#daterange-btn span").html();
        localStorage.setItem("capturarRango", capturarRango);
        window.location = "index.php?ruta=ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
    }
)
/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/
$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function() {
    localStorage.removeItem("capturarRango");
    localStorage.clear();
    window.location = "ventas";
})
/*=============================================
CAPTURAR HOY
=============================================*/
$(".daterangepicker.opensleft .ranges li").on("click", function() {
    var textoHoy = $(this).attr("data-range-key");
    if (textoHoy == "Hoy") {
        var d = new Date();
        var dia = d.getDate();
        var mes = d.getMonth() + 1;
        var año = d.getFullYear();
        dia = ("0" + dia).slice(-2);
        mes = ("0" + mes).slice(-2);
        var fechaInicial = año + "-" + mes + "-" + dia;
        var fechaFinal = año + "-" + mes + "-" + dia;
        localStorage.setItem("capturarRango", "Hoy");
        window.location = "index.php?ruta=ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
    }
})
$(document).ready(function() {
    if ($('#seleccionarCliente').val() == '') {
        $.ajax({
            url: "ajax/clientesselect.ajax.php",
            method: "POST",
            data: false,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                console.log(respuesta);
                $("#nombreCliente").val(respuesta[0][1]);
                $("#idCliente").val(respuesta[0][0]);
                $("#direccionCliente").val(respuesta[0][5]);
                $("#seleccionarCliente").val(respuesta[0][2]);
                $("#editarClienteFactura").attr('idCliente', respuesta[0][0]);
                $("#tipo_documento > option[value='" + respuesta[0][9] + "']").attr("selected", true);
                $("#emailCliente").val(respuesta[0][3]);
            }
        })
    }
});
//buscar cliente por documento
$('#seleccionarCliente').keypress(function(e) {
    if (e.which == 13) {
        if ($("#seleccionarCliente").val() != "") {
            //console.log("hola como estas ");
            var documento = $(this).val();
            var datos = new FormData();
            datos.append("cedula", documento);
            $.ajax({
                url: "ajax/clientes.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta) {
                    //console.log("respuesta",respuesta);
                    if (respuesta != "") {
                        $("#editarClienteFactura").prop('disabled', false);
                        $("#agregarclienteFactura").prop('disabled', true);
                        $("#editarClienteFactura").attr('idCliente', respuesta["id"]);
                        $("#nombreCliente").val(respuesta["nombre"]);
                        $("#idCliente").val(respuesta["id"]);
                        $("#direccionCliente").val(respuesta["direccion"]);
                        $("#seleccionarCliente").focus();
                        $("#agregarVenta").prop('disabled', false);
                        $("#nombreCliente").prop('disabled', true);
                        $("#direccionCliente").prop('disabled', true);
                        $("#tipo_documento > option[value='" + respuesta["tipo_documento"] + "']").attr("selected", true);
                        $("#tipo_documento").prop('disabled', true);
                        $("#emailCliente").prop('disabled', true);
                        $("#emailCliente").val(respuesta["email"]);
                    } else {
                        $("#nombreCliente").prop('disabled', false);
                        $("#direccionCliente").prop('disabled', false);
                        $("#editarClienteFactura").prop('disabled', true);
                        $("#agregarclienteFactura").prop('disabled', false);
                        $("#editarClienteFactura").attr('idCliente', '');
                        $("#nombreCliente").val('');
                        $("#idCliente").val('');
                        $("#direccionCliente").val('');
                        $("#tipo_documento > option[value='']").attr("selected", true);
                        $("#seleccionarCliente").focus();
                        $("#tipo_documento").prop('disabled', false);
                        $("#emailCliente").prop('disabled', false);
                        $("#emailCliente").val('');
                        swal({
                            title: "El cliente no existe",
                            allowOutsideClick: false,
                            type: "error",
                            confirmButtonText: "¡Cerrar!"
                        });
                    }
                }
            })
        } else {
            $("#nombreCliente").val('');
            $("#idCliente").val('');
            $("#direccionCliente").val('');
            $("#emailCliente").val('');
            $("#seleccionarCliente").focus();
            $("#editarClienteFactura").prop('disabled', true);
            $("#editarClienteFactura").attr('idCliente', '');
            $("#nombreCliente").prop('disabled', false);
            $("#direccionCliente").prop('disabled', false);
            $("#tipo_documento").prop('disabled', false);
            $("#emailCliente").prop('disabled', false);
            $("#tipo_documento > option[value='']").attr("selected", true);
            swal({
                title: "Ingrese el numero de documento",
                allowOutsideClick: false,
                type: "error",
                confirmButtonText: "¡Cerrar!"
            });
        }
    }
});
$('#seleccionarCliente').focus(function() {
    $(this).select();
});
$('#nombreCliente').focus(function() {
    $(this).select();
});
//agregar venta 
$("#agregarVenta").on("click", function() {
    $("#agregarVenta").prop('disabled', true);
    var validacion = "ok";
    var codigo = $("#nuevaVenta").val();
    var nuevoAlmacen = $("#inicio").val();
    var idVendedor = $("#idVendedor").val();
    var CodUTurno = $("#CodUTurno").val();
    var listaProductos = $("#listaProductos").val();
    var Factura = $("#Factura").val();
    var seleccionarCliente = $("#idCliente").val();
    var nuevoIva = $("#nuevoIva").val();
    var nuevoIva12 = $("#nuevoIva12").val();
    var nuevoIva0 = $("#nuevoIva0").val();
    var totalVenta = $("#totalVenta").val();
    var nuevoTotalsito = $("#nuevoTotalsito").val();
    var totalCompra = $("#totalCompra").val();
    var nuevoMetodoPago = $("#nuevoMetodoPagos").val();
    var codigo_df = $("#nuevoCodigoTransaccion").val();
    var datos = new FormData();
    datos.append("nuevaVenta", codigo);
    datos.append("nuevoAlmacen", nuevoAlmacen);
    datos.append("idVendedor", idVendedor);
    datos.append("CodUTurno", CodUTurno);
    datos.append("listaProductos", listaProductos);
    datos.append("Factura", Factura);
    datos.append("seleccionarCliente", seleccionarCliente);
    datos.append("nuevoIva", nuevoIva);
    datos.append("nuevoIva12", nuevoIva12);
    datos.append("nuevoIva0", nuevoIva0);
    datos.append("totalVenta", totalVenta);
    datos.append("nuevoTotalsito", nuevoTotalsito);
    datos.append("totalCompra", totalCompra);
    datos.append("nuevoMetodoPago", nuevoMetodoPago);
    datos.append("codigo_df", codigo_df);
    if (codigo != "" && nuevoAlmacen != "" && idVendedor != "" &&
        CodUTurno != "" && listaProductos != "" && Factura != "" &&
        seleccionarCliente != "" && nuevoIva != "" && nuevoIva12 != "" &&
        nuevoIva0 != "" && totalVenta != "" && nuevoTotalsito != "" &&
        totalCompra != "" && nuevoMetodoPago != "") {
        var listaProductosValidar = JSON.parse(listaProductos);
        listaProductosValidar.forEach(funcionForEach);
        function funcionForEach(item, index) {
            if (item["cantidad"] == "" || item["cantidad"] == 0) {
                validacion = "error";
                swal({
                    type: "error",
                    title: "UN CAMPO DEL DETLLE ESTA VACIO O EL VALOR EN 0.00",
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                })
            }
        }
        if (nuevoMetodoPago == "TC" || nuevoMetodoPago == "TD") {
            if (codigo_df == "") {
                validacion = "error";
                swal({
                    type: "error",
                    title: "¡El codigo de la transaccion esta vacio!",
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                })
            }
        }
        if (validacion == "error") {
            $("#agregarVenta").prop('disabled', false);
            return false;
        }
        $.ajax({
            url: "ajax/ventas.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                if (respuesta["respuesta"] == "ok") {
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
                            window.open("extenciones/tcpdf/pdf/factura.php?codigo=" + respuesta['id_factura'] + "&idAlmacen=" + nuevoAlmacen, "_blank");
                            window.location = "crear-venta";
                        } else {
                            window.open("extenciones/tcpdf/pdf/factura.php?codigo=" + respuesta['id_factura'] + "&idAlmacen=" + nuevoAlmacen, "_blank");
                            window.location = "crear-venta";
                        }
                    })
                } else {
                    $("#agregarVenta").prop('disabled', false);
                    swal({
                        type: "error",
                        title: "La venta no se ha guardado",
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then((result) => {
                        if (result.value) {
                            window.location = "crear-venta";
                        }
                    })
                }
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        })
    } else {
        $("#agregarVenta").prop('disabled', false);
        swal({
            type: "error",
            title: "¡LA FACTURA NO ESTA LISTA UNO O VARIOS CAMPOS ESTAS VACIOS!",
            allowOutsideClick: false,
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        })
    }
});
//agregar cliente
$("#agregarclienteFactura").on("click", function() {
    $("#agregarclienteFactura").prop('disabled', true);
    var documento = $("#seleccionarCliente").val();
    var nombreCliente = $("#nombreCliente").val();
    var direccionCliente = $("#direccionCliente").val();
    var tipo_documento = $("#tipo_documento").val();
    var emailCliente = $("#emailCliente").val();
    var datos = new FormData();
    datos.append("nuevoDocumentoId", documento);
    datos.append("nuevoCliente", nombreCliente);
    datos.append("nuevaDireccion", direccionCliente);
    datos.append("tipo_documento", tipo_documento);
    datos.append("emailCliente", emailCliente);
    if (documento != "" && nombreCliente != "" && direccionCliente && tipo_documento != "") {
        $.ajax({
            url: "ajax/clientes.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                console.log(respuesta);
                if (respuesta["respuesta"] == "ok") {
                    $("#editarClienteFactura").attr('idCliente', respuesta["id_cliente"]);
                    $("#idCliente").val(respuesta["id_cliente"]);
                    $("#editarClienteFactura").prop('disabled', false);
                    swal({
                        type: "success",
                        title: "El cliente ha sido guardado correctamente",
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                    })
                } else if (respuesta["respuesta"] == "errorValidacion") {
                    $("#agregarclienteFactura").prop('disabled', false);
                    swal({
                        type: "error",
                        title: "El documento del cliente no es valido!",
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    })
                } else {
                    $("#agregarclienteFactura").prop('disabled', false);
                    swal({
                        type: "error",
                        title: "El cliente no se ha guardado",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    })
                }
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        })
    } else {
        $("#agregarclienteFactura").prop('disabled', false);
        swal({
            type: "error",
            title: "¡Existen campos vacios, no se puede agregar el cliente!",
            allowOutsideClick: false,
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        })
    }
});
//editar la venta
$("#btnEditarVenta").on("click", function() {
    $("#btnEditarVenta").prop('disabled', true);
    var validacion = "ok";
    var idVendedor = $("#idVendedor").val();
    var editarVenta = $("#nuevaVenta").val();
    var nuevoAlmacen = $("#inicio").val();
    var CodUTurno = $("#CodUTurno").val();
    var listaProductos = $("#listaProductos").val();
    var Factura = $("#Factura").val();
    var seleccionarCliente = $("#idCliente").val();
    var nuevoIva = $("#nuevoIva").val();
    var nuevoIva12 = $("#nuevoIva12").val();
    var nuevoIva0 = $("#nuevoIva0").val();
    var totalVenta = $("#totalVenta").val();
    var nuevoTotalsito = $("#nuevoTotalsito").val();
    var totalCompra = $("#totalCompra").val();
    var nuevoMetodoPago = $("#nuevoMetodoPagos").val();
    var codigo_df = $("#nuevoCodigoTransaccion").val();
    var datos = new FormData();
    datos.append("idVendedor", idVendedor);
    datos.append("editarVenta", editarVenta);
    datos.append("CodUTurno", CodUTurno);
    datos.append("CodAlmacen", nuevoAlmacen);
    datos.append("listaProductos", listaProductos);
    datos.append("editarFactura", Factura);
    datos.append("seleccionarCliente", seleccionarCliente);
    datos.append("nuevoIva", nuevoIva);
    datos.append("nuevoIva12", nuevoIva12);
    datos.append("nuevoIva0", nuevoIva0);
    datos.append("totalVenta", totalVenta);
    datos.append("nuevoTotalsito", nuevoTotalsito);
    datos.append("totalCompra", totalCompra);
    datos.append("nuevoMetodoPago", nuevoMetodoPago);
    datos.append("codigo_df", codigo_df);
    if (idVendedor != "" &&
        CodUTurno != "" && Factura != "" &&
        seleccionarCliente != "" && nuevoIva != "" && nuevoIva12 != "" &&
        nuevoIva0 != "" && totalVenta != "" && nuevoTotalsito != "" &&
        totalCompra != "" && nuevoMetodoPago != "") {
        if (listaProductos != "") {
            var listaProductosValidar = JSON.parse(listaProductos);
            listaProductosValidar.forEach(funcionForEach);
            function funcionForEach(item, index) {
                if (item["cantidad"] == "" || item["cantidad"] == 0) {
                    validacion = "error";
                    swal({
                        type: "error",
                        title: "UN CAMPO DEL DETLLE ESTA VACIO O EL VALOR EN 0.00",
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    })
                }
            }
        }
        if (nuevoMetodoPago == "TC" || nuevoMetodoPago == "TD") {
            if (codigo_df == "") {
                validacion = "error";
                swal({
                    type: "error",
                    title: "¡El codigo de la transaccion esta vacio!",
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                })
            }
        }
        if (validacion == "error") {
            $("#btnEditarVenta").prop('disabled', false);
            return false;
        }
        $.ajax({
            url: "ajax/ventas.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                if (respuesta == "ok") {
                    localStorage.removeItem("rango");
                    swal({
                        type: "success",
                        title: "La venta ha sido editada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then((result) => {
                        if (result.value) {
                            window.location = "ventas";
                        }
                    })
                } else {
                    $("#agregarVenta").prop('disabled', false);
                    swal({
                        type: "error",
                        title: "La venta no se ha editado",
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then((result) => {
                        if (result.value) {
                            window.location = "crear-venta";
                        }
                    })
                }
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        })
    } else {
        $("#btnEditarVenta").prop('disabled', false);
        swal({
            type: "error",
            title: "¡LA FACTURA NO ESTA LISTA UNO O VARIOS CAMPOS ESTAS VACIOS!",
            allowOutsideClick: false,
            allowOutsideClick: false,
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        })
    }
});
//buscar producto por nombre
$(document).ready(function() {
    var CodAlmacen = $("#inicio").val();
    var cliente = $('#idCliente').val();
    var descuento = 0;
    $('#buscadorVenta').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "ajax/ventas.ajax.php",
                dataType: "json",
                data: { descripcion: request.term, CodAlmacen: CodAlmacen },
                success: function(data) {
                    response($.each(data, function(item, i) {
                        //console.log("esto es",i);
                        return {
                            value: i.value,
                            nombre: i.nombre
                        }
                    }));
                },
                error: function(request, status, error) {
                    console.log(request.responseText);
                }
            });
        },
        minLength: 4,
        select: function(event, ui) {
            var edit = "disabled";
            var cliente = $('#idCliente').val();
            var descuento = 0;
            var nombre = ui.item.nombre;
            var idAlmacen = $("#inicio").val();
            var datos = new FormData();
            datos.append("nombreProducto", nombre);
            datos.append("idAlmacen", idAlmacen);
            $.ajax({
                url: "ajax/productos2.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta) {
                    if (respuesta != "") {
                        var ivavalor = 0;
                        var valorcompra = 0;
                        var ivafinal = 0;
                        var descripcion = respuesta["descripcion"];
                        var stock = parseFloat(respuesta["CantidadEgreso"]) + parseFloat(1);
                        var stockn = respuesta["CantidadEgreso"];
                        var precioconiva = respuesta["precio_venta"];
                        var precio = respuesta["precio_siniva"];
                        var precioc = respuesta["precio_compra"];
                        var CodAlmacen = respuesta["CodAlmacen"];
                        var ivasi = respuesta["iva_producto"];
                        //console.log("CodAlmacen",CodAlmacen);
                        var stockF = Number(respuesta["CantidadIngreso"] - respuesta["CantidadEgreso"]);
                        var idProducto = respuesta["id"];
                        if (stockF == 0) {
                            swal({
                                title: "No hay stock disponible",
                                type: "error",
                                confirmButtonText: "¡Cerrar!"
                            });
                            return;
                        }
                        $.ajax({
                            url: "ajax/descuento.ajax.php",
                            method: "POST",
                            data: false,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            success: function(respuestaD) {
                                respuestaD.forEach(funcionForEach1);
                                function funcionForEach1(item, index) {
                                    if (item.id_cliente == cliente) {
                                        var descuentos = JSON.parse(item.productos);
                                        descuentos.forEach(funcionForEach);
                                        function funcionForEach(item1, index1) {
                                            if (respuesta["id"] == item1.id) {
                                                descuento = 1;
                                            }
                                        }
                                    }
                                }
                                if (descuento == 1) {
                                    edit = "";
                                }
                                $("#datosp").append(
                                        '<tr class="nuevoProducto">' +
                                        '<!-- Descripción del producto -->' +
                                        '<td width="45%">' +
                                        '<div class="" style="padding-right:0px">' +
                                        '<div class="input-group">' +
                                        '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' + idProducto + '"><i class="fa fa-times"></i></button></span>' +
                                        '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="' + idProducto + '" name="agregarProducto" value="' + descripcion + '" readonly required>' +
                                        '</div>' +
                                        '</div>' +
                                        '</td>' +
                                        '<!-- Cantidad del producto -->' +
                                        '<td>' +
                                        '<div class="">' +
                                        '<input type="number" class="form-control nuevaCantidadProducto" step="any" id="' + idProducto + '" name="nuevaCantidadProducto" min="0" value="" stock1="' + stockF + '" stock="' + stockn + '" CodAlmacen="' + CodAlmacen + '" nuevoStock="' + stock + '" required>' +
                                        '</div>' +
                                        '</td>' +
                                        '<!-- precio -->' +
                                        '<td>' +
                                        '<div class="input-group">' +
                                        '<input type="text" class="form-control preciotodo" value="' + precio + '" ' + edit + '>' +
                                        '</div>' +
                                        '</td>' +
                                        '<!-- Precio del producto -->' +
                                        '<td>' +
                                        '<div class=" ingresoPrecio" style="padding-left:0px">' +
                                        '<div class="input-group">' +
                                        '<input type="text" class="form-control nuevoPrecioProducto" id="id' + idProducto + '" valorcompra="' + valorcompra + '" ivavalor="' + ivavalor + '" ivafinal="' + ivafinal + '" ivasi="' + ivasi + '"  precioReal="' + precio + '" precioc="' + precioc + '" precioconiva="' + precioconiva + '" name="nuevoPrecioProducto" value="0.00" readonly required>' +
                                        '</div>' +
                                        '</div>' +
                                        '</td>' +
                                        '</tr>'
                                    )
                                    // SUMAR TOTAL DE PRECIOS
                                sumarTotalPrecios()
                                // AGREGAR IMPUESTO
                                //agregarImpuesto()
                                // AGRUPAR PRODUCTOS EN FORMATO JSON
                                $('.nuevaCantidadProducto').focus();
                                lista = listarProductos();
                                // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
                                $(".nuevoPrecioProducto").number(true, 2);
                                $(".preciotodo").number(true, 2);
                                $("#buscadorPrecio").html(precioconiva);
                                $("#buscadorPrecio").number(true, 2);
                                $("#agregarVenta").prop('disabled', false);
                            }
                        })
                    } else {
                        swal({
                            type: "error",
                            title: "El Producto no fue encontrado",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        })
                    }
                }
            })
        }
    });
    $('#nombreCliente').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "ajax/clientes.ajax.php",
                dataType: "json",
                data: { nombreClientes: request.term },
                success: function(data) {
                    response($.each(data, function(item, i) {
                        //console.log("esto es",i);
                        return {
                            id: i.id,
                            value: i.nombre,
                            direccion: i.direccion,
                            documento: i.documento,
                            email: i.email,
                            tipo_documento: i.tipo_documento,
                        }
                    }));
                },
                error: function(request, status, error) {
                    alert(request.responseText);
                }
            });
        },
        minLength: 4,
        select: function(event, ui) {
            $("#editarClienteFactura").prop('disabled', false);
            $("#agregarclienteFactura").prop('disabled', true);
            $("#nombreCliente").val(ui.item.value);
            $("#idCliente").val(ui.item.id);
            $("#direccionCliente").val(ui.item.direccion);
            $("#seleccionarCliente").val(ui.item.documento);
            $("#editarClienteFactura").attr('idCliente', ui.item.id);
            $("#agregarVenta").prop('disabled', false);
            $("#nombreCliente").prop('disabled', true);
            $("#direccionCliente").prop('disabled', true);
            $("#tipo_documento > option[value='" + ui.item.tipo_documento + "']").attr("selected", true);
            $("#tipo_documento").prop('disabled', true);
            $("#emailCliente").prop('disabled', true);
            $("#emailCliente").val(ui.item.email);
        }
    });
});
$('#seleccionarCliente').on('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});
$('#buscadorVenta').focus(function() {
    $(this).select();
});
$("#editarClienteFacturaM").on("click", function() {
    //$("#agregarVenta").prop('disabled', true);
    var idCliente = $("#idCliente").val();
    var editarCliente = $("#editarCliente").val();
    var editarDocumentoId = $("#editarDocumentoId").val();
    var editarEmail = $("#editarEmail").val();
    var editarTelefono = $("#editarTelefono").val();
    var editarDireccion = $("#editarDireccion").val();
    var editarFechaNacimiento = $("#editarFechaNacimiento").val();
    var tipo_documento = $("#edita_tipo_documento").val();
    var datos = new FormData();
    datos.append("idClienteFactura", idCliente);
    datos.append("editarCliente", editarCliente);
    datos.append("editarDocumentoId", editarDocumentoId);
    datos.append("editarEmail", editarEmail);
    datos.append("editarTelefono", editarTelefono);
    datos.append("editarDireccion", editarDireccion);
    datos.append("editarFechaNacimiento", editarFechaNacimiento);
    datos.append("tipo_documento", tipo_documento);
    if (editarDocumentoId != "" && editarCliente != "" && editarDireccion) {
        $.ajax({
            url: "ajax/clientes.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                if (respuesta == "ok") {
                    $("#nombreCliente").val(editarCliente);
                    $("#direccionCliente").val(editarDireccion);
                    $("#seleccionarCliente").val(editarDocumentoId);
                    $("#tipo_documento > option[value='" + tipo_documento + "']").attr("selected", true);
                    $("#emailCliente").val(editarEmail);
                    swal({
                        type: "success",
                        title: "El cliente ha sido editado correctamente",
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                    }).then((result) => {
                        if (result.value) {
                            $("#modalEditarCliente").modal("hide");
                        } else {
                            $("#modalEditarCliente").modal("hide");
                            $("#modalEditarCliente").modal("hide");
                        }
                    })
                } else {
                    swal({
                        type: "error",
                        title: "El cliente no se ha editado",
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then((result) => {
                        if (result.value) {
                        }
                    })
                }
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        })
    } else {
        swal({
            type: "error",
            title: "¡El documento, nombre, direccion son campos obligatorios!",
            allowOutsideClick: false,
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        })
    }
});