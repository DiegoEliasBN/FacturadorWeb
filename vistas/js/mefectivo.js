/*=============================================
EDITAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEditarMovimiento", function(){
	//console.log("entraste a editar el moviminto");
	var idMovimiento = $(this).attr("idMovimiento");
	console.log("idMovimiento",idMovimiento);
	var datos = new FormData();
	datos.append("idMovimiento", idMovimiento);
	$.ajax({
		url: "ajax/mefectivo.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		console.log("respuesta",respuesta);
     		$("#evalorMovimiento").val(respuesta[0]["valorMovimiento"]);
     		$("#eCodCajaM").val(respuesta[0]["CodApertura"]);
     		$("#eCodAlmacen").val(respuesta[0]["CodAlmacen"]);
     		$("#CodMovimiento").val(respuesta[0]["CodMovimiento"]);
     		$("#editarDescripcionM").val(respuesta[0]["descripcionMovimiento"]);
     	}
	})
})
/*=============================================
ELIMINAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEliminarMovimiento", function(){
	 var idMovimiento = $(this).attr("idMovimiento");
	 swal({
	 	title: '¿Está seguro de borrar el movimiento?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar Movimiento!'
	 }).then(function(result){
	 	if(result.value){
	 		window.location = "index.php?ruta=mefectivo&idMovimiento="+idMovimiento;
	 	}
	 })
})
$(".tablas").on("click", ".btnImprimirMovimiento", function(){
	var codigoVenta = $(this).attr("codigoMovimiento");
	var idAlmacen = $(this).attr("idAlmacen");
	window.open("extenciones/tcpdf/pdf/movimiento.php?codigo="+codigoVenta+"&idAlmacen="+idAlmacen, "_blank");
	//window.open("extenciones/tcpdf/pdf/pdf.php","_blank");
})
