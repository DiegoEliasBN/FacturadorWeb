/*=============================================
EDITAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEditarAlmacen", function(){
	var idAlmacen = $(this).attr("idAlmacen");
	//console.log("idAlmacen",idAlmacen);
	var datos = new FormData();
	datos.append("idAlmacen", idAlmacen);
	$.ajax({
		url: "ajax/almacen.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		console.log("respuesta",respuesta);
     		$("#editarRuc").val(respuesta[0]["ruc"]);
     		$("#editarAlmacen").val(respuesta[0]["NombreAlmacen"]);
     		$("#editarDireccion").val(respuesta[0]["DireccionAlmacen"]);
     		$("#editarTelefono").val(respuesta[0]["telefono"]);
     		$("#editarEmail").val(respuesta[0]["email"]);
     		$("#idAlmacen").val(respuesta[0]["CodAlmacen"]);
     	}
	})
})
/*=============================================
ELIMINAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEliminarAlmacen", function(){
	 var idAlmacen = $(this).attr("idAlmacen");
	 swal({
	 	title: '¿Está seguro de borrar la Sucursal?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar la Sucursal!'
	 }).then(function(result){
	 	if(result.value){
	 		window.location = "index.php?ruta=almacen&idAlmacen="+idAlmacen;
	 	}
	 })
})
$(".tablas").on("click", ".btnEntrar", function(){
	 var idAlmacen = $(this).attr("idAlmacenn");
	window.location = "index.php?ruta=nalmacen&idAlmacenn="+idAlmacen;
})
