var idAlmacenP = $("#productosAlmacen").val();
var idOculto = $("#idperfiloculto").val();
$('.tablaPAlmacen').DataTable({
    "ajax": "ajax/datatable-productosAlmacen.ajax.php?nuevo=" + idAlmacenP + "&idperfiloculto=" + idOculto,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});
$(".tablaPAlmacen tbody").on("click", "button.btnEditarProducto", function() {
    var idProducto = $(this).attr("idProducto");
    var datos = new FormData();
    datos.append("idProducto", idProducto);
    $.ajax({
        url: "ajax/productos.administrador.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            console.log("respuesta", respuesta);
            var datosCategoria = new FormData();
            datosCategoria.append("idCategoria", respuesta["id_categoria"]);
            $.ajax({
                url: "ajax/categorias.ajax.php",
                method: "POST",
                data: datosCategoria,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta) {
                    $("#editarCategoria").val(respuesta["idCategoria"]);
                    $("#editarCategoria").html(respuesta["categoria"]);
                }
            })
            $("#editarCodigo").val(respuesta["codigo"]);
            $("#idproducto").val(respuesta["id"]);
            $("#editarDescripcion").val(respuesta["descripcion"]);
            //$("#editarStock").val(respuesta["stock"]);
            if (respuesta["iva_producto"] == "S") {
                $('#editar_iva').iCheck('check');
                var porcentaje = (((respuesta["precio_venta"] - (respuesta["precio_compra"] * 1.12)) / respuesta["precio_compra"]) * 100);
                $("#porcentajegananciae").val(porcentaje.toFixed(2));
            } else {
                $('#editar_iva').prop('checked', false).iCheck('update');
                var porcentaje = (((respuesta["precio_venta"] - respuesta["precio_compra"]) / respuesta["precio_compra"]) * 100);
                $("#porcentajegananciae").val(porcentaje.toFixed(2));
            }
            $("#editarPrecioCompra").val(respuesta["precio_compra"]);
            $("#epreciosiniva").val(respuesta["precio_siniva"]);
            $("#editarPrecioVenta").val(respuesta["precio_venta"]);
            if (respuesta["imagen"] != "") {
                $("#imagenActual").val(respuesta["imagen"]);
                $(".previsualizarProducto").attr("src", respuesta["imagen"]);
            } else {
                $(".previsualizarProducto").attr("src", "vistas/img/productos/default/anonymous.png");
            }
        }
    })
})
/*=============================================
ELIMINAR PRODUCTO
=============================================*/
$(".tablaPAlmacen tbody").on("click", "button.btnEliminarProducto", function() {
    var idProducto = $(this).attr("idProducto");
    var codigo = $(this).attr("codigo");
    var imagen = $(this).attr("imagen");
    swal({
        title: '¿Está seguro de borrar el producto?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar producto!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=productos&idProducto=" + idProducto + "&imagen=" + imagen + "&codigo=" + codigo;
        }
    })
})