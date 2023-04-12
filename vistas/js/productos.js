/*=============================================
CARGAR LA TABLA DINÁMICA DE PRODUCTOS
=============================================*/
// $.ajax({
// 	url: "ajax/datatable-productos.ajax.php",
// 	success:function(respuesta){
// 		console.log("respuesta", respuesta);
// 	}
// })
var idOculto=$("#idperfiloculto").val();
//console.log("idOculto",idOculto);
$('.tablaProductos').DataTable( {
    "ajax": "ajax/datatable-productos.ajax.php?idperfiloculto="+idOculto,
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
	}
} );
/*=============================================
CAPTURANDO LA CATEGORIA PARA ASIGNAR CÓDIGO
=============================================*/
/*$("#nuevaCategoria").change(function(){
	var idCategoria = $(this).val();
	var datos = new FormData();
  	datos.append("idCategoria", idCategoria);
  	$.ajax({
      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      	if(respuesta){
      		var nuevoCodigo = Number(respuesta["codigo"]) + 1;
          	$("#nuevoCodigo").val(nuevoCodigo);
      	}else if(idCategoria!=""){
      		var nuevoCodigo = idCategoria+"01";
      		$("#nuevoCodigo").val(nuevoCodigo);
      	}else{
      		$("#nuevoCodigo").val("");
      	}
      }
  	})
})*/
/*=============================================
AGREGANDO PRECIO DE VENTA
=============================================*/
/*$("#nuevoPrecioCompra, #editarPrecioCompra").change(function(){
	if($(".porcentaje").prop("checked")){
		var valorPorcentaje = $(".nuevoPorcentaje").val();
		var porcentaje = Number(($("#nuevoPrecioCompra").val()*valorPorcentaje/100))+Number($("#nuevoPrecioCompra").val());
		var editarPorcentaje = Number(($("#editarPrecioCompra").val()*valorPorcentaje/100))+Number($("#editarPrecioCompra").val());
		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly",true);
		$("#editarPrecioVenta").val(editarPorcentaje);
		$("#editarPrecioVenta").prop("readonly",true);
	}
})*/
function verificariva(){
  if($(".cambioIva").prop("checked")){
    //console.log("esta chekeado");
    if ($("#nuevoPrecioVenta").val()!=""&&$("#nuevoPrecioCompra").val()!="") {
    var porcentaje = (Number($("#nuevoPrecioVenta").val())-(Number($("#nuevoPrecioCompra").val()))*1.12)/Number($("#nuevoPrecioCompra").val());
    var procentajef=Number(porcentaje)*100;
    $("#porcentajeganancia").val(procentajef.toFixed(2));
    }
    var preciosiniva=$("#nuevoPrecioVenta").val()/1.12;
    $("#preciosiniva").val(preciosiniva.toFixed(2));
  }else{
    //console.log(" no esta chekeado");
    if ($("#nuevoPrecioVenta").val()!=""&&$("#nuevoPrecioCompra").val()!="") {
    var porcentaje = (Number($("#nuevoPrecioVenta").val())-Number($("#nuevoPrecioCompra").val()))/Number($("#nuevoPrecioCompra").val());
    var procentajef=Number(porcentaje)*100;
    $("#porcentajeganancia").val(procentajef.toFixed(2));
    }
    $("#preciosiniva").val($("#nuevoPrecioVenta").val());
  }
}
function verificarivae(){
  if($("#editar_iva").prop("checked")){
    if ($("#editarPrecioVenta").val()!=""&&$("#editarPrecioCompra").val()!="") {
    var porcentajee = (Number($("#editarPrecioVenta").val())-(Number($("#editarPrecioCompra").val()))*1.12)/Number($("#editarPrecioCompra").val());
    var procentajefe=Number(porcentajee)*100;
    $("#porcentajegananciae").val(procentajefe.toFixed(2));
    }
     var preciosinivae=$("#editarPrecioVenta").val()/1.12;
    $("#epreciosiniva").val(preciosinivae.toFixed(2));
  }else{
    if ($("#editarPrecioVenta").val()!=""&&$("#editarPrecioCompra").val()!="") {
    var porcentajee = (Number($("#editarPrecioVenta").val())-Number($("#editarPrecioCompra").val()))/Number($("#editarPrecioCompra").val());
    var procentajefe=Number(porcentajee)*100;
    $("#porcentajegananciae").val(procentajefe.toFixed(2));
    }
    $("#epreciosiniva").val($("#editarPrecioVenta").val());
  }
}
$("#nuevoPrecioCompra,#nuevoPrecioVenta").change(function(){
    verificariva();
    //var porcentajeeditar =(Number($("#editarPrecioVenta").val())-Number($("#editarPrecioCompra").val()))/Number($("#editarPrecioVenta").val());
    //var porcentajef=Number()  .toFixed(2);
    //var editarPorcentaje = Number(($("#editarPrecioCompra").val()*valorPorcentaje/100))+Number($("#editarPrecioCompra").val());
    //$("#nuevoPrecioVenta").prop("readonly",true);
    //$("#editarPrecioVenta").val(editarPorcentaje);
    //$("#editarPrecioVenta").prop("readonly",true);
})
$("#editarPrecioCompra,#editarPrecioVenta").change(function(){
    verificarivae();
    //var porcentajeeditar =(Number($("#editarPrecioVenta").val())-Number($("#editarPrecioCompra").val()))/Number($("#editarPrecioVenta").val());
    //var porcentajef=Number()  .toFixed(2);
    //var editarPorcentaje = Number(($("#editarPrecioCompra").val()*valorPorcentaje/100))+Number($("#editarPrecioCompra").val());
    //$("#nuevoPrecioVenta").prop("readonly",true);
    //$("#editarPrecioVenta").val(editarPorcentaje);
    //$("#editarPrecioVenta").prop("readonly",true);
})
$(".cambioIva").on("ifChanged",function(){
   $(".cambioIva").on("ifChecked",function(){
    if ($("#nuevoPrecioVenta").val()!=""&&$("#nuevoPrecioCompra").val()!="") {
    var porcentaje = (Number($("#nuevoPrecioVenta").val())-(Number($("#nuevoPrecioCompra").val()))*1.12)/Number($("#nuevoPrecioCompra").val());
    var procentajef=Number(porcentaje)*100;
    $("#porcentajeganancia").val(procentajef.toFixed(2));
    }
    if ($("#editarPrecioVenta").val()!=""&&$("#editarPrecioCompra").val()!="") {
    var porcentajee = (Number($("#editarPrecioVenta").val())-(Number($("#editarPrecioCompra").val()))*1.12)/Number($("#editarPrecioCompra").val());
    var procentajefe=Number(porcentajee)*100;
    $("#porcentajegananciae").val(procentajefe.toFixed(2));
    }
    var preciosiniva=$("#nuevoPrecioVenta").val()/1.12;
    $("#preciosiniva").val(preciosiniva.toFixed(2));
    var preciosinivae=$("#editarPrecioVenta").val()/1.12;
    $("#epreciosiniva").val(preciosinivae.toFixed(2));
   });
  $(".cambioIva").on("ifUnchecked",function(){
    if ($("#nuevoPrecioVenta").val()!=""&&$("#nuevoPrecioCompra").val()!="") {
    var porcentaje = (Number($("#nuevoPrecioVenta").val())-Number($("#nuevoPrecioCompra").val()))/Number($("#nuevoPrecioCompra").val());
    var procentajef=Number(porcentaje)*100;
    $("#porcentajeganancia").val(procentajef.toFixed(2));
    }
    if ($("#editarPrecioVenta").val()!=""&&$("#editarPrecioCompra").val()!="") {
    var porcentajee = (Number($("#editarPrecioVenta").val())-Number($("#editarPrecioCompra").val()))/Number($("#editarPrecioCompra").val());
    var procentajefe=Number(porcentajee)*100;
    $("#porcentajegananciae").val(procentajefe.toFixed(2));
    }
    $("#preciosiniva").val($("#nuevoPrecioVenta").val());
    $("#epreciosiniva").val($("#editarPrecioVenta").val());
  });
})
/*=============================================
CAMBIO DE PORCENTAJE
=============================================*/
/*$(".nuevoPorcentaje").change(function(){
	if($(".porcentaje").prop("checked")){
		var valorPorcentaje = $(this).val();
		var porcentaje = Number(($("#nuevoPrecioCompra").val()*valorPorcentaje/100))+Number($("#nuevoPrecioCompra").val());
		var editarPorcentaje = Number(($("#editarPrecioCompra").val()*valorPorcentaje/100))+Number($("#editarPrecioCompra").val());
		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly",true);
		$("#editarPrecioVenta").val(editarPorcentaje);
		$("#editarPrecioVenta").prop("readonly",true);
	}
})
$(".porcentaje").on("ifUnchecked",function(){
	$("#nuevoPrecioVenta").prop("readonly",false);
	$("#editarPrecioVenta").prop("readonly",false);
})
$(".porcentaje").on("ifChecked",function(){
	$("#nuevoPrecioVenta").prop("readonly",true);
	$("#editarPrecioVenta").prop("readonly",true);
})*/
/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/
$(".nuevaImagen").change(function(){
	var imagen = this.files[0];
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/
  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
  		$(".nuevaImagen").val("");
  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });
  	}else if(imagen["size"] > 8000000){
  		$(".nuevaImagen").val("");
  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen no debe pesar más de 2MB!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });
  	}else{
  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);
  		$(datosImagen).on("load", function(event){
  			var rutaImagen = event.target.result;
  			$(".previsualizarProducto").attr("src", rutaImagen);
        $(".previsualizar").attr("src", rutaImagen);
  		})
  	}
})
/*=============================================
EDITAR PRODUCTO
=============================================*/
$(".tablaProductos tbody").on("click", "button.btnEditarProducto", function(){
	var idProducto = $(this).attr("idProducto");
	var datos = new FormData();
    datos.append("idProducto", idProducto);
     $.ajax({
      url:"ajax/productos.administrador.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
        console.log("respuesta",respuesta);
          var datosCategoria = new FormData();
          datosCategoria.append("idCategoria",respuesta["id_categoria"]);
           $.ajax({
              url:"ajax/categorias.ajax.php",
              method: "POST",
              data: datosCategoria,
              cache: false,
              contentType: false,
              processData: false,
              dataType:"json",
              success:function(respuesta){
                  $("#editarCategoria").val(respuesta["idCategoria"]);
                  $("#editarCategoria").html(respuesta["categoria"]);
              }
          })
            $("#editarCodigo").val(respuesta["codigo"]);
            $("#idproducto").val(respuesta["id"]);
           $("#editarDescripcion").val(respuesta["descripcion"]);
           //$("#editarStock").val(respuesta["stock"]);
           if (respuesta["iva_producto"]=="S") {
            $('#editar_iva').iCheck('check');
            var porcentaje=(((respuesta["precio_venta"]-(respuesta["precio_compra"]*1.12))/respuesta["precio_compra"])*100);
            $("#porcentajegananciae").val(porcentaje.toFixed(2));
           }else{
            $('#editar_iva').prop('checked', false).iCheck('update');
            var porcentaje=(((respuesta["precio_venta"]-respuesta["precio_compra"])/respuesta["precio_compra"])*100);
            $("#porcentajegananciae").val(porcentaje.toFixed(2));
           }
           $("#editarPrecioCompra").val(respuesta["precio_compra"]);
           $("#epreciosiniva").val(respuesta["precio_siniva"]);
           $("#editarPrecioVenta").val(respuesta["precio_venta"]);
           if(respuesta["imagen"] != ""){
           	$("#imagenActual").val(respuesta["imagen"]);
           	$(".previsualizarProducto").attr("src",  respuesta["imagen"]);
           }else{
               $(".previsualizarProducto").attr("src","vistas/img/productos/default/anonymous.png");
          }
      }
  })
})
/*=============================================
ELIMINAR PRODUCTO
=============================================*/
$(".tablaProductos tbody").on("click", "button.btnEliminarProducto", function(){
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
        }).then(function(result){
        if (result.value) {
        	window.location = "index.php?ruta=productos&idProducto="+idProducto+"&imagen="+imagen+"&codigo="+codigo;
        }
	})
})